<?php

namespace App\Controller;

use App\GraphQL\Schema;
use GraphQL\Error\DebugFlag;
use GraphQL\Error\FormattedError;
use GraphQL\GraphQL as GraphQLBase;
use RuntimeException;
use Throwable;

class GraphQL
{
    public static function handle()
    {
        $origin = $_SERVER['HTTP_ORIGIN'] ?? '';
        $allowedOrigins = ['http://localhost:5173', 'http://127.0.0.1:5173'];

        if (in_array($origin, $allowedOrigins)) {
            header("Access-Control-Allow-Origin: $origin");
            header('Access-Control-Allow-Credentials: true');
        }

        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        header('Access-Control-Allow-Methods: POST, OPTIONS, GET');
        header('Access-Control-Max-Age: 86400');

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header('HTTP/1.1 204 No Content');
            header('Content-Length: 0');
            exit;
        }

        try {
            $rawInput = file_get_contents('php://input');
            if ($rawInput === false) {
                throw new RuntimeException('Failed to get php://input');
            }

            $input = json_decode($rawInput, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new RuntimeException('Invalid JSON: ' . json_last_error_msg());
            }

            $query = $input['query'] ?? null;
            $variables = $input['variables'] ?? null;

            if (empty($query)) {
                throw new RuntimeException('No GraphQL query provided');
            }

            $schema = Schema::build();

            $result = GraphQLBase::executeQuery(
                $schema,
                $query,
                null,
                null,
                $variables
            );

            $output = $result->toArray(
                DebugFlag::RETHROW_UNSAFE_EXCEPTIONS |
                DebugFlag::RETHROW_INTERNAL_EXCEPTIONS
            );
        } catch (Throwable $e) {
            error_log("GRAPHQL ERROR: " . $e->getMessage());
            error_log($e->getTraceAsString());

            $output = [
                'errors' => [[
                    'message' => $e->getMessage(),
                    'extensions' => [
                        'file'  => $e->getFile(),
                        'line'  => $e->getLine(),
                        'trace' => explode("\n", $e->getTraceAsString()),
                    ]
                ]]
            ];
        }
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($output);
        exit;
    }
}

<?php

namespace App\GraphQL;

use GraphQL\Type\Schema as GraphQLSchema;
use GraphQL\Type\SchemaConfig;
use App\GraphQL\QueryType;
use App\GraphQL\MutationType;

class Schema
{
    public static function build(): GraphQLSchema
    {
        $config = SchemaConfig::create()
            ->setQuery(QueryType::get())
            ->setMutation(MutationType::get());

        return new GraphQLSchema($config);
    }
}

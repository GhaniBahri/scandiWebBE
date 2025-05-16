<?php
ini_set('display_errors', 'on');
ini_set('html_errors', 'on');
// ini_set('display_errors', 'off');
// ini_set('html_errors', 'off');
ini_set('error_reporting', E_ALL);

date_default_timezone_set('Africa/Algiers');

define('__RACINE', '/hotelo/');
define('NOM_DE_SITE', '/hotelo/');
define('__PATH', dirname(__DIR__) . '/');
define('__HOME', 'localhost');

define("DB_HOST", "localhost");
define("DB_NAME", "scandiweb");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_SERVER", "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8");

session_start();
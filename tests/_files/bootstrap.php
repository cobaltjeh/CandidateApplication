<?php

/*
 * Define required constants
 */
define('APP_ROOT', realpath(__DIR__ . '/../..') . DIRECTORY_SEPARATOR);
define('SRC_ROOT', realpath(__DIR__ . DIRECTORY_SEPARATOR . '..') . DIRECTORY_SEPARATOR);
define('LOG', APP_ROOT . 'logs' . DIRECTORY_SEPARATOR);

/*
 * Set some php defaults required for the project
 */
error_reporting(-1);
ini_set('display_errors', 'On');
ini_set('error_log', LOG . 'phpunit.log');
ini_set('log_errors', 'On');
date_default_timezone_set('UTC');
mb_internal_encoding('utf-8');

// Include autoloader and application
require_once APP_ROOT . 'vendor/autoload.php';

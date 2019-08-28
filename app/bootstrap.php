<?php

declare(strict_types = 1);

/**
 * Bootstrap file for development
 */

require_once __DIR__ . '/../vendor/autoload.php';

error_reporting(-1);
ini_set('display_errors', 'On');
ini_set('error_log', 'php://stderr');
ini_set('log_errors', 'On');
date_default_timezone_set('UTC');
mb_internal_encoding('utf-8');

return new App\Kernel('dev', true);

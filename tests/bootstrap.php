<?php

/**
 * Bootstrapping for the flexslider unit tests
 *
 * @package flexslider
 * @author  Dynamic <dev@dynamicagency.com>
 */
require '../vendor/autoload.php';
define('FLEXSLIDER_BASE_DIR', realpath(__DIR__ . '/..'));

global $_FILE_TO_URL_MAPPING;
$_FILE_TO_URL_MAPPING[FLEXSLIDER_BASE_DIR] = 'http://localhost';

global $databaseConfig;
$databaseConfig = [
    'type'     => 'MySQLDatabase',
    'server'   => '127.0.0.1',
    'username' => 'root',
    'password' => '',
    'database' => 'flexslider-tests'
];
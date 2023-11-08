<?php

$rootDir = dirname(dirname(dirname(__FILE__)));
require_once $rootDir . '/vendor/autoload.php';

if ( !realpath($rootDir . '/vendor/') )
{
    die('Execute `composer install` before running tests.');
}

// Bootstrap WP_Mock to initialize built-in features
WP_Mock::bootstrap();

unset($rootDir);

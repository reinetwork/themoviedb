<?php

// PHPUnit is a memory hog
ini_set('memory_limit', -1);

// Want to see all errors
error_reporting(-1);

// PHP Requires default timezone
date_default_timezone_set('UTC');

// Include the composer autoloader
require __DIR__ . '/../vendor/autoload.php';

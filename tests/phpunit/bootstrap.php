<?php
/**
 * Unit tests bootstrap script.
 *
 * @package FelixArntz\Values
 * @license GNU General Public License, version 2
 * @link    https://github.com/felixarntz/values
 */

// Detect project directory.
define('TESTS_LIBRARY_DIR', dirname(dirname(__DIR__)));

// Include autoloader.
require TESTS_LIBRARY_DIR . '/vendor/autoload.php';

// PHPUnit < 6.0 compatibility shim.
require_once __DIR__ . '/phpunit-compat.php';

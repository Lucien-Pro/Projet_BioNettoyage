<?php
/**
 * Application Entry Point
 */

require_once '../config/config.php';

// Autoload Core Classes
spl_autoload_register(function($className) {
    // Convert namespace to file path
    $file = '../' . str_replace('\\', '/', $className) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

use App\Core\Router;

// Init Router
$init = new Router();

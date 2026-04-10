<?php
/**
 * Application Configuration
 */

// Database configuration
define('DB_HOST', getenv('DB_HOST') ?: 'db');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'bionet_db');

// App Root
define('APPROOT', dirname(dirname(__FILE__)) . '/app');

// URL Root (Adjust this to your environment)
define('URLROOT', getenv('URLROOT') ?: 'http://localhost:8080');

// Site Name
define('SITENAME', 'BioNet Traçabilité');

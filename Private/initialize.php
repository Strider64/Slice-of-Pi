<?php

// **PREVENTING SESSION HIJACKING**

/* Turn on error reporting */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

if (filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_URL) == "localhost") {
    error_reporting(-1); // -1 = on || 0 = off
} else {
    error_reporting(0); // -1 = on || 0 = off
    // Prevents javascript XSS attacks aimed to steal the session ID
    ini_set('session.cookie_httponly', 1);

// **PREVENTING SESSION FIXATION**
// Session ID cannot be passed through URLs
    ini_set('session.use_only_cookies', 1);

// Uses a secure connection (HTTPS) if possible
    ini_set('session.cookie_secure', 1);
}

define("APP_ROOT", dirname(dirname(__FILE__)));
define("PRIVATE_PATH", APP_ROOT . "/private");
define("PUBLIC_PATH", APP_ROOT . "/public");

require_once PRIVATE_PATH . "/vendor/autoload.php";
require_once PRIVATE_PATH . "/security/security.php";
require_once PRIVATE_PATH . "/throttle/throttle_functions.php";
require_once PRIVATE_PATH . "/config/config.php";
require_once PRIVATE_PATH . '/pdo_blog/pdo_blog_functions.php';





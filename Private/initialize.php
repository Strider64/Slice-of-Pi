<?php
/* Turn on error reporting */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

if (filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_URL) == "localhost") {
    error_reporting(-1); // -1 = on || 0 = off
} else {
    error_reporting(0); // -1 = on || 0 = off
}

define("APP_ROOT", dirname(dirname(__FILE__)));
define("PRIVATE_PATH", APP_ROOT . "/private");
define("PUBLIC_PATH", APP_ROOT . "/public");

require_once PRIVATE_PATH . "/vendor/autoload.php";
require_once PRIVATE_PATH . "/security/security.php";
require_once PRIVATE_PATH . "/config/config.php";

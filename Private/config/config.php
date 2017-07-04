<?php
$server_name = filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_URL);
define('BASE_PATH', realpath(dirname(__FILE__)));
/* Setup constants for local server and remote server */
define('EMAIL_HOST', 'email_host');
define('EMAIL_USERNAME', 'email_username');
define('EMAIL_PASSWORD', 'email_password');
define('EMAIL_ADDRESS', 'email_address');
define('EMAIL_PORT', 587);
define('PRIVATE_KEY', 'Google_ReCaptcha_Private_Key');
if (filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_URL) == "localhost") {
    define('DATABASE_HOST', 'localhost'); // usually localhost
    define('DATABASE_NAME', 'cms');
    define('DATABASE_USERNAME', 'username');
    define('DATABASE_PASSWORD', 'password');
    define('DATABASE_TABLE', 'users');
} else {
    define('DATABASE_HOST', 'remote_database_host');
    define('DATABASE_NAME', 'remote_db_name');
    define('DATABASE_USERNAME', 'remote_username');
    define('DATABASE_PASSWORD', 'remote_password');
    define('DATABASE_TABLE', 'users');
}

header("Content-Type: text/html; charset=utf-8");
header('X-Frame-Options: SAMEORIGIN'); // Prevent Clickjacking:
header('X-Content-Type-Options: nosniff');
header('x-xss-protection: 1; mode=block');
header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
//header("content-security-policy: default-src 'self'; report-uri /csp_report_parser");
header('X-Permitted-Cross-Domain-Policies: master-only');

/* Get the current page */
$phpSelf = filter_input(INPUT_SERVER, 'PHP_SELF', FILTER_SANITIZE_URL);
$path_parts = pathinfo($phpSelf);
$basename = $path_parts['basename']; // Use this variable for action='':
$pageName = ucfirst($path_parts['filename']);

date_default_timezone_set('America/Detroit');

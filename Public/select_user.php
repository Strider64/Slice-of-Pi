<?php

require_once '../private/initialize.php';

use Library\Display\Display;

$status = FALSE;
$display = new Display();

if (is_logged_in()) {
    $status = TRUE;
}
/* Makes it so we don't have to decode the json coming from Javascript */
header('Content-type: application/json');


/* Start of your php routine(s) */
$submit = filter_input(INPUT_POST, 'submit', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if (isset($submit)) {
    $user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if ((int) $user_id === 0) {
        $user_id = getSysopId();
    }
    $data = $display->readBlog("blog.php", $user_id);
    if ((isset($_SESSION['user']) && $_SESSION['user']->id === (int) $user_id) || (isset($_SESSION['user']) && $_SESSION['user']->security_level === 'sysop')) {
        $temp = true;
    } else {
        $temp = false;
    }
    if (!empty($data)) {
        array_unshift($data, $temp);
        output($data);
    } else {
        output(['status' => 'empty']);
    }
}
/* End of your php routine(s) */

/*
 * If you know you have a control error, for example an end-of-file the output it to the errorOutput() function
 */

function errorOutput($output, $code = 500) {
    http_response_code($code);
    echo json_encode($output);
}

/*
 * If everything validates OK then send success message to Ajax / JavaScript
 */

function output($output) {
    http_response_code(200);
    echo json_encode($output);
}

<?php

require_once '../private/initialize.php';

use Library\CMS\CMS;

protected_page();

$cms = new CMS();
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    /*
     * Delete the image and the record from the database table cms
     */    
    $id = filter_var($_GET['id']);
    
    $image_path = $cms->readImagePath($id);
    if (filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_URL) !== "localhost") {
        /* Change back to original path if on the remote server. */
        $image_path = str_ireplace( "https://www.pepster.com/","../public/", $image_path); 
    }

    unlink($image_path);

    $result = $cms->deleteRecord($id);
} elseif (isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

if ($result) {
    header("Location: members_page.php");
    exit();
} else {
    echo "Oops, something went wrong!";
}


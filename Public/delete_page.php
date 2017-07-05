<?php

require_once '../private/initialize.php';

use Library\CMS\CMS;

protected_page();
if (isset($_SESSION['user']) && $_SESSION['user']->security_level !== 'sysop') {
    header("Location: index.php");
    exit();
}
$cms = new CMS();
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    $id = filter_var($_GET['id']);
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


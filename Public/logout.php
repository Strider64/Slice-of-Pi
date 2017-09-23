<?php

require_once '../private/initialize.php';

after_successful_logout();
header("Location: members_page.php");
exit;

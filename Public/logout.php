<?php

require_once '../private/initialize.php';

after_successful_logout();
header("Location: index.php");
exit;

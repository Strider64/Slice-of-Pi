<?php

use Library\Database\Database as DB;

function getUserInfo() {
    $db = DB::getInstance();
    $pdo = $db->getConnection(); // I am assuming you know how to write a PDO connection string:
    $query = 'SELECT id, username, full_name, security_level, private FROM users';
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $data;
}

function displaySelectNames(array $names, $basename, $status, $user_id) {
    echo '<form id="selectBlog" action = "' . $basename . '" method = "post">' . "\n";
    echo "\t\t\t" . '<input type="hidden" name="action" value="selection">' . "\n";
    echo "\t\t\t" . '<input type="hidden" name="token" value="' . $_SESSION['token'] . '">' . "\n";
    echo "\t\t\t" . '<input id="statusCheck" type="hidden" name="status" value="' . $status . '">' . "\n";
    echo "\t\t\t" . "<label>Select User</label>\n";
    echo "\t\t\t" . '<div id="selectUser">' . "\n";
    echo "\t\t\t\t" . '<select id="selectBtn" name = "user_id">' . "\n";
    //echo '<option value="' . $user_id . '" selected>' . $data[0]->author . '</option>' . "\n";
    foreach ($names as $name) {
        if ($name['id'] == $user_id) {
            $selected = "selected";
        } else {
            $selected = null;
        }
        if ($name['private'] === 'no') {
            echo "\t\t\t\t\t" . '<option value="' . $name['id'] . '" ' . $selected . '>' . $name['full_name'] . '</option>' . "\n";
        } elseif ($name['id'] === $_SESSION['user']->id || $_SESSION['user']->security_level == 'sysop') {
            echo "\t\t\t\t\t" . '<option value="' . $name['id'] . '" ' . $selected . '>' . $name['full_name'] . '</option>' . "\n";
        }
    }
    echo "\t\t\t\t</select>\n";
    echo "\t\t\t" . "</div>\n";
    echo "\t\t\t" . '<input id="blogSubmitBtn" type = "submit" name = "submit" value = "submit button">' . "\n";
    echo "\t\t" . "</form>\n";
}

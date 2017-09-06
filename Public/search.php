<?php
require_once '../private/initialize.php';

use Library\Database\Database as DB;

function search($search) {
    $db = DB::getInstance();

    $pdo = $db->getConnection();

    $query = 'SELECT * FROM cms WHERE CONCAT(heading, content) LIKE ?';  // I suggest to lose the ` ticks:

    $stmt = $pdo->prepare($query);

    $stmt->execute(['%' . $search . '%']);

    return $stmt;
}

$search = filter_input(INPUT_POST, 'search', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


if (isset($search)) {
    $result = search($search);
}
?>
<!DOCTYPE html>

<html>
    <head lang="en">
        <title>Display 3 Columns</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            #box-table-b
            {
                font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
                font-size: 12px;
                margin: 45px;
                width: 100%;
                max-width: 800px;
                text-align: center;
                border-collapse: collapse;
                border-bottom: 25px solid orange;
            }
            #box-table-b th
            {
                width: 33.33333%;
                font-size: 13px;
                font-weight: normal;
                padding: 8px;
                background-color: orange;
                border-right: 1px solid #9baff1;
                border-left: 1px solid #9baff1;
                color: #fff;
            }
            #box-table-b td
            {
                padding: 8px;
                background: #e8edff; 
                border-right: 1px solid #aabcfe;
                border-left: 1px solid #aabcfe;
                color: #669;
                vertical-align: text-top;
            }
            .content {
                text-align: left;
            }
        </style>
    </head>
    <body>
        <form id="search" action="" method="post">
            <label for="search">Search</label>
            <input id="search" type="text" name="search" value="">
            <input type="submit" name="submit" value="enter">
        </form>
        <?php
        if (isset($result)) {
            echo '<table id = "box-table-b" summary = "Most Favorit Movies">' . "\n";
            echo "<thead>\n";
            echo "<tr>\n";
            echo '<th scope = "col">Title</th>' . "\n";
            echo '<th scope = "col">Content</th>' . "\n";
            echo '<th scope = "col">Date Added</th>' . "\n";
            echo "</tr>\n";
            echo "</thead>\n";
            echo "<tbody>\n";

            foreach ($result as $row) {
                echo "<tr>\n";
                echo "<td>" . $row['heading'] . "</td>\n";
                echo "<td class=\"content\">" . $row['content'] . "</td>\n";
                echo "<td>" . $row['date_added'] . "</td>\n";
                echo "</tr>\n";
            }


            echo "</tbody>\n";
            echo "</table>\n";
        }
        ?>

    </body>
</html>
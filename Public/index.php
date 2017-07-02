<?php
require_once '../private/initialize.php';

use Library\Calendar\Calendar;
use Library\CMS\CMS;

$cms = new CMS();


$calendar = new Calendar();

$calendar->phpDate();
require_once '../private/includes/header.inc.php';
?>
<div class="container mainContent">

    <div id="left_column" class="span6">
        <?php
        $leftcol = $cms->read($basename, 'left');
        while ($row = $leftcol->fetch(PDO::FETCH_OBJ)) {
            echo '<article class="content">' . "\n";

            echo "<h1>" . $row->heading . "</h1>\n";

            if ($row->image_path) {
                echo '<figure class="imageStyle">' . "\n";
                echo '<img src="' . $row->image_path . '" alt="">' . "\n";
                echo '<figcaption>&nbsp;</figcaption>' . "\n";
                echo "</figure>\n";
            }
            echo "<p>" . htmlspecialchars($row->content) . "</p>\n";
            echo "</article>\n";
        }
        ?>
    </div>
    <div id="right_column" class="span6">
        <?php
        $rightcol = $cms->read($basename, 'right');
        while ($row = $rightcol->fetch(PDO::FETCH_OBJ)) {
            echo '<article class="content">' . "\n";
            echo "<h1>" . $row->heading . "</h1>\n";
            if ($row->image_path) {
                echo '<figure class="imageStyle">' . "\n";
                echo '<img src="' . $row->image_path . '" alt="">' . "\n";
                echo '<figcaption>&nbsp;</figcaption>' . "\n";
                echo "</figure>\n";
            }
            echo "<p>" . htmlspecialchars($row->content) . "</p>\n";
            echo "</article>\n";
        }
        ?>    
    </div>

</div>
</body>
</html>

<?php
require_once '../private/initialize.php';

use Library\Calendar\Calendar;

$calendar = new Calendar();

$calendar->phpDate();
require_once '../private/includes/header.inc.php';
?>
        <div class="container mainContent">
<!--            <div id="calendarBox">
                <?= $calendar->generateCalendar(); ?>
            </div>-->
        </div>
    </body>
</html>

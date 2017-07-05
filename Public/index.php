<?php
require_once '../private/initialize.php';

use Library\Calendar\Calendar;
use Library\Display\Display;

$display = new Display();

$calendar = new Calendar();

$calendar->phpDate();
require_once '../private/includes/header.inc.php';
?>
<div class="container mainContent">
    <article class="content">
        <?php $display->read($basename, 'left') ?> 
    </article>
    <article class="content">
        <?php $display->read($basename, 'right') ?> 
    </article>
</div>
<?php
require_once '../private/includes/footer.inc.php';

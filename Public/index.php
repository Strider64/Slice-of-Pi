<?php
require_once '../private/initialize.php';

use Library\Calendar\Calendar;
use Library\Display\Display;
use Library\Slider\Slider;

$slider = new Slider(); // Create and instance of the Slider Class
$display = new Display();

$calendar = new Calendar();

$calendar->phpDate();
require_once '../private/includes/header.inc.php';
?>
<div id="website" class="container">
    <div class="span6">
        <?php
        $display->read($basename, 'left');
        echo $display->display();
        ?> 
    </div>
    <div class="span6">
        <?php
        $display->read($basename, 'right');
        echo $display->display();
        ?> 
    </div>
</div>
<?php
require_once '../private/includes/footer.inc.php';

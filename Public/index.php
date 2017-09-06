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
<div class="container mainPage">
    <div id="carousel" class="span6">
        <?php
            /*
             * Dump all the images from a particular directory into HTML format, so that they can be used for a simple 
             * JavaScript (or CSS) Slider. 
             */
            $slider->outputImages();
        ?>
    </div>
    <div id="info" class="span6">
        <?php
        $display->read($basename, 'middle');
        $display->display();
        ?> 
    </div>
</div>
<div class="container mainContent">
    <article class="content">
        <?php
        $display->read($basename, 'left');
        $display->display();
        ?> 
    </article>
    <article class="content">
        <?php
        $display->read($basename, 'right');
        $display->display();
        ?>         
    </article>
</div>
<?php
require_once '../private/includes/footer.inc.php';

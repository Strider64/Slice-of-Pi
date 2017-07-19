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
        <?php
        $display->read($basename, 'left');
        $display->display();
        ?> 
    </article>
    <article class="content">
        <h1>All the Images</h1>
        <h2 class="subheading">Created on July 19, 2017 by John Pepp</h2>
        <figure class="imageStyle">
            <?php
            $supported_file = [
                'gif',
                'jpg',
                'jpeg',
                'png'
            ];
            $files = glob("assets/uploads/*.*");
            echo '<ul id="slides">' . "\n";
            for ($i = 0; $i < count($files); $i++) {
                $image = $files[$i]; // Just making it easier to understand that $files[$i] are the individual image in the loop:
                $ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
                if (in_array($ext, $supported_file)) {
                    /*
                     * echo basename($image); ### Shows name of image to show full path use just $image:
                     */
                    if ($i === 0) {
                        echo '<li class="slide showing"><img src="' . htmlspecialchars($image) . '" alt="Slide Show Image"></li>' . "\n";
                    } else {
                        echo '<li class="slide"><img src="' . htmlspecialchars($image) . '" alt="Slide Show Image"></li>' . "\n";
                    }
                } else {
                    continue;
                }
            }
            echo "</ul>\n";
            ?>
        </figure>
        <p>I have taken all the images on this website and made it a simple slide show!</p>
        <br><br>
        <?php
        $display->read($basename, 'right');
        $display->display();
        ?>         
    </article>
</div>
<?php
require_once '../private/includes/footer.inc.php';

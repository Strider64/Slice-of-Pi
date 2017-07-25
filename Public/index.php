<?php
require_once '../private/initialize.php';

use Library\Calendar\Calendar;
use Library\Display\Display;

$display = new Display();

$calendar = new Calendar();

$calendar->phpDate();
require_once '../private/includes/header.inc.php';
?>
<div class="container mainPage">
    <div id="carousel" class="span6">
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
    </div>
    <div id="info" class="span6">
        <h1>A Simple Slide Show</h1>
        <p>This is a dynamic PHP and Javascript slide show that shows all the pictures on the website and will update when new pictures are added to the uploads folder. Read down on the left column to get a overall view of what this website is all about and I also have been keeping a daily blog of the status of the website plus an introspect of my daily life. In the next couple of months I will be improving this website and from time to time you might actually see the updates happen in real time.</p> 
        <br>
        <p>I have improved greatly since earning an Associates degree in Computer Graphics: Interactive Media and Game Design. Feel free to contact me via this website's contact form and I will get back to you as soon as I can.</p>
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

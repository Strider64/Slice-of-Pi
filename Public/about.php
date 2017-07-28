<?php
require_once '../private/initialize.php';

use Library\Display\Display;

$display = new Display($basename, 'left');
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
        <h1>Interesting and Useful Links!</h1>
        <h2 class="subheading">Created on Tuesday, July 25, 2017 by John Pepp</h2>
        <figure class="imageStyle">
            <img src="assets/images/img-computer-mouse.png" alt="Links">
            <figcaption>&nbsp;</figcaption>
        </figure>
        <p>I'm posting some external links to websites that I feel will benefit a fellow developer just starting off in developing and designing websites. The first link is to my repository at Github of this very website and here's the link:
            <a class="links" href="https://github.com/Strider64/Slice-of-Technology">https://github.com/Strider64/Slice-of-Technology</a>
        Most of the the files needed to build this website is posted there except for Swiftmailer, but installing Swiftmailer should be pretty easy to do.</p>
    </article>
</div>
<?php
require_once '../private/includes/footer.inc.php';


<?php
require_once '../private/initialize.php';

use Library\Display\Display;

$display = new Display();
require_once '../private/includes/header.inc.php';
?>
<div class="container outerBlog">
    <article class="blogContent">
        <?php
        $display->read($basename, 'left', 'DESC');
        $display->display();
        ?> 
    </article>
</div>
<?php
require_once '../private/includes/footer.inc.php';
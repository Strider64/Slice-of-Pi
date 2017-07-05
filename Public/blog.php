<?php
require_once '../private/initialize.php';

use Library\Display\Display;

$display = new Display($basename, 'left');
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
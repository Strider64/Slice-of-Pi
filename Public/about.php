<?php

require_once '../private/initialize.php';

use Library\Display\Display;

$display = new Display();

require_once '../private/includes/header.inc.php';
?>
<div class="container mainContent">

    <div id="left_column" class="span6">
        <?php $display->read($basename, 'left') ?> 
    </div>
    <div id="right_column" class="span6">
        <?php $display->read($basename, 'right') ?> 
    </div>
</div>
<?php

require_once '../private/includes/footer.inc.php';


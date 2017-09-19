<?php
require_once '../private/initialize.php';

use Library\Display\Display;

$status = is_logged_in() ? TRUE : FALSE;

//echo "<pre>" . print_r($_SESSION, 1) . "</pre>\n";
$display = new Display();
$names = getUserInfo(); // Get ids and names of bloggers:
//echo "<pre>" . print_r($names, 1) . "<pre>\n";
$user_ids = $display->getUserIds();
$submit = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if (isset($submit) && $submit === 'selection' && hash_equals($_SESSION['token'], $token)) {
    //echo "<pre>" . print_r($_POST, 1) . "</pre>\n";
    $user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
    $data = $display->readBlog('blog.php', $user_id);
} else {
    $user_id = 65;
    $data = $display->readBlog($basename, $user_id);
}



require_once '../private/includes/header.inc.php';
?>
<div id="website" class="container">

    <div id="blogPostings" class="span8">
        <?php
        $display->readBlog("blog.php", $user_id);

        echo $display->display();
        ?> 
    </div>
    
    <div id="ajaxPostings" class="span8">
        
    </div>
    <div id="blogInfo" class="span4">
        <h2>The Daily Blog</h2>
        <?php
        echo '<form id="selectBlog" action = "' . $basename . '" method = "post">' . "\n";
        echo '<input type="hidden" name="action" value="selection">' . "\n";
        echo '<input type="hidden" name="token" value="' . $_SESSION['token'] . '">';
        echo '<input id="statusCheck" type="hidden" name="status" value="' . $status . '">';
        echo "<label>Select User</label>\n";
        echo '<div id="selectUser">' . "\n";
        echo '<select id="selectBtn" name = "user_id">' . "\n";
        //echo '<option value="' . $user_id . '" selected>' . $data[0]->author . '</option>' . "\n";
        foreach ($names as $name) {
            if ($name['id'] == $user_id) {
                $selected = "selected";
            } else {
                $selected = null;
            }
            if ($name['private'] === 'no') {
                echo '<option value="' . $name['id'] . '" ' . $selected . '>' . $name['full_name'] . '</option>' . "\n";
            } elseif ($name['id'] === $_SESSION['user']->id || $_SESSION['user']->security_level == 'sysop') {
               echo '<option value="' . $name['id'] . '" ' . $selected . '>' . $name['full_name'] . '</option>' . "\n";
            }
        }
        echo "</select>\n";
        echo "</div>\n";
        echo '<input id="blogSubmitBtn" type = "submit" name = "submit" value = "submit button">' . "\n";
        echo "</form>\n";
        ?>
        <p>Thank You for visiting my blog section of my website! I'm finally getting around to developing this page, so please excuse the dust. I will be actively working on this page in the next couple of weeks and hopefully be finishing it by then.</p>
    </div>
</div>
<?php
require_once '../private/includes/footer.inc.php';

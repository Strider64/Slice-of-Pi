<?php
require_once '../private/initialize.php';

//$abspath=$_SERVER['DOCUMENT_ROOT']; 
//echo $abspath . '/sliceofpi06212017/public/assets/uploads/' ;
use Library\Display\Display;

$status = is_logged_in() ? TRUE : FALSE;

$enter = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if (isset($enter) && $enter === "enter") {

    $private = filter_input(INPUT_POST, 'private', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if ($private === 'on') {
        $value = 'yes';
    } else {
        $value = 'no';
    }

    changePrivacy($value);
}

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
    if (is_logged_in()) {
        $user_id = $_SESSION['user']->id;
    } else {
        $user_id = getSysopId();
    }    
    $data = $display->readBlog($basename, $user_id);
}


if (is_logged_in()) {
    $login_status = $_SESSION['user']->id;
} else {
    $login_status = 0;
}
require_once '../private/includes/header.inc.php';
?>
<div id="website" class="container" data-bind="<?= $login_status; ?>">

    <div id="blogPostings" class="span8">
        <?php
        $display->readBlog($basename, $user_id);

        echo $display->display();
        ?> 
    </div>

    <div id="ajaxPostings" class="span8">

    </div>
    <div id="blogInfo" class="span4">
        <h2>The Daily Blog</h2>
        <?= displaySelectNames($names, $basename, $status, $user_id); ?>
        <p>This is a FREE blog that anyone can use and you can keep it private for your eyes only. Note, I have the right to check the private posts after all I am running this website, so don't write anything of  a confidential nature. Though hopefully you will make it public for everyone to see. To write a new post to your blog you must be logged in and then simply click the button below (it will show up when you're logged in). I have made it where you can change your privacy mode right here on this blog page. </p>

        <?php
        echo is_logged_in() ? '<a id="blogButton" href="members_page.php">new blog</a>' . "\n" : NULL;

        if (is_logged_in()) {
            if ($_SESSION['user']->private === 'yes') {
                $checked = 'checked';
            } else {
                $checked = \NULL;
            }
            echo '<form id="private" action="' . $basename . '" method="post">';
            echo '<h2>Private Posts is Turned </h2>';
            echo '<div class="slideThree">';
            echo '<input type="hidden" name="action" value="enter">';
            if ($_SESSION['user']->private === 'yes') {
                $checked = 'checked';
            } else {
                $checked = \NULL;
            }
            echo '<input id="slideThree" type="checkbox" name="private"  value="on" ' . $checked . ' >';
            echo '<label class="radioLabel" for="slideThree"></label>';
            echo '</div>';
            echo '<input id="privateBtn" type="submit" name="enter" value="change">';
            echo '</form>';
        }
        ?>
    </div>
</div>
<?php
require_once '../private/includes/footer.inc.php';

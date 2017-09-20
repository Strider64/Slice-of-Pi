<?php
require_once '../private/initialize.php';

//$abspath=$_SERVER['DOCUMENT_ROOT']; 
//echo $abspath . '/sliceofpi06212017/public/assets/uploads/' ;
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
        <?= displaySelectNames($names, $basename, $status, $user_id); ?>
        <p>This is a FREE blog that anyone can use and you can keep it private for your eyes only. Note, I have the right to check the private posts after all I am running this website, so don't write anything of  a confidential nature. Though hopefully you will make it public for everyone to see. To write a new post for your blog you must be logged in and then simply click the button below.</p>

        <?php echo is_logged_in() ? '<a id="blogButton" href="members_page.php">new blog</a>' . "\n" : NULL; ?>
    </div>
</div>
<?php
require_once '../private/includes/footer.inc.php';

<?php
require_once '../private/initialize.php';

use Library\CMS\CMS;

protected_page();

$cms = new CMS();

if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    $id = filter_var($_GET['id']);
    $result = $cms->readId($id);
} elseif (isset($_GET['id'])) {
    $host = filter_input(INPUT_SERVER, 'HTTP_HOST', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    //$host = $_SERVER['HTTP_HOST'];
    $php_self = filter_input(INPUT_SERVER, 'PHP_SELF', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $uri = rtrim(dirname($php_self), '/\\');
    $extra = 'members_page.php';
    header("Location: http://$host$uri/$extra");
    exit;
}

if (isset($_SESSION['user']) && $_SESSION['user']->security_level !== 'sysop') {
    if (isset($result->id) && $_SESSION['user']->id !== $result->user_id) {
        $host = filter_input(INPUT_SERVER, 'HTTP_HOST', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $php_self = filter_input(INPUT_SERVER, 'PHP_SELF', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $uri = rtrim(dirname($php_self), '/\\');
        $extra = 'index.php';
        header("Location: http://$host$uri/$extra");
        exit;
    }
}

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_URL);

if ($action && $action === 'enter') {
    $data['id'] = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $data['heading'] = filter_input(INPUT_POST, 'heading', FILTER_DEFAULT);
    $data['content'] = filter_input(INPUT_POST, 'content', FILTER_DEFAULT);

    $status = $cms->update($data);
    if ($status) {
        header("Location: " . $status);
        exit();
    }
}



require_once '../private/includes/header.inc.php';
?>
<div class="container mainContent white">
    <div id="left_section" class="span6">
        <form id="dataEntry" action="edit.php" method="post" enctype="multipart/form-data">
            <fieldset id="mainEntry">
                <legend>Edit Page</legend>
                <input type="hidden" name="action" value="enter">
                <input type="hidden" name="id" value="<?php echo $result->id; ?>">
                <input type="hidden" name="user_id" value="<?php echo $result->user_id; ?>">
                <input type="hidden" name="column_pos" value="<?php echo $result->column_pos; ?>">
                <input type="hidden" name="image_path" value="<?php echo $result->image_path; ?>">

                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user']->id; ?>">
                <input type="hidden" name="action" value="enter">
                <input id="imgBtn" type="file" name="file">
                <label class="inputLabel" for="heading">Heading</label>
                <input id="heading" type="text" name="heading" value="<?php echo $result->heading; ?>" tabindex="1" autofocus>
                <label class="textareaLabel" for="content">Content</label>
                <textarea id="content" name="content" tabindex="2"><?php echo $result->content; ?></textarea>
                <input type="submit" name="submit" value="enter">
            </fieldset>
        </form>
    </div>
</div>
<?php
require_once '../private/includes/footer.inc.php';

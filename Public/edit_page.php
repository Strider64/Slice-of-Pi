<?php
require_once '../private/initialize.php';

use Library\CMS\CMS;

protected_page();

$page = ['index.php' => '<option value="index.php" selected>Home Page</option>', 'about.php' => '<option value="about.php">About Page</option>', 'members_page.php' => '<option value="members_page.php">Member Blog Page</option>'];
$cms = new CMS();

if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    $id = filter_var($_GET['id']);
    $result = $cms->readId($id);
} elseif (isset ($_GET['id'])) {
    header("Location: members_page.php");
    exit();
}

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_URL);

if ($action && $action === 'enter') {
    $data['id'] = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $data['heading'] = filter_input(INPUT_POST, 'heading', FILTER_DEFAULT);
    $data['content'] = filter_input(INPUT_POST, 'content', FILTER_DEFAULT);
    
    $status = $cms->update($data);
    if ($status) {
        header("Location: members_page.php");
        exit();
    }
}



require_once '../private/includes/header.inc.php';
?>
<div class="container mainContent white">
    <div id="left_section" class="span6">
        <form id="dataEntry" action="edit_page.php" method="post" enctype="multipart/form-data">
            <fieldset>

                <legend>Page, Column and Image</legend>
                <div id="mainselection">
                    <select name="page_name">
                        <?php
                        echo $page[$result->page_name];
                        ?>
                    </select>
                </div>
                <input type="hidden" name="action" value="enter">
                <input type="hidden" name="id" value="<?php echo $result->id; ?>">
                <input type="hidden" name="user_id" value="<?php echo $result->user_id; ?>">
                <input type="hidden" name="column_pos" value="<?php echo $result->column_pos; ?>">
                <input type="hidden" name="image_path" value="<?php echo $result->image_path; ?>">

<!--                <div class="maxl">
                    <label class="radio inline">
                        <input id="yesCheck" type="radio" name="insert_image" value="yes">
                        <span>Include Image</span>
                    </label>    

                    <label class="radio inline">
                        <input id="noCheck" type="radio" name="insert_image" value="no" checked>
                        <span>Exclude Image</span>
                    </label>
                </div>-->
                
            </fieldset>
            <fieldset id="mainEntry">
                <legend>Data Entry Form</legend>
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

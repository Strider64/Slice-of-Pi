<?php
require_once '../private/initialize.php';

use Library\ProcessImage\ProcessImage as Process;
use Library\Resize\Resize;
use Library\CMS\CMS;
use Library\Display\Display;

protected_page();

$check = [];

$sysop = ['<option value="index.php" selected>Home Page</option>', '<option value="about.php">About Page</option>', '<option value="blog.php">Blog Page</option>'];
$member = ['<option value="blog.php">Blog Page</option>'];

$cms = new CMS();
$display = new Display();

$upload = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_URL);
$data['user_id'] = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
$data['author'] = $_SESSION['user']->full_name;
if ($_SESSION['user']->security_level === 'sysop') {
    $data['page_name'] = filter_input(INPUT_POST, 'page_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $data['column_pos'] = filter_input(INPUT_POST, 'column_pos', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
} else {
    $data['page_name'] = 'blog.php';
    $data['column_pos'] = 'left';
}
$data['heading'] = filter_input(INPUT_POST, 'heading', FILTER_DEFAULT);
$data['content'] = filter_input(INPUT_POST, 'content', FILTER_DEFAULT);

$image_check = filter_input(INPUT_POST, 'insert_image', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if (isset($image_check) && $image_check === "yes" && $_FILES['file']['error'] !== 4) {

    $file = $_FILES['file']; // Assign image data to $file array:
    //echo "<pre>" . print_r($file, 1) . "</pre>\n";
    $imgObject = new Process($file, $_SESSION['user']->username);

    $check['image_status'] = $imgObject->processImage();
    $check['file_type'] = $imgObject->checkFileType();
    $check['file_ext'] = $imgObject->checkFileExt();
    //echo "<pre>" . print_r($check, 1) . "</pre>\n";

    if (in_array(TRUE, $check)) {
        $errMsg = "There's something wrong with the image file!<b>";
    } else {
        $data['image_path'] = $imgObject->saveIMG();

        // *** 1)  Create a new instance of class Resize:
        $resizePic = new Resize($data['image_path']);
        // *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
        $resizePic->resizeImage(600, 400, 'exact');
        // *** 3) Save image to directory:
        $resizePic->saveImage($data['image_path'], 100);

        /*
         * If this is on the production server remove the relative path public with nothing, so
         * the image path will point to the correct directory. This isn't ideal and I will have to
         * code something better in the near future. I personally don't like coding this way,
         * but I have already spent more time on it than I wanted to. 
         */
        if (filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_URL) !== "localhost") {
            $data['image_path'] = str_ireplace("../public/", "https://www.pepster.com/", $data['image_path']);
        }


        /*
         * Save all the data from the form to the database table: cms
         */
        $result = $cms->create($data);
        if ($result) {
            header("Location: " . $result);
            exit();
        }
    }
} elseif (isset($image_check)) {
    $data['image_path'] = \NULL;
    $result = $cms->create($data);
    if ($result) {
        header("Location: " . $result);
        exit();
    }
}


require_once '../private/includes/header.inc.php';
?>

<div class="container mainContent white">
    <div id="left_section" class="span6">
        <form id="dataEntry" action="members_page.php" method="post" enctype="multipart/form-data">
            <fieldset>

                <?php
                if ($_SESSION['user']->security_level === 'sysop') {
                    echo "<legend>Page, Column and Image</legend>\n";
                    echo '<div id="mainselection">' . "\n";
                    echo '<select name="page_name">' . "\n";
                    foreach ($sysop as $key => $value) {
                        echo $value;
                    }
                    echo "</select>\n";
                    echo "</div>\n";
                } else {
                    echo "<legend>Do you want to include an image?</legend>\n";
                }
                ?>

                <?php if ($_SESSION['user']->security_level === 'sysop') { ?>
                    <div class="maxl">
                        <label class="radio inline"> 
                            <input type="radio" name="column_pos" value="left" checked>
                            <span>Left</span> 
                        </label>
                        <label class="radio inline"> 
                            <input type="radio" name="column_pos" value="middle">
                            <span>Middle</span> 
                        </label>
                        <label class="radio inline"> 
                            <input type="radio" name="column_pos" value="right">
                            <span>Right</span> 
                        </label>
                    </div>
                <?php } ?>

                <div class="maxl">
                    <label class="radio inline">
                        <input id="yesCheck" type="radio" name="insert_image" value="yes" checked>
                        <span>Include Image</span>
                    </label>    

                    <label class="radio inline">
                        <input id="noCheck" type="radio" name="insert_image" value="no">
                        <span>Exclude Image</span>
                    </label>
                </div>
            </fieldset>
            <fieldset id="mainEntry">
                <legend>Data Entry Form</legend>
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user']->id; ?>">
                <input type="hidden" name="action" value="enter">
                <input id="imgBtn" type="file" name="file">
                <label class="inputLabel" for="heading">Heading</label>
                <input id="heading" type="text" name="heading" value="" tabindex="1" required autofocus>
                <label class="textareaLabel" for="content">Content</label>
                <textarea id="content" name="content" tabindex="2"></textarea>
                <input type="submit" name="submit" value="enter">
            </fieldset>
        </form>
    </div>
    <article class="content">

    </article>
</div>
<?php
require_once '../private/includes/footer.inc.php';

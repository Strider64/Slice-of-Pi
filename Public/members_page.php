<?php
require_once '../private/initialize.php';

use Library\ProcessImage\ProcessImage as Rename;
use Library\Resize\Resize;
use Library\CMS\CMS;

protected_page();

$sysop = ['<option value="index.php" selected>Home Page</option>', '<option value="about.php">About Page</option>', '<option value="members_page.php">Member Blog Page</option>'];
$member = ['<option value="members_page.php">Member Blog Page</option>'];

$cms = new CMS();

$upload = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_URL);
$data['user_id'] = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
if ($_SESSION['user']->security_level === 'sysop') {
    $data['page_name'] = filter_input(INPUT_POST, 'page_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
} else {
    $data['page_name'] = 'members_page.php';
}
if ($_SESSION['user']->security_level === 'sysop') {
    $data['column_pos'] = filter_input(INPUT_POST, 'column_pos', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
} else {
    $data['column_pos'] = 'right';
}
$data['heading'] = filter_input(INPUT_POST, 'heading', FILTER_DEFAULT);
$data['content'] = filter_input(INPUT_POST, 'content', FILTER_DEFAULT);

$image_check = filter_input(INPUT_POST, 'insert_image', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if ($upload && $upload === 'enter') {
    if ($image_check === 'yes') {
        $file = $_FILES['file']; // Assign image data to $file array:
        //echo "<pre>" . print_r($file, 1) . "</pre>\n";
        $imgObject = new Rename($file);

        $status = $imgObject->processImage();

        if ($status) {
            $data['image_path'] = $imgObject->saveIMG();
        }

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
    } else {
        $data['image_path'] = NULL;
    }

    /*
     * Save all the data from the form to the database table: cms
     */
    $result = $cms->create($data);
    if ($result) {
        header("Location: members_page.php");
        exit();
    }
}


require_once '../private/includes/header.inc.php';
?>

<div class="container mainContent white">
    <div id="left_section" class="span6">
        <form id="dataEntry" action="members_page.php" method="post" enctype="multipart/form-data">
            <fieldset>

                <legend>Page, Column and Image</legend>
                <div id="mainselection">
                    <select name="page_name">
                        <?php
                        if ($_SESSION['user']->security_level === 'sysop') {
                            foreach ($sysop as $key => $value) {
                                echo $value;
                            }
                        } else {
                            foreach ($member as $key => $value) {
                                echo $value;
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="maxl">
                    <?php if ($_SESSION['user']->security_level === 'sysop') { ?>
                        <label class="radio inline"> 
                            <input type="radio" name="column_pos" value="left">
                            <span>Left Column</span> 
                        </label>
                    <?php } ?>
                    <label class="radio inline"> 
                        <input type="radio" name="column_pos" value="right" checked>
                        <span>Right Column</span> 
                    </label>

                </div>

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
                <input id="heading" type="text" name="heading" value="" tabindex="1" autofocus>
                <label class="textareaLabel" for="content">Content</label>
                <textarea id="content" name="content" tabindex="2"></textarea>
                <input type="submit" name="submit" value="enter">
            </fieldset>
        </form>
    </div>
    <div class="span6">
        <?php
        $rightcol = $cms->read($basename, 'right');
        while ($row = $rightcol->fetch(PDO::FETCH_OBJ)) {
            echo '<article class="content">' . "\n";
            echo "<h1>" . htmlspecialchars($row->heading) . "</h1>\n";

            if (isset($_SESSION['user']) && ($_SESSION['user']->security_level === 'sysop' || $_SESSION['user']->user_id === $row->user_id)) {
                echo '<a class="editBtn" href="edit_page.php?id=' . $row->id . '">Edit</a>' . "\n";
            }

            if ($row->image_path) {
                echo '<figure class="imageStyle">' . "\n";
                echo '<img src="' . $row->image_path . '" alt="' . htmlspecialchars($row->heading) .'">' . "\n";
                echo '<figcaption>&nbsp;</figcaption>' . "\n";
                echo "</figure>\n";
            }
            echo "<p>" . htmlspecialchars($row->content) . "</p>\n";
            echo "</article>\n";
        }
        ?>    
    </div>
</div>
<?php
require_once '../private/includes/footer.inc.php';


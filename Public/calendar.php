<?php
require_once '../private/initialize.php';

use Library\Calendar\Calendar;
use Library\Display\Display;

$blogDate = filter_input(INPUT_GET, 'date', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$calendar = new Calendar();
$date_is_valid = $calendar->checkIsAValidDate($blogDate);

$calendar->phpDate();

if (isset($_SESSION['user']->id)) {
    $calendar->set_user_id($_SESSION['user']->id);
}

$display = new Display();

if (isset($blogDate)) {

    if ($date_is_valid) {
        $data = $display->dailyRead($blogDate);
        $calendar->changeMonth($blogDate);
    }
}
require_once '../private/includes/header.inc.php';
?>

<div class="container calendarBlog">

    <div id="blog-style-box">
<?php echo $calendar->generateCalendar(); ?>
        <article id="calendar-page">
            <h1>Blog Entries by Month and Day</h1>
            <p>If there is a entry for a particular date the day will be highlighted a gold-yellow color. If there is no entry for that date then the day won't be clickable and the day will be highlighted white.</p>
        </article>
    </div>

<?php
if (isset($data) && ($date_is_valid && strlen($blogDate) === 10)) {
    $display->setData($data);
    echo '<article class="blogContent marginUp">' . "\n";
    $display->display();
    echo "</article>\n";
}
?> 


</div>
<?php
require_once '../private/includes/footer.inc.php';

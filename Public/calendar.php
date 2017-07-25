<?php
require_once '../private/initialize.php';

use Library\Calendar\Calendar;
use Library\Display\Display;

$blogDate = filter_input(INPUT_GET, 'date', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$calendar = new Calendar();
$calendar->phpDate();

$display = new Display();
if (isset($blogDate)) {
    $data = $display->dailyRead($blogDate);
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
    if (isset($data)) {
        $display->setData($data);
        echo '<article class="blogContent">' . "\n";
        $display->display();
        echo "</article>\n";
    }
    ?> 


</div>
<?php
require_once '../private/includes/footer.inc.php';
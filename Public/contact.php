<?php
require_once '../private/initialize.php';

use Library\Database\Database as DB;
use Library\Email\Email;

$db = DB::getInstance();
$pdo = $db->getConnection();


$submit = filter_input(INPUT_POST, 'submit', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if (isset($submit) && $submit === 'submit') {
    $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if (!empty($token)) {
        if (hash_equals($_SESSION['token'], $token)) {
            /* The Following to get response back from Google recaptcah */
            $url = "https://www.google.com/recaptcha/api/siteverify";

            $remoteServer = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_URL);
            $response = file_get_contents($url . "?secret=" . PRIVATE_KEY . "&response=" . \htmlspecialchars($_POST['g-recaptcha-response']) . "&remoteip=" . $remoteServer);
            $recaptcha_data = json_decode($response);
            /* The actual check of the recaptcha */
            if (isset($recaptcha_data->success) && $recaptcha_data->success === TRUE) {
                $data['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $data['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $data['phone'] = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $data['website'] = filter_input(INPUT_POST, 'website', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $data['reason'] = filter_input(INPUT_POST, 'reason', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $data['comments'] = filter_input(INPUT_POST, 'comments', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                $send = new Email($data);
            } else {
                $success = "You're not a human!"; // Not of a production server:
            }
        } else {
            // Log this as a warning and keep an eye on these attempts
        }
    }
}
require_once '../private/includes/header.inc.php';
?>
<div id="contact-form">
    <form id="contact" name="contact" action="contact.php" method="post"  autocomplete="on">

        <fieldset>

            <legend><?php echo (isset($success)) ? $success : 'Contact Form'; ?></legend>
            <input type="hidden" name="token" value="<?= $_SESSION['token']; ?>">
            <label for="name" accesskey="U">Name</label>
            <input name="name" type="text" id="name" tabindex="1" autofocus required="required" />

            <label for="email" accesskey="E">Email</label>
            <input name="email" type="email" id="email" tabindex="2" required="required" />

            <label for="phone" accesskey="P" >Phone <small>(optional)</small></label>
            <input name="phone" type="tel" id="phone" tabindex="3">

            <label for="website" accesskey="W">Website <small>(optional)</small></label>
            <input name="website" type="text" id="website" tabindex="4">

            <div class="radioBlock">
                <input type="radio" id="radio1" name="reason" value="message" tabindex="5" checked>
                <label class="radioStyle" for="radio1">message</label>
                <input type="radio" id="radio2" name="reason" value="order">
                <label class="radioStyle" for="radio2">order</label>  
                <input type="radio" id="radio3" name="reason" value="status">
                <label class="radioStyle" for="radio3">status inquiry</label>    
            </div>

            <label class="textBox" for="comments">Comments</label>
            <textarea name="comments" id="comments" spellcheck="true" tabindex="6" required="required"></textarea> 
            <div class="g-recaptcha" data-sitekey="6LfPlQoUAAAAAPgD3PpnQ_uGTzc87UALiFgQ3XnK"></div>
            <input type="submit" name="submit" value="submit" tabindex="7">
        </fieldset>
    </form>
</div>
<?php
require_once '../private/includes/footer.inc.php';


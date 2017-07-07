<?php
require_once '../private/initialize.php';

use Library\Users\Users;
use Library\FormValidation\FormValidation;
use Library\FormVerification\FormVerification;

if (is_logged_in() && is_session_valid()) {
    header("Location: index.php");
    exit();
}

$invalid = \FALSE;

$users = new Users();

$submit = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if (isset($submit) && $submit === 'login') {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $result = $users->read($username, $password);
    if ($result) {
        after_successful_login();
    }
}

if (isset($submit) && $submit === 'register') {

    $data['username'] = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $data['password'] = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $data['verify_password'] = filter_input(INPUT_POST, 'verify_password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $data['full_name'] = filter_input(INPUT_POST, 'full_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $data['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $data['verify_email'] = filter_input(INPUT_POST, 'verify_email', FILTER_SANITIZE_EMAIL);

    $validate = new FormValidation($data);

    if ($validate->result) {
        /* All the data has validated proceed to saving and sending email verification */
        $sendEmail = new FormVerification();
        $result = $sendEmail->sendEmailVerification($data);
        if ($result) {
            $data['security_level'] = 'public';
            $data['confirmation_code'] = $sendEmail->confirmationNumber;
            $finalResult = $users->create($data);

            if ($finalResult) {
                header('Location: notice.php');
                exit();
            }
        }
    } else {

        $invalid = TRUE; // Invalid Data being sent to Form - Have user re-enter:
    }
}


require_once '../private/includes/header.inc.php';
?>
<div class="loginPage">
    <?php if (!$invalid) { ?>
        <div id="login_section">
            <article>
                <h1>Login Section</h1>
                <p>This is where you login in to gain access to member only pages. This website is using a new and improved PHP login system that improves security of users personal information.</p>
            </article>
            <form id="login" action="<?php $basename; ?>" method="post" autocomplete="off">
                <fieldset>
                    <legend>Sign-in to Your Account</legend>
                    <input type="hidden" name="action" value="login">
                    <label for="username">username</label>
                    <input id="username" type="text" name="username" value="<?php echo (isset($username)) ? $username : NULL; ?>" tabindex="1">
                    <label for="password">password</label>
                    <input id="password" type="password" name="password" tabindex="2">
                    <input type="submit" name="submit" value="login" tabindex="3">
                </fieldset>
            </form>
        </div>
        <?php
    } else {
        echo '<div id="login_section">' . "\n";
        echo "<article>\n";
        echo '<h1 class="errorHeader">Errors in Registration Form</h1>' . "\n";
        if (!$validate->valid['content']) {
            echo '<p class="error">All input fields must be entered' . "\n";
        }
        if (!$validate->valid['userAvailability']) {
            echo '<p class="error">Invalid Username, please re-enter!</p>' . "\n";
        }
        if (!$validate->valid['validPassword']) {
            echo '<p class="error">Invalid Password, please re-enter!</p>' . "\n";
        }
        if (!$validate->valid['verifyPassword']) {
            echo '<p class="error">Passwords Do Not match, please re-enter!</p>' . "\n";
        }
        if (!$validate->valid['validEmail']) {
            echo '<p class="error">Invalid Email, please re-enter!</p>' . "\n";
        }
        if (!$validate->valid['verifyEmail']) {
            echo '<p class="error">Email Addresses Do Not Match, please re-enter!</p>' . "\n";
        }
        echo "</article>\n";
        echo "</div>\n";
    }
    ?>

    <div id="register_section">
        <article>
            <h1>Registration Section</h1>
            <p>Not a member? No problem! Just register using the form below and you will become a member in no time.</p>
        </article>
        <form id="register" name="<?php $basename; ?>" method="post" autocomplete="off">
            <fieldset>
                <legend>Registration Form</legend>
                <input type="hidden" name="action" value="register">
                <label for="register_username">username</label>
                <input id="register_username" type="text" name="username" value="<?php echo(isset($validate->valid['userAvailability']) && $validate->valid['userAvailability']) ? $validate->data['username'] : NULL; ?>" tabindex="4">
                <label for="register_password">password</label>
                <input id="register_password" type="password" name="password" tabindex="5">
                <label for="register_verify">verify password</label>
                <input id="register_verify" type="password" name="verify_password" tabindex="6">
                <label for="full_name">Full Name</label>
                <input id="full_name" type="text" name="full_name" value="" tabindex="7">
                <label for="email">email</label>
                <input id="email" type="email" name="email" value="<?php echo(isset($validate->valid['validEmail']) && $validate->valid['validEmail']) ? $validate->data['email'] : NULL; ?>" tabindex="8">
                <label for="verify_email">verify email</label>
                <input id="verify_email" type="email" name="verify_email" value="<?php echo(isset($validate->valid['verifyEmail']) && $validate->valid['verifyEmail']) ? $validate->data['verify_email'] : NULL; ?>" tabindex="9">
                <input type="submit" name="submit" value="submit" tabindex="10">
            </fieldset>
        </form>

    </div>
</div>
<?php
require_once '../private/includes/footer.inc.php';

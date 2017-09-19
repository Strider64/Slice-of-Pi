<?php
require_once '../private/initialize.php';

use Library\Users\Users;

$confirmed = \FALSE;

$user = new Users();

$confirmation_code = htmlspecialchars($_GET['confirm_number']);

if (isset($confirmation_code)) {

    $status = $user->checkSecurityCode($confirmation_code);

    if ($status) {
        $result = $user->update($confirmation_code);

        if ($result) {
            $confirmed = \TRUE;
        }
    }
}
require_once '../private/includes/header.inc.php';
?>
<div class="container mainContent">
    <article class="registerStyle">
        <?php
        if ($confirmed) {
            echo "<h1>Thank You!</h1>";
            echo '<p>Slice of Pi really appreciates you taking your time in order to upgrade your account to member. This entitles you to write access to blogs and other member-only areas of this website.</p>';
            echo '<p>Please click on the login button on the top right hand of the screen.</p>';
        } else {
            echo '<h1 class="errorHeader">You already activated your account!</h1>' . "\n";
        }
        ?>                                    
    </article>
</div>

<?php
require_once '../private/includes/footer.inc.php';

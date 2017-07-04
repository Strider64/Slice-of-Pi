<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1.0, width=device-width" />
        <title>Slice of Pi</title>
        <link rel="stylesheet" href="assets/css/stylesheet.css">
    </head>

    <body>

        <div class="heading">            
            <a href="#" id="logo"></a>            
            <nav>
                <a href="#" id="menu-icon"></a>
                <ul>
                    <li><a href="index.php" <?php echo ($basename === 'index.php') ? 'class="current"' : NULL; ?>>Home</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="#">Contact</a></li>
                    <?php 
                    if (!is_logged_in()) {
                        if ($basename === 'login.php') {
                            echo '<li><a href="login.php" class="current">Login</a></li>';
                        } else {
                            echo '<li><a href="login.php">Login</a></li>';
                        }
                    } else {
                        echo '<li><a href="members_page.php">Members</a></li>';
                        echo '<li><a href="logout.php">Logout</a></li>';
                    }
                    ?>                   
                </ul>
            </nav>
        </div>

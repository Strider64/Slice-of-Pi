<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            if (filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_URL) == "localhost") {
                echo '<base href="http://localhost:8888/sliceofpi06212017/public/">';
            } else {
                echo '<base href="https://www.pepster.com/">';
            }
        ?>
        
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1.0, width=device-width" />
        <title>Slice of Technology</title>
        <link rel="stylesheet" href="assets/css/stylesheet.css">
        <script src='https://www.google.com/recaptcha/api.js'></script>
    </head>

    <body>

        <div class="heading">            
            <a href="#" id="logo"></a>            
            <nav>
                <a href="#" id="menu-icon"></a>
                <ul>
                    <li><a href="index" <?php echo ($basename === 'index.php') ? 'class="current"' : NULL; ?>>Home</a></li>
                    <li><a href="about" <?php echo ($basename === 'about.php') ? 'class="current"' : NULL; ?>>About</a></li>                    
                    <li><a href="blog" <?php echo ($basename === 'blog.php') ? 'class="current"' : NULL; ?>>Blog</a></li>
                    <li><a href="contact" <?php echo ($basename === 'contact.php') ? 'class="current"' : NULL; ?>>Contact</a></li>
                    <?php 
                    if (!is_logged_in() && $basename === 'blog.php') {
                        if ($basename === 'login.php') {
                            echo '<li><a href="login.php" class="current">Login</a></li>';
                        } else {
                            echo '<li><a href="login.php">Login</a></li>';
                        }
                    } elseif (is_logged_in()) {
                        echo ($basename === 'members_page.php') ? '<li><a href="members_page.php" class="current">Members</a></li>' : '<li><a href="members_page.php">Members</a></li>';;
                        echo '<li><a href="logout.php">Logout</a></li>';
                    }
                    ?>                   
                </ul>
            </nav>
        </div>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        if (filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_URL) == "localhost") {
            echo '<base href="http://localhost:8888/sliceofpi06212017/public/">';
        } else {
            echo '<base href="https://www.pepster.com/">';
        }
        
        $title = ['Index' => 'A Slice of Technology - Learning from Technology', 'About' => 'About John Pepp - Owner - Slice of Tecnology', 'Blog' => 'Online Blog Everyone', 'Calendar' => 'Calendar - Blog', 'Contact' => 'Contact - John Pepp', 'Login' => 'Login - Registration - a Slice of Technogy', 'Members_page' => 'Member Only Page', 'Daily' => "Daily Blog"];
        ?>

        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1.0, width=device-width" />
        <meta name="description" content="A Slice of Technology - Learning from Technology" />
        <meta name="keywords" content="tech, cms, tech news, calendar, social, technology, web development, web design, php, monthly calendar, blog, blog sites, social network, raspberry pi, social media, images photos, social sities" />
        <title><?= $title[$pageName]; ?></title>
        <link rel="stylesheet" href="assets/css/stylesheet.css">
        <link rel="shortcut icon" href="favicon.ico" >
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
                    <li><a href="calendar" <?php echo ($basename === 'calendar.php') ? 'class="current"' : NULL; ?>>Calendar</a></li>
                    <li><a href="contact" <?php echo ($basename === 'contact.php') ? 'class="current"' : NULL; ?>>Contact</a></li>
                    <?php
                    if (!is_logged_in()) {
                        echo ($basename === 'blog.php' || $basename === 'calendar.php') ? '<li><a href="login.php">Login</a></li>' : '<li><a class="notVisible" href="login.php">Login</a></li>';
                    }
                    ?>
                    <?php if (is_logged_in()) { ?>
                        <li><a href="members_page.php" <?php echo ($basename === 'members_page.php') ? 'class="current"' : NULL; ?>>Members</a></li>
                    <?php } else { ?>
                        <li><a class="notVisible" href="#">Members</a></li>
                        <?php } ?>


                    <?php echo ( is_logged_in() ) ? '<li><a href="logout.php">Logout</a></li>' : \NULL; ?>

                </ul>
            </nav>
        </div>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        if (filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_URL) == "localhost") {
            echo '<base href="http://localhost:8888/sliceofpi06212017/public/">';
        } else {
            echo '<base href="https://www.pepster.com/">';
        }

        $title = ['Index' => 'A Slice of Technology - Learning from Technology', 'About' => 'About John Pepp - Owner - Slice of Tecnology', 'Blog' => 'Online Blog Everyone', 'Calendar' => 'Calendar - Blog', 'Contact' => 'Contact - John Pepp', 'Edit' => 'Edit Page', 'Login' => 'Login - Registration - a Slice of Technogy', 'Members_page' => 'Member Only Page', 'Daily' => "Daily Blog", 'Notice' => 'Notice', 'Confirm' => "Confirmation Page"];
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
        <header class="container header-banner">
            <h2 class="logo"><span>A Slice of Technology</span> <a href="index"></a></h2>
            <h1 class="website-name">A Slice of Technology</h1>
            <div class="socialMediaStyle">
                <ul class="socialIcons">
                    <li><a href="http://www.facebook.com/PepstersPlace" target="_blank"><img src="assets/images/img-facebook-logo-25x25.png" alt="A Slice of Technology FB Page" ></a></li>
                    <li><a href="http://twitter.com/#!/Strider64" target="_blank"><img src="assets/images/img-twitter-logo-25x25.png" alt="Pepster's Twitter Profile" ></a></li>
                    <li><a href="http://www.linkedin.com/in/johnpepp" target="_blank"><img src="assets/images/img-linkedin-logo-25x25.png" alt="John Pepp's LinkedIn Profile" ></a></li>
                    <li><a href="http://www.flickr.com/people/pepster/" target="_blank"><img src="assets/images/img-flickr-logo-100x25.png" alt="John Pepp's Flickr Profile" ></a></li>
                </ul>
            </div>
        </header>
        <div class="container">
            <div class="mobileNav">
                <nav id="slider" class="slider"> <span class="slider-tab">&Congruent;</span>
                    <ul class="slider-margin">
                        <li><a href="index">home</a></li>
                        <li><a href="about">about</a></li>                        
                        <li><a href="calendar"><span>calendar</span></a>
                        <li><a href="blog">blog</a></li>
                        <li><a href="members_page.php"><?php echo(is_logged_in()) ? "New Blog" : "Login"; ?></a></li>
                        <li><a href="contact">contact</a></li>
                        <?php echo (is_logged_in()) ? '<li><a href="logout.php">logout</a></li>' . "\n" : NULL; ?>
                    </ul>
                </nav>
                <!-- END OF NAVIGATIONAL LINKS-->
                <div id="mobile-header">
                    <p class="header-style">A Spice of Technology</p>
                </div>
                <!-- END OF MOBILE HEADER --> 
            </div>

            <div id="sticky" class="row navigational-wrapper">
                <nav class="slider"> <span class="slider-tab">&Congruent;</span>
                    <ul class="slider-margin">
                        <li><a href="index">home</a></li>
                        <li><a href="about">about</a></li>                        
                        <li class="menu-trigger"><a class="mobile-menu" href="blog"><span>blog</span></a>
                            <ul class="drop">
                                <li><a href="calendar" class="current">calendar</a></li>
                                <li><a href="members_page.php">new blog</a></li>
                            </ul>
                        </li>
                        <li><a href="order">order</a></li>
                        <li><a href="contact">contact</a></li>
                    </ul>
                    <?php
                    echo (!is_logged_in()) ? '<a class="login" href="login">login</a>' . "\n" : NULL;

                    if (is_logged_in()) {
                        echo '<div class="logout">' . "\n";
                        echo '<span>Welcome, ' . $_SESSION['user']->username . '! <a href="logout.php">logout</a></span>' . "\n";
                        echo "</div>\n";
                    }
                    ?>
                </nav>
                <!-- END OF NAVIGATIONAL LINKS-->

            </div>
        </div>


<?php
// Start the session
session_start();

// Include the database connection file: include_once("config.php");
include_once("config.php");
?>

<!DOCTYPE html>
<html>

<head>
    <title>CARS (Register Page)</title>
    <meta charset="UTF-8">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- Ray's Bootstrap -->
    <link rel="stylesheet" type="text/css" href="css/fontawesome-free-5.13.0-web/css/all.css">
    <link rel="stylesheet" type="text/css" href="css/home.css">

    <!-- My CSS -->
    <link rel="stylesheet" type="text/css" href="css/registerActivity.css">

</head>

<body>
    <!-- NAVBAR -->
    <div id="navbar" class="navbar navbar-expand-sm navbar-light navbar-colored" style="padding: 5px 10px;">

        <!-- Logos (UM, KK8) -->
        <img id="logo" class="um-logo" src="imgs/UM-LOGO.png" alt="um-logo" width="120" height="45" style="font-size: 25px;">
        <img id="logo" class="kk8-logo" src="imgs/KK8-LOGO.png" alt="kk8-logo" width="40" height="35">

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <!-- Links to other pages -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="home.php#profile">About</a>
                </li>
                <li class="nav-item">
                    <?php
                    if (
                        isset($_SESSION['logged_in']) && $_SESSION['studentID']
                        && $_SESSION['username']
                    ) {
                        echo '<a class="nav-link" href="myActivity.php">Activities</a>';
                    } else {
                        echo '<a class="nav-link" href="home.php?action=login">Activities</a>';
                    }
                    ?>
                </li>
                <li class="nav-item">
                    <?php
                    if (
                        isset($_SESSION['logged_in']) && $_SESSION['studentID']
                        && $_SESSION['username']
                    ) {
                        echo '<a class="nav-link" href="helpdesk.php">Help Desk</a>';
                    } else {
                        echo '<a class="nav-link" href="home.php?action=login">Help Desk</a>';
                    }
                    ?>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="home.php#team">Management</a>
                </li>
                <li class="nav-item">
                    <a id="contact-us" class="nav-link" href="#footer">Contact Us</a>
                </li>
            </ul>

            <!-- Profile dropdown menu -->
            <?php
            if (
                isset($_SESSION['logged_in']) && $_SESSION['studentID']
                && $_SESSION['username']
            ) {

                echo
                    '<ul class="nav navbar-nav navbar-right ml-auto">
                                <li class="nav-item dropdown">
                                    <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle user-action">
                            ';
                // Method 1: Using MySQLi Procedural
                $username = $_SESSION['username'];
                $studentID = $_SESSION['studentID'];

                $check_profile_pic =  mysqli_query($mysqli, "SELECT profile_pic_path FROM student_T WHERE studentID = '$studentID' AND username = '$username'");
                $res = mysqli_fetch_array($check_profile_pic);
                $image = "imgs/profilepicture/".$res["profile_pic_path"];

                // Display profile picture
                echo '<img src="' . $image . '" class="avatar" alt="Avatar">';

                // Display username
                echo $_SESSION['username'];
                echo '<b class="caret"></b></a>';

                // Display dropdown menu and log out button
                echo
                    '<ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="userprofile.php" class="dropdown-item"><i class="fas fa-user"></i> Profile</a></li>
                                    <li class="divider dropdown-divider"></li>
                                    <li>
                                        <div class="text-center">
                                            <a href="processLogout.php?action=logout" class="btn btn-danger" role="button">Log Out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>';
            } else {
                echo '<button type="button" class="btn btn-primary" onclick="window.location.href=\'home.php?action=login\'">Log
                        In</button>';
            }
            ?>
        </div>
    </div>

    <main>
        <?php

        $action = isset($_GET['action']) ? $_GET['action'] : "";

        // If newly registered user accesses page (successful registration)
        if ($action == "reg_success") {
            echo '
            <div class="mainContainer">
                <div class="containerAct">
                    <br><br><br><br>

                    <div class="modal-box complete">
                        <h2>Registration completed!</h2>
                        
                        <br>
                        <button id="profile_page" class="btn btn-primary" onclick="window.location.href=\'userprofile.php\'">Go to Profile Page</button>
                    </div>
                </div>
            </div>
            ';
        }

        // If unlogged in user accesses page
        if (!(isset($_SESSION['logged_in']) && $_SESSION['studentID'] && $_SESSION['username']) && ($action != "reg_success")) {
            echo '
            <div class="mainContainer">
                <div class="containerAct">
                <br><br><br><br><br><br><br><br>

                    <div class="modal-box complete">
                        <div class="alert alert-danger" role="alert">
                        Only logged in and authorised members can access this page.</div>
                    </div>
                </div>
            </div>
            ';
        }

        // If logged in user accesses page
        if ($_SERVER['REQUEST_URI'] == '/files/confirmReg.php' && (isset($_SESSION['logged_in']) && $_SESSION['studentID'] && $_SESSION['username']) && ($action != "reg_success")) {
            echo '
            <div class="mainContainer">
                <div class="containerAct">
                <br><br><br><br><br><br><br><br>

                    <div class="modal-box complete">
                        <div class="alert alert-danger" role="alert">
                        You have already logged in and registered an account.</div>
                    </div>
                </div>
            </div>
            ';
        }

        ?>
    </main>

    <footer id="footer" class="footer-distributed">
        <div class="footer-left">

            <img id="logo" class="um-logo" src="imgs/UM-LOGO.png" alt="um-logo" width="240" height="90">
            <img id="logo" class="kk8-logo" src="imgs/KK8-LOGO.png" alt="kk8-logo" width="80" height="70">

            <p class="footer-links">
                <?php
                if (
                    isset($_SESSION['logged_in']) && $_SESSION['studentID']
                    && $_SESSION['username']
                ) {
                    echo
                        '
                    <a href="home.php">Home</a>
                    ·
                    <a href="home.php#profile">About</a>
                    ·
                    <a href="myActivity.php">Activities</a>
                    ·
                    <a href="helpdesk.php">Help Desk</a>
                    ·
                    <a href="home.php#team">Management</a>
                    ·
                    <a href="#footer">Contact Us</a>
                    ';
                } else {
                    echo
                        '
                    <a href="home.php">Home</a>
                    ·
                    <a href="home.php#profile">About</a>
                    ·
                    <a href="home.php?action=login">Activities</a>
                    ·
                    <a href="home.php?action=login">Help Desk</a>
                    ·
                    <a href="home.php#team">Management</a>
                    ·
                    <a href="#footer">Contact Us</a>
                    ';
                }
                ?>
            </p>

            <p class="footer-company-name">© 2020 CitizenScientist</p>
        </div>

        <div class="footer-center">
            <div>
                <i class="fa fa-map-marker"></i>
                <p><span>Kolej Kediaman Kinabalu, University of Malaya</span> 50603 Kuala Lumpur</p>
            </div>

            <div>
                <i class="fa fa-phone"></i>
                <p>03-7955 8643</p>
            </div>

            <div>
                <i class="fa fa-envelope"></i>
                <p><a href="mailto:kinabalu@um.edu.my">kinabalu@um.edu.my</a></p>
            </div>
        </div>

        <div class="footer-right">
            <p class="footer-company-about">
                <span>About KK8</span>
                Kinabalu Residential College is the 8th residential college in University of Malaya.
            </p>

            <div class="footer-icons">
                <div class="f_social_icon">
                    <span class="facebook">
                        <a href="https://www.facebook.com/Kolej-Kediaman-Kinabalu-KK8-Universiti-Malaya-OFFICIAL-148001638614165/" class="fab fa-facebook"></a>
                    </span>
                    <span class="twitter">
                        <a href="https://twitter.com/kinabalu8th?lang=en" class="fab fa-twitter"></a>
                    </span>
                    <span class="instagram">
                        <a href="https://www.instagram.com/kolej_kediaman8/?hl=en" class="fab fa-instagram"></a>
                    </span>
                    <span class="youtube">
                        <a href="https://www.youtube.com/channel/UCzZEY-tpmrvap3R-zPf7JJg" class="fab fa-youtube"></a>
                    </span>
                </div>
            </div>
        </div>

    </footer>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <!-- Bootstrap -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <!-- My Script -->
    <script src="js/registerActivityscript.js"></script>

</body>

</html>
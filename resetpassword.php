<?php
session_start();
include_once("config.php");

if (
    isset($_SESSION['logged_in']) && $_SESSION['studentID']
    && $_SESSION['username']
) {
    $now = time(); // Checking the time now when page loads.

    if ($now > $_SESSION['expire']) {
        session_destroy();
        header('Location: processLogout.php?action=logout');
    }
}
// else
//     header('Location: home.php?action=login');


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="HandheldFriendly" content="true">
    <meta name="description" content="">

    <link rel="stylesheet" href="css/bootstrap.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/fontawesome-free-5.13.0-web/css/all.css">
    <link rel="stylesheet" type="text/css" href="css/home.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="css/usersettings.css">
    <link rel="stylesheet" href="css/reset.css">

    <title>CARS (Reset Password)</title>
</head>

<body>
    <header>
        <!-- NAVBAR -->
        <div id="navbar" class="navbar navbar-expand-sm navbar-light">

            <!-- Logos (UM, KK8) -->
            <img id="logo" class="um-logo" src="imgs/UM-LOGO.png" alt="um-logo" width="120" height="45">
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
                            echo '<a class="nav-link" href="myActivity.html">Activities</a>';
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
                    $image = "imgs/profilepicture/" . $res["profile_pic_path"];

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
                    echo '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#login-modal">Log
                            In</button>';
                } ?>

            </div>
        </div>
    </header>
    <main>
        <div class="container padding-bottom-3x mb-2">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                   
                    <h2>Change Password</h2>

                    <form action="securitysettings.php" method="post" class="card mt-4">
                        <div class="card-body">
                        <?php
                            $action = isset($_GET['action']) ? $_GET['action'] : "";
                            if ($action == "forgot_password_error") {
                        ?>
                            <div class="alert alert-warning alert-dismissible" role="alert">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                New password cannot be similar to your previous one. Please try again
                            </div>
                        <?php
                            }
                        ?>

                            <div class="form-group">
                                <!--Label-->
                                <label>New password</label>

                                <!--Password input-->
                                <div class="input-group form-group">
                                    <input type="password" id="reg_userpassword" name="newPass" class="form-control" data-placement="bottom" data-toggle="popover" data-container="body" data-html="true" value="" placeholder="New Password" required>

                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="button-append1" onclick="togglePassword()">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>

                                <!--Password Progress Bar-->
                                <div class="progress mt-3" id="reg-password-strength">
                                    <div id="password-strength" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                                    </div>
                                </div>

                                <!--Password remember and results-->
                                <div class="form-text">
                                    <span id="reg-password-quality" class="hide pull-left block-help">
                                        <small id="reg-password-strength">Password Strength: <span id="reg-password-quality-result"></span></small>
                                    </span>
                                </div>
                                <!--Password Rules-->
                                <div id="reg_passwordrules" class="hide password-rule mt-2">
                                    <small>
                                        <ul class="list-unstyled">
                                            <li class="">
                                                <span class="eight-character"><i class="fa fa-check-circle" aria-hidden="true"></i></span>
                                                &nbsp; Min. 8 characters</li>
                                            <li class="">
                                                <span class="low-upper-case"><i class="fa fa-check-circle" aria-hidden="true"></i></span>
                                                &nbsp; Min. 1 uppercase & 1 lowercase character</li>
                                            <li class="">
                                                <span class="one-number"><i class="fa fa-check-circle" aria-hidden="true"></i></span>
                                                &nbsp; Min. 1 number</li>
                                            <li class="">
                                                <span class="one-special-char"><i class="fa fa-check-circle" aria-hidden="true"></i></span>
                                                &nbsp; Min. 1 special character (!@#$%^&*)</li>
                                        </ul>
                                    </small>
                                </div>
                            </div>

                            <div class="form-group">
                                <!-- Password-confirm label -->
                                <label>Confirm Password</label>

                                <!-- Password-confirm input -->
                                <div class="input-group">
                                    <input type="password" id="reg_userpasswordconfirm" name="confirmPass" class="form-control" data-placement="bottom" data-toggle="popover" data-container="body" data-html="true" placeholder="Confirm Password" required>

                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="button-append2" onclick="togglePassword_Confirm()">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Password-confirm error message -->
                                <div class="help-block text-left">
                                    <small><span id="error-confirmpassword" class="hide pull-right block-help">
                                            <i class="fa fa-info-circle text-danger" aria-hidden="true"></i>
                                            Password mismatch!</span></small>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <?php
                            if (
                                isset($_SESSION['logged_in']) && $_SESSION['studentID']
                                && $_SESSION['username']
                            ) {
                                echo
                                    '
                                <a href="usersettings.php" class="btn btn-outline-secondary">
                                Cancel
                                </a>
                                ';
                            } else {
                                echo
                                    '
                                <a href="home.php" class="btn btn-outline-secondary">
                                Cancel
                                </a>
                                ';
                            }
                            ?>

                            <input type="submit" name="updateChangeForgot" class="btn btn-primary" value="Update Password"></input>

                        </div>

                    </form>
                </div>
            </div>

        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script type="text/javascript" src="js/home.js"></script>
    <script src="js/reset.js"></script>
</body>
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
                    <a href="myActivity.html">Activities</a>
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

</html>
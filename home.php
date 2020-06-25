<?php
// Start the session
session_start();

// Include the database connection file: include_once("config.php");
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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">

    <!-- Responsive Design -->
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="HandheldFriendly" content="true">
    <meta name="description" content="">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- Animate on Scroll CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" type="text/css" href="css/fontawesome-free-5.13.0-web/css/all.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="css/home.css">
    <!-- Google Icon CSS -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <title>CARS (Home)</title>
</head>

<body>

    <!-- Back-to-top part -->
    <a id="back-to-top" onclick="scrollToTop()">
        <i class="fas fa-chevron-up"></i>
    </a>

    <!-- Cover container (KK8 aerial photo) -->
    <div class="cover">

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

                <?php
                if (
                    isset($_SESSION['logged_in']) && $_SESSION['studentID']
                    && $_SESSION['username']
                ) {
                    echo
                        '<ul class="nav navbar-nav navbar-right ml-auto">
                            <li class="nav-item dropdown">
                                <a href="#" data-toggle="dropdown" id="username_profile" class="nav-link dropdown-toggle user-action">
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
                    echo '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#login-modal">Log
                        In</button>';
                } ?>

            </div>
        </div>

        <!-- Cover header -->
        <div id="header-container">
            <h1 id="cover-header">Welcome to<br>Kinabalu Residential College</h1>

            <!-- Button to scroll to Profile section -->
            <div id="profile-btn" class="form-row text-center">
                <div class="col-12">
                    <button type="button" onclick="coverToProfile()" class="btn btn-primary btn-lg">Tell Me
                        More!</button>
                </div>
            </div>
        </div>
    </div>

    <main>

        <!-- KK8 PROFILE -->
        <section id="profile">
            <div class="container" data-aos="zoom-in-up">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2 class="section-heading">Profile</h2>
                        <h3 class="section-subheading text-muted">Kinabalu Residential College (KK8), University of
                            Malaya
                        </h3>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-md-6">
                        <span class="fa-stack fa-4x">
                            <a class="facilities-link" data-toggle="modal">
                                <i class="fas fa-circle fa-stack-2x text-primary"></i>
                                <i class="fas fa-history fa-stack-1x fa-inverse"></i>
                            </a>
                        </span>
                        <h4 class="profile-heading">History</h4>
                        <p class="text-muted">Much like the mountain it is named after, Mount Kinabalu, the highest
                            mountain
                            in South East Asia, the Kinabalu Residential College stands proudly in University of Malaya.
                        </p>
                    </div>
                    <div class="col-md-6">
                        <span class="fa-stack fa-4x">
                            <a class="facilities-link" data-toggle="modal">
                                <i class="fas fa-circle fa-stack-2x text-primary"></i>
                                <i class="fas fa-graduation-cap fa-stack-1x fa-inverse"></i>
                            </a>
                        </span>
                        <h4 class="profile-heading">Vision &amp; Mission</h4>
                        <p class="text-muted">Gratitude makes sense of our past, brings peace for today, and creates a
                            vision for tomorrow. To succeed in your mission, you must have single-minded devotion to
                            your
                            goal.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- KK8 ACTIVITIES -->
        <section id="activities">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8">

                        <!-- Heading -->
                        <h2 class="section-heading text-center">
                            Life at Kinabalu
                        </h2>

                        <!-- Text -->
                        <h3 class="section-subheading text-center text-muted">
                            Kinabalu Residential College (KK8), University of Malaya
                        </h3>

                    </div>
                </div>
                <div class="row form-row align-items-center">
                    <div class="col-3">

                        <div class="img-square activities-hover">
                            <img src="imgs/activities-compressed/kk8_activities_1-min.jpg" alt="..." class="img-cover">
                        </div>

                    </div>
                    <div class="col-6">
                        <div class="row form-row align-items-end mb-2">
                            <div class="col-7">

                                <div class="img-square activities-hover">
                                    <img src="imgs/activities-compressed/kk8_activities_2-min.jpg" alt="..." class="img-cover">
                                </div>

                            </div>
                            <div class="col-5">

                                <div class="img-square activities-hover">
                                    <img src="imgs/activities-compressed/kk8_activities_3-min.jpg" alt="..." class="img-cover">
                                </div>

                            </div>
                        </div> <!-- / .row -->
                        <div class="row form-row">
                            <div class="col-5">

                                <div class="img-square activities-hover">
                                    <img src="imgs/activities-compressed/kk8_activities_4-min.jpg" alt="..." class="img-cover">
                                </div>

                            </div>
                            <div class="col-7">

                                <div class="img-square activities-hover">
                                    <img src="imgs/activities-compressed/kk8_activities_6-min.jpg" alt="..." class="img-cover">
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-3">

                        <div class="img-square activities-hover">
                            <img src="imgs/activities-compressed/kk8_activities_7-min.jpg" alt="..." class="img-cover">
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <!-- KK8 FACILITIES -->
        <section id="facilities">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2 class="section-heading">Facilities</h2>
                        <h3 class="section-subheading text-muted">We strive to provide the best service possible</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-6 facilities-item">
                        <a class="facilities-link" data-toggle="modal" href="#faciltiesModal1">
                            <div class="facilities-hover">
                                <div class="facilities-hover-content">
                                    <i class="fa fa-plus fa-3x"></i>
                                </div>
                            </div>
                            <img class="img-fluid" src="imgs/facilities/hostels/IMG_3360-min.JPG" alt="">
                        </a>
                        <div class="facilities-caption">
                            <h4>Hostels</h4>
                            <p class="text-muted">Dorms and Rooms</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 facilities-item">
                        <a class="facilities-link" data-toggle="modal" href="#facilitiesModal2">
                            <div class="facilities-hover">
                                <div class="facilities-hover-content">
                                    <i class="fa fa-plus fa-3x"></i>
                                </div>
                            </div>
                            <img class="img-fluid" src="imgs/facilities/cafeteria/IMG_3373-min.JPG" alt="">
                        </a>
                        <div class="facilities-caption">
                            <h4>Cafeteria</h4>
                            <p class="text-muted">Variety of Food Choices</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 facilities-item">
                        <a class="facilities-link" data-toggle="modal" href="#facilitiesModal3">
                            <div class="facilities-hover">
                                <div class="facilities-hover-content">
                                    <i class="fa fa-plus fa-3x"></i>
                                </div>
                            </div>
                            <img class="img-fluid" src="imgs/facilities/study_rooms/IMG_3349-min.JPG" alt="">
                        </a>
                        <div class="facilities-caption">
                            <h4>Study Rooms</h4>
                            <p class="text-muted">Open 24/7 for Access</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 facilities-item">
                        <a class="facilities-link" data-toggle="modal" href="#facilitiesModal4">
                            <div class="facilities-hover">
                                <div class="facilities-hover-content">
                                    <i class="fa fa-plus fa-3x"></i>
                                </div>
                            </div>
                            <img class="img-fluid" src="imgs/facilities/sports/IMG_3376-min.JPG" alt="">
                        </a>
                        <div class="facilities-caption">
                            <h4>Sports</h4>
                            <p class="text-muted">Courts, Fields &amp; Gym</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 facilities-item">
                        <a class="facilities-link" data-toggle="modal" href="#facilitiesModal5">
                            <div class="facilities-hover">
                                <div class="facilities-hover-content">
                                    <i class="fa fa-plus fa-3x"></i>
                                </div>
                            </div>
                            <img class="img-fluid" src="imgs/facilities/student_needs/IMG_3368-min.JPG" alt="">
                        </a>
                        <div class="facilities-caption">
                            <h4>Student Needs</h4>
                            <p class="text-muted">WiFi, Shop &amp; Laundry</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 facilities-item">
                        <a class="facilities-link" data-toggle="modal" href="#facilitiesModal6">
                            <div class="facilities-hover">
                                <div class="facilities-hover-content">
                                    <i class="fa fa-plus fa-3x"></i>
                                </div>
                            </div>
                            <img class="img-fluid" src="imgs/facilities/others/IMG_3365-min.JPG" alt="">
                        </a>
                        <div class="facilities-caption">
                            <h4>Others</h4>
                            <p class="text-muted">Surau etc.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- KK8 MANAGEMENT TEAM -->
        <section id="team">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2 class="section-heading">Our Amazing Team</h2>
                        <h3 class="section-subheading text-muted">Its all start with Pengetua</h3>
                    </div>
                </div>

                <!-- College Master-->
                <div class="row">
                    <div class="col-sm-4">
                    </div>
                    <div class="col-sm-4">
                        <div class="team-member">
                            <img class="mx-auto rounded-circle" src="imgs/team/ajwad.jpg" alt="">
                            <h4>Ajwad bin Alias</h4>
                            <p class="text-muted">College Master of <br> Kinabalu Residential College</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="team-member">
                            <img class="mx-auto rounded-circle" src="imgs/team/ray.jpg" alt="">
                            <h4>Muhammad Rahiman bin Abdulmanab</h4>
                            <p class="text-muted">Treasurer/Fellow (SUKAN)</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="team-member">
                            <img class="mx-auto rounded-circle" src="imgs/team/reza.jpg" alt="">
                            <h4>Rezamir bin Rahizar</h4>
                            <p class="text-muted">Secretary/Fellow (ADIN)</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="team-member">
                            <img class="mx-auto rounded-circle" src="imgs/team/faidz.jpg" alt="">
                            <h4>Nur Faidz Hazirah binti Nor'Azman</h4>
                            <p class="text-muted">Fellow (KEMAS)</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="team-member">
                            <img class="mx-auto rounded-circle" src="imgs/team/fitriyani.jpg" alt="">
                            <h4>Raja Fitriyani binti Raja Ibrahim</h4>
                            <p class="text-muted">Fellow (KEP)</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="team-member">
                            <img class="mx-auto rounded-circle" src="imgs/team/shazly.jpg" alt="">
                            <h4>Mohd Shazly bin<br>Mohd Royani</h4>
                            <p class="text-muted">Fellow (SENI)</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- KK8 MEDIA -->
        <section id="media">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2 class="section-heading">Check Out Our Contents!</h2>
                        <h3 class="section-subheading text-muted">Creativities of KK8 Residents</h3>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <iframe width="560" height="315" src="https://www.youtube.com/embed/VUM_QVGGUOI" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                        <div class="col-sm-6">
                            <iframe width="560" height="315" src="https://www.youtube.com/embed/BZRU1RiL_58" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- KK8 MAP -->
        <section id="map">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2 class="section-heading">Locate Us</h2>
                        <h3 class="section-subheading text-muted">Find us at University of Malaya</h3>
                    </div>
                </div>
                <!-- Google Maps API -->
                <div id="google-map"></div>
            </div>
        </section>

    </main>

    <!-- MODALS -->
    <!-- Modal (Log In) -->
    <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <button type="button" class="close" style="position: absolute; right: 0px; margin: 12px;" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="login-form">
                    <form action="processLogin.php" method="post">

                        <div class="avatar">
                            <img id="logo" class="kk8-logo" src="imgs/KK8-LOGO.png" alt="kk8-logo" width="70" height="70">
                        </div>

                        <h4 class="modal-title">Log In Account</h4>

                        <?php

                        // Get 'action' value in url parameter (action=login_failed) to display corresponding 
                        // prompt messages when the login is failed ($action == "login_failed")
                        $action = isset($_GET['action']) ? $_GET['action'] : "";

                        if ($action == "login_failed") {

                            echo "<div class=\"alert alert-danger\" role=\"alert\">";
                            echo "Log In Failed.<br>";

                            if ($_SESSION['invalid_username'])
                                echo "Invalid username. No whitespace allowed.<br>";
                            else
                                echo "Incorrect username or password.";
                            echo "</div>";
                        }

                        ?>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">@</div>
                            </div>
                            <input type="text" name="username" class="form-control" id="inlineFormInputGroupUsername" placeholder="Username" required>
                        </div>

                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </div>
                            </div>
                            <input type="password" name="password" class="form-control" id="inlineFormInputGroupPassword" placeholder="Password" required>
                        </div>

                        <div class="form-group small clearfix">
                            <label class="checkbox-inline"><input type="checkbox" name="remember_me"> Remember me</label>
                            <a href="resetreq.php" class="forgot-link">Forgot Password?</a>
                        </div>

                        <input type="submit" class="btn btn-block btn-primary" value="Login">

                    </form>
                    <div id="no-account" class="text-center small">Don't have an account? <a id="signup-link" onClick="return false;" href="#">Sign up</a></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal (Register - New) -->
    <div class="modal fade" id="register-modal" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <button type="button" class="close" style="position: absolute; right: 0px; margin: 12px;" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="signup-form">
                    <form action="processSignup.php" method="post">

                        <div class="avatar">
                            <img id="logo" class="kk8-logo" src="imgs/KK8-LOGO.png" alt="kk8-logo" width="70" height="70">
                        </div>

                        <h4 class="modal-title">Register Account</h4>

                        <?php

                        // Get 'action' value in url parameter (action=login_failed) to display corresponding 
                        // prompt messages when the login is failed ($action == "login_failed")
                        $action = isset($_GET['action']) ? $_GET['action'] : "";

                        if ($action == "reg_failed") {
                            echo "<div class=\"alert alert-danger\" role=\"alert\">";
                            // echo "Registration failed.<br>";

                            if ($_SESSION['username_taken'] && $_SESSION['email_taken'] && $_SESSION['studentID_taken']) {
                                echo "This account is already registered inside the system.<br>";
                            } else if ($_SESSION['username_taken'] || $_SESSION['email_taken'] || $_SESSION['studentID_taken']) {
                                if ($_SESSION['username_taken']) {
                                    echo "Username already taken.<br>";
                                }
                                if ($_SESSION['email_taken']) {
                                    echo "Email already taken.<br>";
                                }
                                if ($_SESSION['studentID_taken']) {
                                    echo "Matric number already taken.<br>";
                                }
                            }

                            if ($_SESSION['invalid_email'] && $_SESSION['invalid_pass'] && $_SESSION['invalid_username'] && $_SESSION['invalid_studentID']) {
                                echo "Invalid email, password, username and student ID.<br>";
                            } else if ($_SESSION['invalid_email'] || $_SESSION['invalid_pass'] || $_SESSION['invalid_username'] || $_SESSION['invalid_studentID']) {
                                if ($_SESSION['invalid_email']) {
                                    echo "Please register using your Siswa Mail only.<br>";
                                }

                                if ($_SESSION['invalid_pass']) {
                                    echo "Password and Confirm Password do not match.<br>";
                                }

                                if ($_SESSION['invalid_username']) {
                                    echo "Invalid username. No whitespace allowed.<br>";
                                }

                                if ($_SESSION['invalid_studentID']) {
                                    echo "Invalid student ID. Please use the new MAYA student ID (8 digits).<br>";
                                }
                            }

                            echo "</div>";
                        }
                        ?>

                        <div class="container">
                            <div class="row">
                                <div class="form-group">
                                    <form id="login-nav" method="post" role="form" class="form" accept-charset="UTF-8">
                                        <div class="form-group">
                                            <label class="sr-only">Username</label>

                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroupPrepend3">@</span>
                                                </div>
                                                <input type="text" name="username" class="form-control" id="validationServerUsername" placeholder="Username" aria-describedby="inputGroupPrepend3" required>
                                            </div>
                                        </div>

                                        <!-- Password group -->
                                        <div class="form-group">

                                            <!-- Password label -->
                                            <label class="sr-only">Password</label>

                                            <!-- Password input -->
                                            <div class="input-group form-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-lock"></i>
                                                    </div>
                                                </div>

                                                <input type="password" id="reg_userpassword" name="password" class="form-control" data-placement="bottom" data-toggle="popover" data-container="body" data-html="true" value="" placeholder="Password" required>

                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="button" id="button-append1" onclick="togglePassword()">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Password progress bar -->
                                            <div class="progress mt-1" id="reg-password-strength">
                                                <div id="password-strength" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                                                </div>
                                            </div>

                                            <!-- Password remember & results -->
                                            <div class="form-text">
                                                <span id="reg-password-quality" class="hide pull-left block-help">
                                                    <small id="reg-password-strength">Password Strength: <span id="reg-password-quality-result"></span></small>
                                                </span>
                                            </div>

                                            <!-- Password Rules -->
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

                                        <!-- Password-confirm group -->
                                        <div class="form-group">

                                            <!-- Password-confirm label -->
                                            <label class="sr-only">Confirm Password</label>

                                            <!-- Password-confirm input -->
                                            <div class="input-group">
                                                <input type="password" name="cpassword" id="reg_userpasswordconfirm" class="form-control" data-placement="bottom" data-toggle="popover" data-container="body" data-html="true" placeholder="Confirm Password" required>

                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="button" id="button-append2" onclick="togglePassword_Confirm()">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Password-confirm error message -->
                                            <div class="help-block text-left">
                                                <small>
                                                    <span id="error-confirmpassword" class="hide pull-right block-help">
                                                        <i class="fa fa-info-circle text-danger" aria-hidden="true"></i>
                                                        Password mismatch!
                                                    </span>
                                                </small>
                                            </div>

                                        </div>

                                        <!-- Email group -->
                                        <div class="input-group form-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-envelope"></i>
                                                </div>
                                            </div>

                                            <input type="email" id="reg_useremail" name="email" class="form-control" value="" placeholder="Email" required>
                                        </div>

                                        <!-- Matric Number group -->
                                        <div class="input-group form-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-id-card"></i>
                                                </div>
                                            </div>

                                            <input type="name" id="reg_matricnumber" name="matric_number" class="form-control" value="" placeholder="New student ID" required>
                                        </div>

                                        <!-- Security question group -->
                                        <div class="form-group">
                                            <label class="sr-only">Questions</label>
                                            <select id="reg_userquestion" class="form-control" name="sec_question">
                                                <option selected> Select Questions </option>
                                                <option>What's your favorite color?</option>
                                                <option>Street you grew up in?</option>
                                                <option>Name of first pet?</option>
                                                <option>Favourite teacher during high school?</option>
                                                <option>In what city or town was your first job?</option>
                                            </select>
                                        </div>

                                        <!-- Security question answer group -->
                                        <div class="form-group">
                                            <label class="sr-only">Answer</label>
                                            <input type="text" id="reg_useranswer" name="sec_answer" class="form-control" value="" placeholder="Answer" required>
                                        </div>

                                        <!-- Submit -->
                                        <div class="form-group">
                                            <button id="reg_submit" name="submit" value="1" class="btn btn-block btn-primary" disabled="disabled">Register</button>
                                            <div id="sign-up-popover" class="hide">
                                                <p>is empty</p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div id="have-account" class="text-center small">Already have an account? <a id="signin-link" onClick="return false;" href="#">Sign in</a></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Facilities-->
    <!-- Hostels -->
    <div class="facilities-modal modal fade" id="faciltiesModal1" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="close-modal" data-dismiss="modal">
                    <a class="facilities-close">
                        <i class="facilities-modal-close fa fa-times"></i>
                    </a>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 mx-auto">
                            <div class="modal-body">
                                <h2>Hostels</h2>
                                <p class="item-intro text-muted">Kinabalu Residential College has 4 blocks.</p>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <img class="img-fluid d-block mx-auto" src="imgs/sample.jpg" alt="">
                                    </div>
                                    <div class="col-sm-6">
                                        <img class="img-fluid d-block mx-auto" src="imgs/sample.jpg" alt="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <img class="img-fluid d-block mx-auto" src="imgs/sample.jpg" alt="">
                                    </div>
                                    <div class="col-sm-6">
                                        <img class="img-fluid d-block mx-auto" src="imgs/sample.jpg" alt="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <img class="img-fluid d-block mx-auto" src="imgs/sample.jpg" alt="">
                                    </div>
                                    <div class="col-sm-6">
                                        <img class="img-fluid d-block mx-auto" src="imgs/sample.jpg" alt="">
                                    </div>
                                </div>

                                <button class="btn btn-primary" data-dismiss="modal" type="button">
                                    <i class="fa fa-times"></i>
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cafeteria -->
    <div class="facilities-modal modal fade" id="facilitiesModal2" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="close-modal" data-dismiss="modal">
                    <a class="facilities-close">
                        <i class="facilities-modal-close fa fa-times"></i>
                    </a>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 mx-auto">
                            <div class="modal-body">
                                <h2>Cafeteria</h2>
                                <p class="item-intro text-muted">Kinabalu Residential College has 4 blocks.</p>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <img class="img-fluid d-block mx-auto" src="imgs/sample.jpg" alt="">
                                    </div>
                                    <div class="col-sm-6">
                                        <img class="img-fluid d-block mx-auto" src="imgs/sample.jpg" alt="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <img class="img-fluid d-block mx-auto" src="imgs/sample.jpg" alt="">
                                    </div>
                                    <div class="col-sm-6">
                                        <img class="img-fluid d-block mx-auto" src="imgs/sample.jpg" alt="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <img class="img-fluid d-block mx-auto" src="imgs/sample.jpg" alt="">
                                    </div>
                                    <div class="col-sm-6">
                                        <img class="img-fluid d-block mx-auto" src="imgs/sample.jpg" alt="">
                                    </div>
                                </div>

                                <button class="btn btn-primary" data-dismiss="modal" type="button">
                                    <i class="fa fa-times"></i>
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Study Rooms -->
    <div class="facilities-modal modal fade" id="facilitiesModal3" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="close-modal" data-dismiss="modal">
                    <a class="facilities-close">
                        <i class="facilities-modal-close fa fa-times"></i>
                    </a>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 mx-auto">
                            <div class="modal-body">
                                <h2>Study Rooms</h2>
                                <p class="item-intro text-muted">Consisting of The Cube, Seminar Room and PSMKH Room.
                                </p>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <img class="img-fluid d-block mx-auto" src="imgs/facilities/study_rooms/0FF13662-82E7-422F-96C7-328DD75E102F-min.jpg" alt="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <img class="img-fluid d-block mx-auto" src="imgs/facilities/study_rooms/IMG_2078-min.JPG" alt="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <img class="img-fluid d-block mx-auto" src="imgs/facilities/study_rooms/634910EB-E76E-41C9-8D17-6265C18C9F35-min.jpg" alt="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <img class="img-fluid d-block mx-auto" src="imgs/facilities/study_rooms/D75A6300-6A7F-4813-9C8F-973B0BF633F8-min.jpg" alt="">
                                    </div>
                                </div>

                                <button class="btn btn-primary" data-dismiss="modal" type="button">
                                    <i class="fa fa-times"></i>
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="facilities-modal modal fade" id="facilitiesModal4" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="close-modal" data-dismiss="modal">
                    <a class="facilities-close">
                        <i class="facilities-modal-close fa fa-times"></i>
                    </a>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 mx-auto">
                            <div class="modal-body">
                                <h2>Hostels</h2>
                                <p class="item-intro text-muted">Kinabalu Residential College has 4 blocks.</p>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <img class="img-fluid d-block mx-auto" src="imgs/sample.jpg" alt="">
                                    </div>
                                    <div class="col-sm-6">
                                        <img class="img-fluid d-block mx-auto" src="imgs/sample.jpg" alt="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <img class="img-fluid d-block mx-auto" src="imgs/sample.jpg" alt="">
                                    </div>
                                    <div class="col-sm-6">
                                        <img class="img-fluid d-block mx-auto" src="imgs/sample.jpg" alt="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <img class="img-fluid d-block mx-auto" src="imgs/sample.jpg" alt="">
                                    </div>
                                    <div class="col-sm-6">
                                        <img class="img-fluid d-block mx-auto" src="imgs/sample.jpg" alt="">
                                    </div>
                                </div>

                                <button class="btn btn-primary" data-dismiss="modal" type="button">
                                    <i class="fa fa-times"></i>
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="facilities-modal modal fade" id="facilitiesModal5" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="close-modal" data-dismiss="modal">
                    <a class="facilities-close">
                        <i class="facilities-modal-close fa fa-times"></i>
                    </a>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 mx-auto">
                            <div class="modal-body">
                                <h2>Hostels</h2>
                                <p class="item-intro text-muted">Kinabalu Residential College has 4 blocks.</p>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <img class="img-fluid d-block mx-auto" src="imgs/sample.jpg" alt="">
                                    </div>
                                    <div class="col-sm-6">
                                        <img class="img-fluid d-block mx-auto" src="imgs/sample.jpg" alt="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <img class="img-fluid d-block mx-auto" src="imgs/sample.jpg" alt="">
                                    </div>
                                    <div class="col-sm-6">
                                        <img class="img-fluid d-block mx-auto" src="imgs/sample.jpg" alt="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <img class="img-fluid d-block mx-auto" src="imgs/sample.jpg" alt="">
                                    </div>
                                    <div class="col-sm-6">
                                        <img class="img-fluid d-block mx-auto" src="imgs/sample.jpg" alt="">
                                    </div>
                                </div>

                                <button class="btn btn-primary" data-dismiss="modal" type="button">
                                    <i class="fa fa-times"></i>
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="facilities-modal modal fade" id="facilitiesModal6" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="close-modal" data-dismiss="modal">
                    <a class="facilities-close">
                        <i class="facilities-modal-close fa fa-times"></i>
                    </a>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 mx-auto">
                            <div class="modal-body">
                                <h2>Hostels</h2>
                                <p class="item-intro text-muted">Kinabalu Residential College has 4 blocks.</p>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <img class="img-fluid d-block mx-auto" src="imgs/sample.jpg" alt="">
                                    </div>
                                    <div class="col-sm-6">
                                        <img class="img-fluid d-block mx-auto" src="imgs/sample.jpg" alt="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <img class="img-fluid d-block mx-auto" src="imgs/sample.jpg" alt="">
                                    </div>
                                    <div class="col-sm-6">
                                        <img class="img-fluid d-block mx-auto" src="imgs/sample.jpg" alt="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <img class="img-fluid d-block mx-auto" src="imgs/sample.jpg" alt="">
                                    </div>
                                    <div class="col-sm-6">
                                        <img class="img-fluid d-block mx-auto" src="imgs/sample.jpg" alt="">
                                    </div>
                                </div>

                                <button class="btn btn-primary" data-dismiss="modal" type="button">
                                    <i class="fa fa-times"></i>
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <!-- Bootstrap -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <!-- Animate on Scroll -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Custom JS -->
    <script type="text/javascript" src="js/home.js"></script>
    <!-- Google Maps -->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBU-vXpPlrm2_UBJYLzHznpvc_hhYORT8I&callback=initMap">
    </script>


    <?php
    $action = isset($_GET['action']) ? $_GET['action'] : "";

    if ($action == "login_failed") {

        echo "<script>$('#login-modal').modal('show');</script>";
    }
    if ($action == "reg_failed") {

        echo "<script>$('#register-modal').modal('show');</script>";
    }

    if ($action == "login") {
        echo "<script>$('#login-modal').modal('show');</script>";
    }

    ?>
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

</html>
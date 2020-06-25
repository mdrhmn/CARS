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


if($_SESSION['logged_in'] == false)
header("Location: home.php?action=login");

?>

<!DOCTYPE html>
<html>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">

    <!-- Responsive Design -->
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="HandheldFriendly" content="true">
    <meta name="description" content="">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/fontawesome-free-5.13.0-web/css/all.css">
    <link rel="stylesheet" type="text/css" href="css/home.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" type="text/css" href="css/faq.css">

    <title>CARS (FAQs)</title>
</head>

<body>


    <!-- Back-to-top part -->
    <a id="back-to-top" onclick="scrollToTop()">
        <i class="fas fa-chevron-up"></i>
    </a>

    <!-- NAVBAR -->
    <div id="navbar" class="navbar navbar-expand-sm navbar-light navbar-colored" style="padding: 5px 10px;">

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
                    echo '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#login-modal">Log
                        In</button>';
                } ?>

            </div>
    </div>
    <!-- End of navbar -->

    <div class="container justify-content-center">

        <h2 class="text-center"><strong>Frequently Asked Questions</strong></h2>

        <!-- Cards -->
        <div class="px-5 mx-5 my-5">
            <!-- top card -->
            <div class="d-flex justify-content-center">
                <!-- top card left -->
                <div class="col mr-4 px-0">
                    <div class="col-lg-12 px-0 mx-0">
                        <!-- Accordion -->
                        <div id="accordionExample" class="accordion shadow">

                            <!-- Accordion item 1 -->
                            <div class="card">
                                <div id="headingOne" class="card-header bg-white shadow-sm border-0">
                                    <h2 class="mb-0">
                                        <button type="button" data-toggle="collapse" data-target="#collapseOne"
                                            aria-expanded="false" aria-controls="collapseOne"
                                            class="btn btn-link collapsed text-dark font-weight-bold collapsible-link">
                                            <div class="mr-5">How long will it take to process my report?</div>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseOne" aria-labelledby="headingOne" data-parent="#accordionExample"
                                    class="collapse">
                                    <div class="card-body p-5">
                                        <p class="font-weight-light m-0">Your report will be automatically processed
                                            upon submssion. You may view the progress of your report <a
                                                href="helpdesk.php#report">here</a>.</p>
                                    </div>
                                </div>
                            </div><!-- End item 1 -->

                            <!-- Accordion item 2 -->
                            <div class="card">
                                <div id="headingTwo" class="card-header bg-white shadow-sm border-0">
                                    <h2 class="mb-0">
                                        <button type="button" data-toggle="collapse" data-target="#collapseTwo"
                                            aria-expanded="false" aria-controls="collapseTwo"
                                            class="btn btn-link collapsed text-dark font-weight-bold collapsible-link">
                                            <div class="mr-5">If I contact the help desk for assistance, when should I
                                                receive a response?</div>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseTwo" aria-labelledby="headingTwo" data-parent="#accordionExample"
                                    class="collapse">
                                    <div class="card-body p-5">
                                        <p class="font-weight-light m-0">If you send an e-mail during our normal
                                            business hours (Monday through Friday, 8:00am - 5:00pm) you should receive a
                                            prompt reply as soon as a Help desk Consultant or another Information
                                            Technology staff member is available. If you send an e-mail outside of our
                                            normal business hours, we will respond to your message during our next
                                            business day, possibly sooner.</p>
                                    </div>
                                </div>
                            </div><!-- End item 2 -->

                            <!-- Accordion item 3 -->
                            <div class="card">
                                <div id="headingThree" class="card-header bg-white shadow-sm border-0">
                                    <h2 class="mb-0">
                                        <button type="button" data-toggle="collapse" data-target="#collapseThree"
                                            aria-expanded="false" aria-controls="collapseThree"
                                            class="btn btn-link collapsed text-dark font-weight-bold collapsible-link">
                                            <div class="mr-5">Can I make changes on my submitted report?</div>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseThree" aria-labelledby="headingThree" data-parent="#accordionExample"
                                    class="collapse">
                                    <div class="card-body p-5">
                                        <p class="font-weight-light m-0">Yes, you can still make changes on submitted
                                            report that has not completed yet. You may view all of your report <a
                                                href="helpdesk.php#report">here</a> and edit your submission.</p>
                                    </div>
                                </div>
                            </div><!-- End item 3 -->

                        </div><!-- End  accordion -->

                    </div>

                </div>


                <!-- top card right -->
                <div class="col ml-4 px-0">
                    <div class="col-lg-12 px-0 mx-0">
                        <!-- Accordion -->
                        <div id="accordionExample2" class="accordion shadow">

                            <!-- Accordion item 4 -->
                            <div class="card">
                                <div id="headingFour" class="card-header bg-white shadow-sm border-0">
                                    <h2 class="mb-0">
                                        <button type="button" data-toggle="collapse" data-target="#collapseFour"
                                            aria-expanded="false" aria-controls="collapseFour"
                                            class="btn btn-link collapsed text-dark font-weight-bold collapsible-link">
                                            <div class="mr-5">How can I control the level of privacy on my account?
                                            </div>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseFour" aria-labelledby="headingFour" data-parent="#accordionExample2"
                                    class="collapse">
                                    <div class="card-body p-5">
                                        <p class="font-weight-light m-0">Click <a href="usersettings.php">here</a> to
                                            customize your
                                            privacy settings. You can also find this option in your Account Settings.
                                        </p>
                                    </div>
                                </div>
                            </div><!-- End item 4 -->

                            <!-- Accordion item 5 -->
                            <div class="card">
                                <div id="headingFive" class="card-header bg-white shadow-sm border-0">
                                    <h2 class="mb-0">
                                        <button type="button" data-toggle="collapse" data-target="#collapseFive"
                                            aria-expanded="false" aria-controls="collapseFive"
                                            class="btn btn-link collapsed text-dark font-weight-bold collapsible-link">
                                            <div class="mr-5">How do I delete or deactivate my account?</div>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseFive" aria-labelledby="headingFive" data-parent="#accordionExample2"
                                    class="collapse">
                                    <div class="card-body p-5">
                                        <p class="font-weight-light m-0">We’re sorry to hear you’d like to leave. Once
                                            an account has been deleted we’re unable to restore it. Please get in touch
                                            with <a href="mailto:kinabalu@um.edu.my">kinabalu@um.edu.my</a> if you’d
                                            like to share your thoughts about your experience. <br>If you’d still like
                                            to delete your account, click <a
                                                href="usersettings.php#deactivate_1">here</a> to find the deactivate
                                            option.</p>
                                    </div>
                                </div>
                            </div><!-- End item 5 -->

                            <!-- Accordion item 6 -->
                            <div class="card">
                                <div id="headingSix" class="card-header bg-white shadow-sm border-0">
                                    <h2 class="mb-0">
                                        <button type="button" data-toggle="collapse" data-target="#collapseSix"
                                            aria-expanded="false" aria-controls="collapseSix"
                                            class="btn btn-link collapsed text-dark font-weight-bold collapsible-link">
                                            <div class="mr-5">How can I get my account password reset?</div>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseSix" aria-labelledby="headingSix" data-parent="#accordionExample2"
                                    class="collapse">
                                    <div class="card-body p-5">
                                        <p class="font-weight-light m-0">You can click <a
                                                href="usersettings.php">here</a> to change
                                            your password. You can also find this option in your Account Settings.</p>
                                    </div>
                                </div>
                            </div><!-- End item 6 -->

                        </div><!-- End -->
                    </div>
                </div>
            </div>
            <!-- End of bottom acc -->

            <div class="card card-body mx-auto my-5 justify-content-center">
                <div class="media align-items-center align-items-md-start flex-column flex-md-row">
                    <div class="media-body text-center text-md-left">
                        <h6 class="font-weight-semibold">Can't find what you're looking for?</h6> Send your query
                        directly to us.
                    </div>
                    <a href="mailto:kinabalu@um.edu.my" class="btn btn-primary align-self-md-center ml-md-3 mt-md-0"><i
                            class="fas fa-envelope mr-2"></i>Send us an email.</a>
                </div>
            </div>


        </div><!-- End of cards -->

    </div>


    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>

    <script type="text/javascript" src="js/faq.js"></script>

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
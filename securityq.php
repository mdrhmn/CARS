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
    <title>CARS (Security Question)</title>
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
                    <div class="header-container">
                        <a href="javascript:self.history.back();">
                            <img src="imgs/icons/BackBTN2.svg" alt="back" class="back-button mt-1">
                        </a>
                        <h2>Verify that it's you</h2>
                    </div>
                    <?php
                    if (isset($_SESSION['studentID'])) {
                        $studentID = $_SESSION['studentID'];
                    }

                    $result = mysqli_query($mysqli, "SELECT question,answer FROM security_questions_t WHERE studentID=$studentID  ");
                    $res = mysqli_fetch_array($result);
                    $question = $res['question'];

                    ?>
                    <p>Please answer the security question below to confirm that you are the owner of this account.</p>
                    <form method="post" action="securitysettings.php" class="card mt-4">
                        <div class="card-body">
                            <div class="form-group">
                                <!--Label-->
                                <label><?php echo $question; ?> </label>
                                <?php
                                $action = isset($_GET['action']) ? $_GET['action'] : "";
                                if ($action == "invalid_answer") {
                                ?>
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Invalid answer!</strong> Please try again.
                                    </div>
                                <?php
                                }
                                ?>
                                <input class="form-control" name="answer" type="text" required>
                                <small>Case-sensitive</small>
                            </div>
                        </div>

                        <div class="card-footer">
                            <input type="submit" name="verifySecurity" class="btn btn-primary" value="Verify"></input>
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
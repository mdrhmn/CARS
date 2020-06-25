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

//if not logged in, redirect to home page
if($_SESSION['logged_in'] == false)
header("Location: home.php?action=login");

?>

<!DOCTYPE html>
<html>

<head>
    <title>CARS (Activity KEP)</title>

    <!-- BookStrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- RAY's bookstrap -->
    <link rel="stylesheet" type="text/css" href="css/fontawesome-free-5.13.0-web/css/all.css">
    <link rel="stylesheet" type="text/css" href="css/home.css">

    <!-- My CSS -->
    <link rel="stylesheet" type="text/css" href="css/jkp.css">

</head>

<body>

    <!-- Back-to-top part -->
    <a id="back-to-top" onclick="scrollToTop()"><i class="fas fa-chevron-up"></i></a>

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


    <!-- big image at the top -->
    <header class="header-container header80vh">
        <div class="image">
            <img src="imgs/kep/KEPhead.jpg" alt="header-image">
        </div>
        <div class="header-container-info">
            <div class="vertical-center">
                <img class="logo" src="imgs/LogoBackgroundIcon/KEP Logo.png" alt="logo jkp">
                <p class="logo-name spacing">KEP</p>
                <p class="logo-desc">
                    We are JKP KEP. We love everybody regardless of their background
                </p>
            </div>
        </div>
    </header>

    <!-- activity nav bar -->
    <nav>
        <div class="nav-box-ajwad">
            <div class="navbar-ajwad">
                <div class="nav-ajwad notnow"><a href="myActivity.php">MY ACTIVITIES</a></div>
                <div class="nav-ajwad notnow"><a href="jkpADIN.php">ADIN</a></div>
                <div class="nav-ajwad notnow"><a href="jkpKEMAS.php">KEMAS</a></div>
                <div class="nav-ajwad now"><a href="#">KEP</a></div>
                <div class="nav-ajwad notnow"><a href="jkpKREATIVE.php">SENI</a></div>
                <div class="nav-ajwad notnow"><a href="jkpSUKRIA.php">SUKAN</a></div>
            </div>
        </div>
    </nav>

    <main>
        <div class="containerAct">
            <p style="letter-spacing: 2px;">Activities</p>
        </div>
        <div class="gray-container">
            <div class="container">

                <?php
                    // Print all activity with the CORRECT JTK with the "In Progress" STATUS
                    $qry = "SELECT * FROM activity_T WHERE activity_jtk='KEP' AND activity_status='In Progress'";
                    $result = mysqli_query($mysqli,$qry);

                    if(!$result){
                        echo mysqli_error($mysqli);
                    }else{
                        while($row = mysqli_fetch_assoc($result)){
                            // printing out the activity containers
                            echo "<div class='activity-container'>
                                    <div class='activity-container-in'>
                                        <div class='act-image'>
                                            <img src='".$row['activity_image_path']."' alt='activity".$row['activityID']."'>
                                        </div>
                                        <div class='act-between'></div>
                                        <div class='desc'>
                                            <div>
                                                <h3>".$row['activity_name']."</h3>
                                                <P>".$row['activity_desc_short']."</P>
                                            </div>
                                        </div>
                                        <div class='more-info'>
                                            <div class='circle' data-modal-target='#activity".$row['activityID']."'>Click For More Info</div>
                                    </div>
                                </div>
                                </div>
                             <br><br>";

                            // printing out the activity modals
                            echo "<div class='modal-bg' id='activity".$row['activityID']."'>
                                    <div class='modal'>
                                        <div class='modal-content'>
                                            <span class='exit' data-modal-close='#activity".$row['activityID']."'>&times;</span>
                                            <div class='modal-title'>
                                                <h5>".$row['activity_name']."</h5>
                                            </div>
                                            <div class='modal-desc'>
                                                <div class='modal-image'>
                                                    <img src='".$row['activity_image_path']."' alt='activity".$row['activityID']."'>
                                                </div>
                                                <div class='modal-act-desc'>
                                                    <h6>Activity Description:</h6>
                                                    <p>".$row['activity_desc_long']."</p>
                                                    <hr><div class='icon'>";
                                                    
                            // check if the activity have multiple time slots or not 
                            $qryTime = "SELECT * FROM activitytime_t WHERE activityID='".$row['activityID']."'";
                            $resultTime = mysqli_query($mysqli,$qryTime);
                            if(mysqli_num_rows($resultTime)!=0){
                                if(mysqli_num_rows($resultTime)>1){
                                    echo "<img src='imgs/LogoBackgroundIcon/TimeIcon.svg' alt=''>";
                                    echo "Time Slot Available:";
                                    while($time = mysqli_fetch_assoc($resultTime)){
                                        echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; > ".$time['time_slot_available'];
                                    }
                                    echo "<br><br>";
                                }else{
                                    while($time = mysqli_fetch_assoc($resultTime)){
                                        echo "<img src='imgs/LogoBackgroundIcon/TimeIcon.svg' alt=''>";
                                        echo $time['time_slot_available'];
                                    }
                                }
                            }


                            // check if the activity is a one day event or not
                            echo                        "</div><div class='icon'><img src='imgs/LogoBackgroundIcon/DateIcon.svg' alt=''>".$row['activity_date_start'];
                            if($row['activity_date_end']!=null){
                                echo " until ".$row['activity_date_end'];
                            }

                            echo                        "</div><div class='icon'><img src='imgs/LogoBackgroundIcon/LocationIcon.svg' alt=''>".$row['activity_venue']."
                                                    </div>
                                                </div>
                                            </div>
                                            <form id='form".$row['activityID']."' action='registerPage.php' method='GET'>
                                                <input type='text' name='activityID' value='".$row['activityID']."' hidden>
                                            </form>";

                            //checking if this student has registered the actvity or not
                            // yes -> register button will be grayed out
                            $registerd = "SELECT * FROM registration_t WHERE studentID='".$_SESSION["studentID"]."' AND activityID='".$row['activityID']."'";
                            $resultreg = mysqli_query($mysqli,$registerd);
                            if(mysqli_num_rows($resultreg)==1){
                                echo "<div class='modal-button-registered'>
                                    <button class='btn btn-secondary' disabled>Registered</button>
                                </div>";
                            }else{
                                echo "<div class='modal-button'  activityid='".$row['activityID']."'><button class='btn btn-primary'>Register</button></div>";
                            }
                            echo    "</div>
                                </div>
                            </div>";
                        }
                    }
                ?>

            </div>
        </div>
        <?PHP
            mysqli_close($mysqli);
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

    <!-- BootStrap Script -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>

    <!-- my Script -->
    <script src="js/scriptJKP.js"></script>

</body>

</html>
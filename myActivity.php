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
    <title>CARS (My Activities)</title>
    <meta charset="UTF-8">

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
    <header class="cover-main">

        <!-- Cover header -->
        <div id="header-container">
            <h1 id="cover-header">Join our activities</h1>

            <!-- Button to scroll to activity section -->
            <div id="profile-btn" class="form-row text-center">
                <div class="col-12">
                    <button type="button" onclick="coverToProfile()" class="btn btn-primary btn-lg">Register
                        Now!</button>
                </div>
            </div>
        </div>
    </header>

    <!-- Activity Nav -->
    <nav id="activity-nav">
        <div class="nav-box-ajwad">
            <div class="navbar-ajwad">
                <div class="nav-ajwad now"><a href="#">MY ACTIVITIES</a></div>
                <div class="nav-ajwad notnow"><a href="jkpADIN.php">ADIN</a></div>
                <div class="nav-ajwad notnow"><a href="jkpKEMAS.php">KEMAS</a></div>
                <div class="nav-ajwad notnow"><a href="jkpKEP.php">KEP</a></div>
                <div class="nav-ajwad notnow"><a href="jkpKREATIVE.php">SENI</a></div>
                <div class="nav-ajwad notnow"><a href="jkpSUKRIA.php">SUKAN</a></div>
            </div>
        </div>
    </nav>

    <main>
        <div class="containerAct" id="activities-joined">
            <p>Activities Joined</p>
        </div>
        <div class="gray-container">
            <!-- list of joined activity table -->
            <div class="table-container">

                <?php
                    // deleting activity
                    if(empty($_POST['unregisterActID'])==false){

                        // if student has uploaded a file
                        $qryRemoveFile = "SELECT sent_file FROM  registration_t WHERE studentID = ".$_SESSION['studentID']." AND activityID = ".$_POST['unregisterActID']." AND category = 'Volunteer'" ;
                        $filepath = "";
                        $removefileresult = mysqli_query($mysqli,$qryRemoveFile);
                        if(mysqli_num_rows($removefileresult)==1){
                            while($path = mysqli_fetch_assoc($removefileresult)){
                                $filepath = $path['sent_file'];
                                if(file_exists($filepath))
                                    unlink($filepath);
                            }
                        }

                        $qryRemoveAct = "DELETE FROM registration_t
                                         WHERE studentID = ".$_SESSION['studentID']." AND activityID = ".$_POST['unregisterActID'];
                        $removeResult = mysqli_query($mysqli,$qryRemoveAct);
                        $_POST['unregisterActID']="";
                    }
                ?>

                <table class="content-table table-sortable">
                    <thead>
                        <tr class="table-head">
                            <th class="ltc">
                                <div><img class="sorticon" src="imgs/LogoBackgroundIcon/sort.svg"
                                        style="float: right; padding-top: 5px;" alt="" width="15px"></div>No.
                            </th>
                            <th>
                                <div><img class="sorticon" src="imgs/LogoBackgroundIcon/sort.svg"
                                        style="float: right; padding-top: 5px;" alt="" width="15px"></div>Activity Name
                            </th>
                            <th>
                                <div><img class="sorticon" src="imgs/LogoBackgroundIcon/sort.svg"
                                        style="float: right; padding-top: 5px;" alt="" width="15px"></div>JKP
                            </th>
                            <th class="rtc">
                                <div><img class="sorticon" src="imgs/LogoBackgroundIcon/sort.svg"
                                        style="float: right; padding-top: 5px;" alt="" width="15px"></div>Status
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?PHP
                        // finding all activity that this student have registered
                        $qryActReg = "SELECT * 
                                        FROM registration_t
                                        INNER JOIN activity_t
                                        ON registration_t.activityID = activity_t.activityID
                                        WHERE registration_t.studentID = ".$_SESSION['studentID'];

                        $actRegResult = mysqli_query($mysqli,$qryActReg);

                        // if the no registration, print "error"
                        // else print all the activity in table form and their modals
                        if(mysqli_num_rows($actRegResult)==0){
                            // printing "error"
                            echo   "</tbody>
                                    </table>
                                    <h2 style='text-align: center; background-color: white; padding:8%; color:gray'>You have not registered for any activity yet.<br>:')</h2>
                                </div>
                            </div>";
                        }else{
                            // printing activity in table form
                            $count = 1; 
                            while($row = mysqli_fetch_assoc($actRegResult)){
                            echo    "<tr class='act-info' data-modal-target='#activity".$row['activityID']."'>
                                        <td>".$count."</td>
                                        <td>".$row['activity_name']."</td>
                                        <td>".$row['activity_jtk']."</td>
                                        <td>".$row['reg_status']."</td>
                                    </tr>";
                                    $count++;
                            }
                            echo   "</tbody>
                                </table>
                                <p style='font-size: x-small; float: right;'>&nbsp;&nbsp;*click row for more info</p>
                            </div>";

                            // printing all the modals with the information that student selected when registering
                            mysqli_data_seek($actRegResult,0);
                            while($row = mysqli_fetch_assoc($actRegResult)){
                                echo "<div class='modal-bg' id='activity".$row['activityID']."'>
                                        <div class='modal' activityID='".$row['activityID']."'>
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
                                                        <hr>";

                                echo "<br><h6>Registeration Information</h6>";
                                echo "<div class='icon'><p><strong>Category:</strong>&nbsp;".$row['category']."</p></div>";

                                if($row['bureau_picked']!=null){
                                    echo "<div class='icon'><p><strong>Bureau Chosen:</strong>&nbsp;".$row['bureau_picked']."</p></div>";
                                }

                                if($row['reason_joining']!=null){
                                    echo "<div class='icon'><p><strong>Reason(s) Joining:</strong><br>".$row['reason_joining']."</p></div>";
                                }

                                if($row['sent_file']!=null){
                                    $file = explode("_",$row['sent_file'],2);
                                    echo "<div class='icon'><p><strong>File Sent:&nbsp;</strong>".end($file)."</p></div>";
                                }

                                if($row['time_slot_picked']!=null){
                                    echo "<div class='icon'><img src='imgs/LogoBackgroundIcon/TimeIcon.svg' alt=''>".$row['time_slot_picked']."</div>";
                                }
                                echo                   "<div class='icon'><img src='imgs/LogoBackgroundIcon/DateIcon.svg' alt=''>".$row['activity_date_start'];
                                if($row['activity_date_end']!=null){
                                    echo " until ".$row['activity_date_end'];
                                }
                                echo "</div><div class='icon'><img src='imgs/LogoBackgroundIcon/LocationIcon.svg' alt=''>".$row['activity_venue']."</div>

                                                    </div>
                                                </div>";

                                // if the activity status is "completed", remove the "unregister" button
                                if($row['reg_status']=='In Progress'){
                                echo "<div class='modal-button'><button class='btn btn-primary'>Unregister</button></div>";
                                }
                                echo        "</div>
                                        </div>
                                    </div>";
                                }
                        echo "</div>";
                        }       
                    ?>


        <!-- Confirmation Modal -->
        <div class="modal2-bg">
            <div class="modal2">
                <div class="text">
                    <br>
                    <div class="modal2title">
                        <h4>Are you sure?</h4>
                    </div>
                    <hr>
                    <p>Are you sure you want to unregister from this activity?</p>

                    <form id="cofirmUnregister" action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
                        <input hidden type="text" id="activityIDTemp" name="unregisterActID" value="">
                    </form>

                    <p class="modal2-title" style="font-weight: 700;">*inser activity name here*</p>
                </div>
                <div class="confirmchoice">
                    <div class="noBTN"><button class="areyousurebtn btn btn-primary">No</button></div>
                    <div class="unRegBTN"><button class="areyousurebtn btn btn-outline-secondary">Yes</button></div>
                </div>
            </div>
        </div>


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
    <!-- Bootstrap -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>
    <!-- My Script -->
    <script src="js/scriptMyActivity.js"></script>
    <script src="js/sortTable.js"></script>

</body>

</html>
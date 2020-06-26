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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="HandheldFriendly" content="true">
    <meta name="description" content="">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- Animate on Scroll CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" type="text/css" href="css/fontawesome-free-5.13.0-web/css/all.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="css/home.css">
    <link href="css/profilebootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="css/userprofile.css">
    <!-- Google Icon CSS -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <title>CARS (Profile Page)</title>
</head>

<body>
    <?php
        if(isset($_SESSION['logged_in']) && isset($_SESSION['studentID'])){
            $studentID = $_SESSION['studentID'];
        }
        $result = mysqli_query($mysqli,"SELECT username, faculty, biography,profile_pic_path,first_name, last_name, phone_no, twitter_acc, facebook_acc, address, city, state, zip FROM student_t WHERE studentID=$studentID  ");
  
                            
        $res = mysqli_fetch_array($result);
        $username = $res['username'];
        $faculty = $res['faculty'];
        $biography = $res['biography'];
        $image = 'imgs/profilepicture/'.$res["profile_pic_path"];
        $first_name=$res['first_name'];
        $last_name=$res['last_name'];
        $phone_no=$res['phone_no'];
        $twitter_acc = $res['twitter_acc'];
        $facebook_acc = $res['facebook_acc'];
        $address=$res['address'];
        $city=$res['city'];
        $state=$res['state'];
        $zip=$res['zip'];
    
        //split address in sql to two seperate fields
        $address = explode("; ",$address);
        $address2=array_pop($address);
        $address1=implode(" ",$address);
                        
    ?>
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
    </header>
    <main>
       
        <!-- Back-to-top part -->
        <a id="back-to-top" onclick="scrollToTop()">
            <i class="fas fa-chevron-up"></i>
        </a>
        <div class="content">
            <!--Cover-->
            <div class="cover" id="cover" style="min-height:90vh;">
                <div id="header-container">
                   

                    <h1 id="cover-header">Welcome <?php echo $username;?>!</h1>

                    <div>
                        <img src="<?php echo $image;?>" alt="profile picture" class="thumb-lg rounded-circle main-dp mt-4" id="profileDP">
                    </div>

                    <!-- Button to scroll to Profile section -->
                    <div id="profile-btn" class="form-row text-center">
                        <div class="col-12">
                            <button type="button" onclick="coverToProfile()" class="btn btn-primary btn-lg">View Profile</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container" id="profileContainer">
                <!--Profile Header-->
                <div class="row" id="profileHeader">
                    <div class="col-sm-12">
                        <div class="profile-user-box card-box bg-custom">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="float-left mr-3">
                                        <img src="<?php echo $image;?>" alt="" class="thumb-lg rounded-circle "
                                            style="box-shadow: 2px 2px 2px black;border: 4px solid #eee;">
                                    </div>
                                    <div class="media-body text-white">
                                       
                                        <h2 class="mt-1 mb-1 font-18" id="username"
                                            style="text-shadow: 1px 1px 1px black;" >
                                            <?php echo $username;?>
                                        </h2>
                                        <p class="text-light mt-2" id="matric" style="text-shadow: 1px 1px 1px black;">
                                            <?php echo $studentID;?>
                                        </p>
                                        <p class="text-light mb-0 " id="faculty"
                                            style="text-shadow: 1px 1px 1px black; margin-top: -12px;">
                                            <?php echo $faculty;?>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="text-right">
                                        <a href="usersettings.php"class="edit-profile" id="editProfile">
                                            <img src="imgs/icons/edit.svg" alt="edit-icon" class="edit-icon">
                                            Edit Profile
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Left section-->
                <div class="row">
                    <div class="col-xl-4">
                        <!-- Personal-Information -->
                        <div class="card-box">
                            <h4 class="header-title mt-0">Personal Information</h4>
                            <div class="panel-body">
                                <p class="font-13"><?php echo wordwrap($biography,42,"<br>\n",TRUE);?></p>
                                <hr>
                                <div class="text-left">
                                    <?php
                                        $full_name=$first_name." ".$last_name;
                                    ?>
                                    <!-- Full name -->
                                    <p class="font-13"><strong>Full Name:</strong> <span class="m-l-15">
                                        <?php 
                                            if ($full_name!=" " ){
                                                echo $full_name;
                                            }
                                            else{
                                                echo "Please update your profile";
                                            }
                                        ?> 
                                    </span></p>
                                    <!-- Mobile number -->
                                    <p class="font-13"><strong>Mobile:</strong> <span class="m-l-15">
                                        <?php 
                                            if ($phone_no!="" ){
                                                echo $phone_no;
                                            }
                                            else{
                                                echo "Please update your profile";
                                            }
                                        ?> 
                                    </span></p>
                                    <!-- Location -->
                                    <p class="font-13"><strong>Location:</strong> <span class="m-l-15">
                                        <?php 
                                            if (($city!="" ) && ($state!="")){
                                                echo $city.", ".$state;
                                            }
                                            else{
                                                echo "Please update your profile";
                                            }
                                        ?> 
                                    </span></p>
                                </div>
                                <ul class="social-links list-inline mt-4 mb-0">
                                    <li class="list-inline-item"><a href="<?php echo $twitter_acc;?>"><i class="fab fa-twitter"></i></a></li>
                                    <li class="list-inline-item"><a href="<?php echo $facebook_acc;?>"><i class="fab fa-facebook"></i></a></li>
                                </ul>

                            </div>
                        </div>

                        <!-- Notifications -->
                        <div class="card-box ribbon-box">
                            <div class="ribbon ribbon-primary">Notifications</div>
                            <div class="clearfix"></div>
                            <div class="inbox-widget">
                                <a href="#" data-toggle="modal" data-target="#kinaworks">
                                    <div class="inbox-item">
                                        <div class="inbox-item-img"><img src="imgs/projects/kinaworks.png"
                                                class="rounded-circle project-icon" alt="kinaworks icon"></div>
                                        <p class="inbox-item-author">Kinaworks</p>
                                        <p class="inbox-item-text text-limit">Congratulations! Your application has been
                                            accepted</p>

                                    </div>
                                </a>
                                <a href="#" data-toggle="modal" data-target="#kelana">
                                    <div class="inbox-item">
                                        <div class="inbox-item-img"><img src="imgs/projects/kelana.png"
                                                class="rounded-circle project-icon" alt="kelana icon"></div>
                                        <p class="inbox-item-author">Kelana 8th</p>
                                        <p class="inbox-item-text text-limit">We're sorry to inform that your
                                            application has been rejected :(</p>

                                    </div>
                                </a>
                                <a href="#" data-toggle="modal" data-target="#mak">
                                    <div class="inbox-item">
                                        <div class="inbox-item-img"><img src="imgs/projects/mak.png"
                                                class="rounded-circle project-icon" alt="mak icon"></div>
                                        <p class="inbox-item-author">Malam Anugerah Kinabalu</p>
                                        <p class="inbox-item-text text-limit">Please complete the crowdfunding things
                                            ASAP</p>

                                    </div>
                                </a>

                                <a href="#" data-toggle="modal" data-target="#sukmum">
                                    <div class="inbox-item">
                                        <div class="inbox-item-img"><img src="imgs/projects/sukmum.png"
                                                class="rounded-circle project-icon" alt="sukmum icon"></div>
                                        <p class="inbox-item-author">Sukmum 8th</p>
                                        <p class="inbox-item-text text-limit">Great job on your performance! Will be
                                            looking forward to working with you in the future</p>

                                    </div>
                                </a>

                                <!--Notification Modals-->
                                <!--Modal Kinaworks-->
                                <div class="modal fade" id="kinaworks" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-notify modal-info" role="document">
                                        <!--Content-->
                                        <div class="modal-content text-center">
                                            <!--Header-->
                                            <div class="modal-header d-flex justify-content-center">
                                                <h2>Kinaworks</h2>
                                            </div>

                                            <!--Body-->
                                            <div class="modal-body">
                                                <img src="imgs/projects/kinaworks.png"
                                                    class="rounded-circle project-icon " alt="kinaworks icon">
                                                <p class="mt-3">Congratulations! Your application has been accepted</p>

                                            </div>

                                            <!--Footer-->
                                            <div class="modal-footer flex-center">
                                                <a href="#" class="btn btn-outline-primary waves-effect"
                                                    data-dismiss="modal">Dismiss</a>
                                            </div>

                                        </div>
                                        <!--/.Content-->
                                    </div>
                                </div>


                                <!--Modal Kelana-->
                                <div class="modal fade" id="kelana" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-notify modal-info" role="document">
                                        <!--Content-->
                                        <div class="modal-content text-center">
                                            <!--Header-->
                                            <div class="modal-header d-flex justify-content-center">
                                                <h2 class="heading">Kelana 8th</h2>
                                            </div>

                                            <!--Body-->
                                            <div class="modal-body">

                                                <img src="imgs/projects/kelana.png" class="rounded-circle project-icon"
                                                    alt="kelana icon">
                                                <p class="mt-3"> We're sorry to inform that your application has been
                                                    rejected. Try again next year!</p>

                                            </div>

                                            <!--Footer-->
                                            <div class="modal-footer flex-center">
                                                <a href="#" class="btn btn-outline-primary waves-effect"
                                                    data-dismiss="modal">Dismiss</a>
                                            </div>

                                        </div>
                                        <!--/.Content-->
                                    </div>
                                </div>


                                <!--Modal MAK-->
                                <div class="modal fade" id="mak" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-notify modal-info" role="document">
                                        <!--Content-->
                                        <div class="modal-content text-center">
                                            <!--Header-->
                                            <div class="modal-header d-flex justify-content-center">
                                                <h2>Malam Anugerah Kinabalu</h2>
                                            </div>

                                            <!--Body-->
                                            <div class="modal-body">

                                                <img src="imgs/projects/mak.png" class="rounded-circle project-icon"
                                                    alt="mak icon">

                                                <p class="mt-3">Please complete the crowdfunding things ASAP
                                                </p>

                                            </div>

                                            <!--Footer-->
                                            <div class="modal-footer flex-center">
                                                <a href="#" class="btn btn-outline-primary waves-effect"
                                                    data-dismiss="modal">Dimiss</a>
                                            </div>

                                        </div>
                                        <!--/.Content-->
                                    </div>
                                </div>


                                <!--Modal SUKMUM-->
                                <div class="modal fade" id="sukmum" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-notify modal-info" role="document">
                                        <!--Content-->
                                        <div class="modal-content text-center">
                                            <!--Header-->
                                            <div class="modal-header d-flex justify-content-center">
                                                <h2>Sukmum 8th</h2>
                                            </div>

                                            <!--Body-->
                                            <div class="modal-body">

                                                <img src="imgs/projects/sukmum.png" class="rounded-circle project-icon"
                                                    alt="sukmum icon">
                                                <p class="mt-3">Great job on your performance! Will be looking forward
                                                    to working with you in the future</p>

                                            </div>

                                            <!--Footer-->
                                            <div class="modal-footer flex-center">
                                                <a href="#" class="btn btn-outline-primary waves-effect"
                                                    data-dismiss="modal">Dismiss</a>
                                            </div>

                                        </div>
                                        <!--/.Content-->
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>


                    <!--Mid Section-->
                    <div class="col-xl-8">

                         <!--Activity Cards-->
                         <div class="row">
                            <!-- Registered actvities -->
                            <div class="col-sm-6">
                                <div class="card-box ">
                                    <div class="additional">
                                        <div class="user-card">
                                            <img src="imgs/icons//push-pin.svg" alt="push-pin-icon"
                                                class="activity-icon">
                                        </div>
                                        <div class="more-info">
                                            <h5>Registered Activities</h5>
                                            <div class="activities">
                                                <?php
                                                    if(isset($_SESSION['studentID'])){
                                                        $studentID = $_SESSION['studentID'];
                                                    }
                                                    $registered = mysqli_query($mysqli, "SELECT * FROM registration_t WHERE studentID=$studentID AND reg_status='In Progress'");
                                                    if(mysqli_num_rows($registered) == 0){
                                                        echo "<span class=\"mt-3\"> To register for activities, please go to the activity page </span>";
                                                    }
                                                    else if(mysqli_num_rows($registered) > 0){
                                                        
                                                        while($result = mysqli_fetch_assoc($registered)){
                                                            $activityID = $result['activityID'];
                                                            $activity = mysqli_query($mysqli, "SELECT activity_image_path FROM activity_t WHERE activityID=$activityID");
                                                            $res = mysqli_fetch_assoc($activity);
                                                            $activityimage = $res['activity_image_path'];
                                                            echo "<a href=\"myActivity.php\">";
                                                            echo "<img src=\" $activityimage\" class=\"rounded-circle project-icon filter\" alt=\"project icon\">";
                                                            echo "</a>";
                                                            
                                                        }
                                                    }
                                                ?>
                                    
                                            </div>

                                        </div>
                                    </div>
                                    <div class="general">
                                        <div class="general-display">
                                            <?php
                                                if(isset($_SESSION['studentID'])){
                                                    $studentID = $_SESSION['studentID'];
                                                }
                                                $registered = mysqli_query($mysqli,"SELECT COUNT(*) as activitycount FROM registration_t  WHERE studentID=$studentID AND reg_status='In Progress'");
                                                $data = mysqli_fetch_assoc($registered);
                                                $counter = $data['activitycount'];
                                            ?>
                                            <h5>Registered Activities</h5>
                                            <h2><span><?php echo $counter;?></span></h2>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- Completed activities -->
                            <div class="col-sm-6">
                                <div class="card-box alt">
                                    <div class="additional">
                                        <div class="user-card">
                                            <img src="imgs/icons//success.svg" alt="success-icon" class="activity-icon">
                                        </div>
                                        <div class="more-info">
                                            <h5>Completed Activities</h5>
                                            <div class="activities">
                                                <?php
                                                    if(isset($_SESSION['studentID'])){
                                                        $studentID = $_SESSION['studentID'];
                                                    }
                                                    $completed = mysqli_query($mysqli, "SELECT * FROM registration_t WHERE studentID=$studentID AND reg_status='Completed'");
                                                    if(mysqli_num_rows($completed) == 0){
                                                        echo "<span class=\"mt-3\"> You haven't completed any activities yet </span>";
                                                    }
                                                    else if(mysqli_num_rows($completed) > 0){
                                                        while($result = mysqli_fetch_assoc($completed)){
                                                            $activityID = $result['activityID'];
                                                            $activity = mysqli_query($mysqli, "SELECT activity_image_path FROM activity_t WHERE activityID=$activityID");
                                                            $res = mysqli_fetch_assoc($activity);
                                                            $activityimage = $res['activity_image_path'];
                                                            echo "<a href=\"myActivity.php\">";
                                                            echo "<img src=\" $activityimage\" class=\"rounded-circle project-icon filter\" alt=\"project icon\">";
                                                            echo "</a>";
                                                        }
                                                    }
                                                      
                                                ?>
                                            
                                            </div>
                                        </div>
                                    </div>
                                    <div class="general">
                                        <div class="general-display">
                                            <?php
                                                if(isset($_SESSION['studentID'])){
                                                    $studentID = $_SESSION['studentID'];
                                                }
                                                $completed = mysqli_query($mysqli,"SELECT COUNT(*) as activitycount FROM registration_t  WHERE studentID=$studentID AND reg_status='Completed'");
                                                $data = mysqli_fetch_assoc($completed);
                                                $counter = $data['activitycount'];
                                            ?>
                                            <h5>Completed Activities</h5>
                                            <h2><span data-plugin="counterup"><?php echo $counter;?></span></h2>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>

                         <!--Experience-->
                         <div class="card-box">
                            <h4 class="header-title mt-0 mb-3">Experience</h4>
                            <div>
                                <?php
                                    if(isset($_SESSION['studentID'])){
                                        $studentID = $_SESSION['studentID'];
                                    }
                                    $experience = mysqli_query($mysqli,"SELECT * FROM student_exp_t WHERE studentID = $studentID ORDER BY experienceID ASC");
                                    if(mysqli_num_rows($experience) == 0){
                                        echo "<span class=\"mt-3 text-muted\"> You can add your own experience in the user settings page </span>";
                                    }
                                    else if(mysqli_num_rows($experience) > 0){
                                        while($exp = mysqli_fetch_array($experience)){
                                            $experienceID = $exp['experienceID'];
                                            $project = $exp['project'];
                                            $position = $exp['position'];
                                            $startDate = $exp['startDate'];
                                            $endDate = $exp['endDate'];
                                            $details = $exp['details'];
                                ?>   
                                <div>
                                    <h5 class="text-custom"><?php echo $project;?></h5>
                                    <p class="mb-0"><?php echo $position;?></p>
                                    <p><b><?php echo $startDate;?>
                                    <?php if($endDate != '0000-00-00'){
                                        echo "   -   ".$endDate;}
                                        else{echo "(One day event)";}?>
                                    </b></p>
                                    <p class="text-muted font-13 mb-0"><?php echo $details;?></p>
                                </div>
                                <hr>
                                <?php
                                        }
                                    }
                                ?>
                            </div>
                        </div>


                    </div>

                </div>

            </div>

        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script type="text/javascript" src="js/home.js"></script>
    <script src="js/userprofile.js"></script>

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
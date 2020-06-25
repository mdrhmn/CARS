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
    <title>CARS (Register Page)</title>
    <meta charset="UTF-8">

    <!-- BookStrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- RAY's bookstrap -->
    <link rel="stylesheet" type="text/css" href="css/fontawesome-free-5.13.0-web/css/all.css">
    <link rel="stylesheet" type="text/css" href="css/home.css">

    <!-- My CSS -->
    <link rel="stylesheet" type="text/css" href="css/registerActivity.css">
    

    <?PHP
        if(isset($_GET['activityID'])){
            $qry = "SELECT * FROM activity_t WHERE activityID = '".$_GET['activityID']."' AND activity_status = 'In Progress'";
            $result = mysqli_query($mysqli,$qry);
            while($row = mysqli_fetch_assoc($result)){
                $activityName = $row['activity_name'];
                $activityJTK = $row['activity_jtk'];
            };
        }
        $_SESSION['activityID'] = $_GET['activityID'];

        $qryStudentInfo = "SELECT studentID, first_name, last_name, email, phone_no FROM student_t WHERE studentID='".$_SESSION['studentID']."'";
        $resultStudent = mysqli_query($mysqli,$qryStudentInfo);
        while($student = mysqli_fetch_assoc($resultStudent)){
            $ftname = $student['first_name'];
            $lname = $student['last_name'];
            $matrix = $student['studentID'];
            $phoneNo = $student['phone_no'];
            $email = $student['email'];
        }
                        
    ?>


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

    <main>

        <div class="mainContainer">
            <div class="containerAct">
                <?PHP
                    if(isset($_GET['activityID'])==false || mysqli_num_rows($result)==0): 
                ?>
                    <div class="modal-box complete">
                        <h1>No activity was selected</h1>
                        <br>
                        <button id="back2actpage" class="btn btn-primary" onclick="goback()">Back to activity page</button>
                    </div>

                <?php 
                // if the student have registered the activity
                    elseif(isset($_GET['activityID'])):
                    $checkforReg = "SELECT * FROM registration_t WHERE studentID='".$_SESSION["studentID"]."' AND activityID='".$_GET['activityID']."'";
                    $checkforReg = mysqli_query($mysqli,$checkforReg);
                        if(mysqli_num_rows($checkforReg)==0):
                ?>
                <h2>REGISTERING FOR:</h2>
                <div class="backbtn" onclick="goback()"><img src="imgs/LogoBackgroundIcon/BackBTN2.svg" width="40px" alt=""></div>
                <h3 class="activityTitle"><?PHP echo $activityName." (".$activityJTK.")" ?></h3>

                <div class="progressbar">
                    <div class="points step1 done"></div>
                    <div class="points step2"></div>
                    <div class="points step3"></div>
                    <div class="points step4"></div>
                </div>

                <div id="gap">

                </div>


                <!-- QUESTION 1 --------------------------- volunteer or participant -->
                <div class="modal-box Q1 ">
                    <h3><strong> Choose a category </strong></h3>
                    <hr>
                    <div class="chooseType">
                        <?PHP
                        $qryCategoryTime = "SELECT * FROM activitytime_t WHERE activityID='".$_GET['activityID']."'";
                        $resultCT = mysqli_query($mysqli,$qryCategoryTime);
                        if($resultCT->num_rows>=1){
                            echo "<div class='participant'><img src='imgs/LogoBackgroundIcon/participant4x3.jpg' alt=''width='90%'>
                                    <hr>
                                    <p>Participant</p>
                                </div>";
                        }else{
                            echo "<div hidden class='participant'><img src='imgs/LogoBackgroundIcon/participant4x3.jpg' alt=''width='90%'>
                                    <hr>
                                    <p>Participant</p>
                                </div>";
                            
                        }
                        $qryCategoryBiro = "SELECT * FROM activitybureau_t WHERE activityID='".$_GET['activityID']."'";
                        $resultCB = mysqli_query($mysqli,$qryCategoryBiro);
                        if($resultCB->num_rows>=1){
                            echo "<div class='volunteer'><img src='imgs/LogoBackgroundIcon/volunteer4x3.jpg' alt='' width='90%'>
                                    <hr>
                                    <p>Volunteer</p>
                                </div>";
                        }else{
                            echo "<div hidden class='volunteer'><img src='imgs/LogoBackgroundIcon/volunteer4x3.jpg' alt='' width='90%'>
                                    <hr>
                                    <p>Volunteer</p>
                                </div hidden >";
                        }
                        ?>
                        
                    </div>
                    <div class="chooseDesc">
                        <p id="type-desc" style="font-size: small;"></p>
                    </div>
                    <div class="nav-questions">
                        <button class="next-step btn btn-primary" id="btn_1_next">Next</button>
                        <div id="notice1" class="hidden"> *please select a category you want to join &nbsp;&nbsp;</div>
                    </div>
                </div>



                <!-- participant -->
                <div class = "modal-box participantFormBox hidden">
                    <form id="formP" action="registrationComplete.php" method="post">
                        <!-- QUESTION 2 -->
                        <div class="Q2p">
                            <h3><strong> Choose a time slot </strong></h3>
                            <hr>
                            <div class="form-group">
                                <label for="timeSlot">Select a time slot</label>
                                <select name='time_slot' class="form-control col-3" id="timeSlot">
                                <?PHP
                                    while($row = mysqli_fetch_assoc($resultCT)){
                                        echo "<option value='".$row['time_slot_available']."'>".$row['time_slot_available']."</option>";
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                        <!-- QUESTION 3 -->
                        <div class="Q3p hidden">
                            <h3><strong> Personal Information </strong></h3>
                            <hr>
                            <div class="form-group">
                                <div class="name">
                                    <div class="firstname">
                                        <label for="firstname">First Name </label><br>
                                        <input class="form-control-sm col-10 noshadow" name="firstname" type="text" value='<?php echo $ftname ?>' disabled>
                                    </div>
                                    <div class="lastname">
                                        <label for="lastname">Last Name </label><br>
                                        <input class="form-control-sm col-10 noshadow" name="lastname" type="text" value="<?php echo $lname ?>" disabled>
                                    </div>
                                </div>
                                <br>
                                <label for="matrixNo">Matrix Number </label><br>
                                <input class="form-control-sm col-4 noshadow" name="matrixNo" type="text"
                                    value="<?PHP echo $matrix ?>" disabled>
                                <br><br>
                                <label for="mobileNo">Mobile Number </label><br>
                                <input class="form-control-sm col-4 noshadow" name="mobileNo" type="text"
                                    value="<?PHP echo $phoneNo ?>" disabled>
                                <br><br>
                                <label for="email">Email </label><br>
                                <input class="form-control-sm col-6 noshadow" name="email" type="email"
                                    value="<?PHP echo $email ?>" disabled>
                                <br><br>
                                 <!-- below is used for storing file dir. -->
                                <input type="text" value="<?PHP echo $activityName?>" name="actName" hidden>
                                <input type="text" value="<?PHP echo $activityJTK?>" name="actJTK" hidden>
                                <input hidden type="text" name="category" value="Participant">
                            </div> 
                        </div>                       
                    </form>

                    <!-- navigation buttons for participant -->
                    <div class="nav-questions Q2p-nav">
                        <button class="previous-step btn btn-outline-primary" id="btn_2p_prev">Back</button>
                        <button class="next-step btn btn-primary" id="btn_2p_next">Next</button>
                    </div>

                    <div class="nav-questions Q3p-nav hidden">
                        <button class="previous-step btn btn-outline-primary" id="btn_3p_prev">Back</button>
                        <button class="next-step btn btn-primary" onclick="submitForms()">Submit</button>
                    </div>
                </div>


                <!-- Volunteer -->
                <div class="modal-box volunteerFormBox hidden">  
                    <form id="formV" action="registrationComplete.php" method="post" enctype="multipart/form-data">
                        <!-- QUESTION 2 -->
                        <div class="Q2v">
                            <h3><strong> Choose a Bureau to work with! </strong></h3>
                            <hr>
                            <select name='biro_chosen' class='form-control col-3' id='timeSlot'>
                                <?PHP                                 
                                    while($row = mysqli_fetch_assoc($resultCB)){
                                        echo "<option value='".$row['bureau_available']."' onclick={pickBiro('".$row['bureau_available']."')} >".$row['bureau_available']."</option>";
                                    }
                                ?>
                            </select>
                            <div>
                                <p id='biro-desc' style='font-size: small;'></p>
                            </div>
                        </div>
                        <!-- QUESTION 3 -->
                        <div class="Q3v hidden">
                            <h3><strong> Personal Information </strong></h3>
                            <hr>
                            <div class="form-group">
                                <div class="name">
                                    <div class="firstname">
                                        <label for="firstname">First Name </label><br>
                                        <input class="form-control-sm col-10 noshadow" name="firstname" type="text" value="<?php echo $ftname ?>" disabled>
                                    </div>
                                    <div class="lastname">
                                        <label for="lastname">Last Name </label><br>
                                        <input class="form-control-sm col-10 noshadow" name="lastname" type="text" value="<?php echo $lname ?>" disabled>
                                    </div>
                                </div>
                                <br>
                                <label for="matrixNo">Matrix Number </label><br>
                                <input class="form-control-sm col-4 noshadow" name="matrixNo" type="text" value="<?PHP echo $matrix ?>" disabled>
                                <br><br>
                                <label for="mobileNo">Mobile Number </label><br>
                                <input class="form-control-sm col-4 noshadow" name="mobileNo" type="text" value="<?PHP echo $phoneNo ?>" disabled>
                                <br><br>
                                <label for="email">Email </label><br>
                                <input class="form-control-sm col-6 noshadow" name="email" type="email" value="<?PHP echo $email ?>" disabled>
                                <br><br>
                                <label for="reason">Why I am joining:</label>
                                <br>
                                <textarea class="form-control noshadow col-9" name="reason" id="reason" cols="80" rows="5" maxlength="1000"></textarea>
                                <small>*text limit is 1000 characters</small>
                                <br><br>
                                <label for="fileUploaded">Send us a file!</label>
                                <input type="file" class="form-control-file" name="fileUploaded">
                                <small>*Maximum file size is 20MB (zip, rar, pdf, txt, doc, docx)</small>

                                <!-- below is used for storing file dir. -->
                                <input type="text" value="<?PHP echo $activityName?>" name="actName" hidden>
                                <input type="text" value="<?PHP echo $activityJTK?>" name="actJTK" hidden>
                                <input hidden type="text" name="category" value="Volunteer">
                            </div>
                        </div>
                    </form>

                    <!-- navigation buttons for volunteer -->
                    <div class="nav-questions Q2v-nav">
                        <button class="previous-step btn btn-outline-primary" id="btn_2v_prev">Back</button>
                        <button class="next-step btn btn-primary" id="btn_2v_next">Next</button>
                    </div>

                    <div class="nav-questions Q3v-nav hidden">
                        <button class="previous-step btn btn-outline-primary" id="btn_3v_prev">Back</button>
                        <button class="next-step btn btn-primary" onclick="submitForms()">Submit</button>
                    </div>
                </div>

                
                <?PHP
                        else: 
                ?>
                    <div class="modal-box complete">
                        <!-- <img src="imgs/LogoBackgroundIcon/completed.gif" width="30%" alt=""> -->
                        <h1>You are already have registerd this actvity</h1>
                        <br>
                        <button id="back2actpage" class="btn btn-primary" onclick="goback()">Back to activity page</button>
                    </div>
                <?php
                        endif;
                    endif;
                ?>
                    
            </div>
                <br><br><br>
            </div>
        </div>

    

    <?php
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


    <!-- My Script -->
    <script src="js/registerActivityscript.js"></script>
</body>

</html>
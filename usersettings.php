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
else
    header('Location: home.php?action=login');

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


    <link href="css/settingsbootstrap.css" rel="stylesheet">
    <style><?php include 'CSS/usersettings.css';?></style>

    <title>CARS (Settings & Privacy)</title>
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
        <div class="container p-0">

            <!-- Mangage profile and back button -->
            <div class="header-container">
                <a href="userprofile.php">
                    <img src="imgs/icons/BackBTN2.svg" alt="back" class="back-button mt-1">
                </a>
                <h2 class="h3 mb-3">Manage Profile</h2>
            </div>

            <div class="row">
                <!-- Setting Tabs -->
                <div class="col-md-5 col-xl-4">

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Profile Settings</h5>
                        </div>

                        <div class="list-group list-group-flush" id="settingtabs" role="tablist">
                            <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account"
                                role="tab">
                                <img src="imgs/icons/user-3black.svg" alt="account icon" class="tab-icon">
                                Account
                            </a>
                            <a class="list-group-item list-group-item-action" data-toggle="list" href="#password"
                                role="tab">
                                <img src="imgs/icons/locked.svg" alt="password icon" class="tab-icon">
                                Security
                            </a>

                        </div>
                    </div>
                </div>

                <!-- Mid Section Content -->
                <div class="col-md-7 col-xl-8">
                    <div class="tab-content">
                        <!-- ACCOUNT TAB -->
                        <div class="tab-pane fade show active" id="account" role="tabpanel">
                            
                            <!--Public Information-->
                            <div id="publicinfo" class="card">
                                <?php
                                    $action = isset($_GET['action']) ? $_GET['action'] : "";
                                    if ($action == "public_update_successful") {
                                ?>
                                        <div class="ml-2 mt-3 mr-5 alert alert-success alert-dismissible">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            Profile has been updated successfully!
                                        </div>
                                <?php
                                    } else if($action == "file_size_error"){
                                ?>
                                        <div class="ml-2 mt-3 mr-5 alert alert-danger alert-dismissible">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            Please upload files less than 5 MB.
                                         </div>
                                <?php
                                    } else if($action == "file_upload_error"){
                                ?>
                                        <div class="ml-2 mt-3 mr-5 alert alert-danger alert-dismissible">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            File was unable to to be uploaded
                                            </div>
                                <?php
                                    }else if($action == "file_type_error"){
                                ?>
                                        <div class="ml-2 mt-3 mr-5 alert alert-danger alert-dismissible">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            Please upload a file of type jpg, jpeg, or png.
                                        </div>
                                <?php
                                    }else if($action == "username_taken"){
                                ?>
                                    <div class="ml-2 mt-3 mr-5 alert alert-danger alert-dismissible">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        Sorry, username already exists.
                                    </div>
                                <?php
                                    }else if($action == "invalid_deac"){
                                ?>
                                    <div class="ml-2 mt-3 mr-5 alert alert-danger alert-dismissible">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        Password entered during deactivation was invalid, please try again.
                                    </div>
                                <?php
                                    }
                                ?>
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Public info</h5>
                                </div>
                                <div class="card-body">
                                    
                                    <!-- <form id="submitDP" action="accountsettings.php" method="post" enctype="multipart/form-data"></form> -->
                                    <form id="saveAll" action ="accountsettings.php" method="post" enctype="multipart/form-data">
                                        <?php
                                            if(isset($_SESSION['logged_in']) && isset($_SESSION['studentID'])){
                                                $studentID = $_SESSION['studentID'];
                                            }
                                            //echo "Student ID is: ".$studentID;
                                            $result = mysqli_query($mysqli,"SELECT username, faculty, biography FROM student_t WHERE studentID=$studentID  ");

                                            $res = mysqli_fetch_array($result);
                                            $username = $res['username'];
                                            $faculty = $res['faculty'];
                                            $biography = $res['biography'];
                                        ?>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <!-- Username -->
                                                <div class="form-group">
                                                    <label for="inputUsername">Username</label>
                                                    <input type="text" name="username" class="form-control" id="inputUsername"
                                                        value="<?php echo $username;?>">      
                                                </div>
                                                <!-- Matric number/Student ID -->
                                                <div class="form-group">
                                                    <label for="inputMatric">Matric Number</label>
                                                    <input type="text" name="studentID" class="form-control" id="inputMatric"
                                                        value="<?php echo $studentID;?>" disabled>
                                                </div>
                                                <!-- Faculty -->
                                                <div class="form-group">
                                                    <label for="inputFaculty">Faculty</label>
                                                    <select id="inputFaculty" name="faculty" placeholder="Choose..." class="form-control">
                                                        <option selected><?php echo $faculty;?></option>
                                                        <option>Faculty of Arts & Social Sciences</option>
                                                        <option>Faculty of Built Environment</option>
                                                        <option>Faculty of Business & Accountancy</option>
                                                        <option>Faculty of Computer Science & Information Technology
                                                        </option>
                                                        <option>Faculty of Dentistry</option>
                                                        <option>Faculty of Economics & Administration</option>
                                                        <option>Faculty of Education</option>
                                                        <option>Faculty of Engineering</option>
                                                        <option>Faculty of Languages & Linguistics</option>
                                                        <option>Faculty of Law</option>
                                                        <option>Faculty of Science</option>
                                                        <option>Faculty of Medicine</option>
                                                        <option>Faculty of Pharmacy</option>
                                                        <option>Academcy of Islamic Studies</option>
                                                        <option>Academy of Malay Studies</option>
                                                        <option>Asia-Europe Institue</option>
                                                        <option>International Institute of Public Policy & Management
                                                            (INPUMA)</option>
                                                        <option>Cultural Centre</option>
                                                        <option>Sports & Exercises Science Centre</option>
                                                    </select>
                                                </div>
                                                <!-- Biography -->
                                                <div class="form-group">
                                                    <label for="inputUsername">Biography</label>
                                                    <textarea rows="5" name="biography" class="form-control" id="inputBio" placeholder="Tell us something about yourself." maxlength="240" onkeyup="showLimit(this.value)"><?php echo $biography;?></textarea>
                                                    <p><span id="bioLimit"></span></p>
                                                </div>
                                            </div>
                                            <!-- Upload picture -->
                                            <?php
                                                if(isset($_SESSION['logged_in']) && isset($_SESSION['studentID'])){
                                                    $studentID = $_SESSION['studentID'];
                                                }
                                                $result = mysqli_query($mysqli,"SELECT profile_pic_path FROM student_t WHERE studentID=$studentID ");
                                                $res = mysqli_fetch_array($result);
                                                
                                                $image = 'imgs/profilepicture/'.$res["profile_pic_path"];

                                            ?>
                                            <div class="col-md-4">
                                                <div class="text-center">
                                                    <img alt="profile picture" src="<?php echo $image;?>"
                                                        class="rounded-circle img-responsive mt-2" width="128"
                                                        height="128">
                                                    <div class="mt-2">
                                                       <small><input type="file" name="file" class="ml-3"></small> 
                                                       <small>For best results, use an image at least 128px by 128px in .jpg format</small>
                                                        <!-- <input class="mt-3 btn btn-primary" type="submit" name="uploadDP" value="Upload" form="submitDP">       -->
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <input type="submit" name="updatePublic" class="btn btn-primary" value="Save Changes" form="saveAll"></input>
                                    </form>

                                </div>
                            </div>
                            
                            <!--Personal Information-->
                            <div id="personalinfo" class="card">
                                <?php
                                    $action = isset($_GET['action']) ? $_GET['action'] : "";
                                    if ($action == "personal_update_successful") {
                                ?>
                                        <div class="ml-2 mt-3 mr-5 alert alert-success alert-dismissible">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            Profile has been updated successfully!
                                        </div>
                                <?php
                                    }
                                ?>
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Personal information</h5>
                                </div>
                                <div class="card-body">
                                    <form action="accountsettings.php" method="post">
                              
                                        <div class="form-row">
                                            
                                            <!-- First name -->
                                            <div class="form-group col-md-6">
                                                <label for="inputFirstName">First name</label>
                                                <input type="text" name="first_name" class="form-control" id="inputFirstName"
                                                    value="<?php echo $first_name;?>">
                                            </div>
                                            <!-- Second name -->
                                            <div class="form-group col-md-6">
                                                <label for="inputLastName">Last name</label>
                                                <input type="text" name="last_name" class="form-control" id="inputLastName"
                                                    value="<?php echo $last_name;?>">
                                            </div>

                                            </div>

                                            <!-- Phone number -->
                                            <div class="form-group">
                                                <label for="mobileNum">Mobile Number</label>
                                                <input type="integer" name="phone_no" class="form-control" id="mobileNum"
                                                    value="<?php echo $phone_no;?>">
                                            </div>
                                            <!-- Address 1 -->
                                            <div class="form-group">
                                                <label for="inputAddress">Address 1</label>
                                                <input type="text" name="address1" class="form-control" id="inputAddress"
                                                    placeholder="Unit number, house number" value="<?php echo $address1;?>">
                                            </div>
                                            <!-- Address 2 -->
                                            <div class="form-group">
                                                <label for="inputAddress2">Address 2</label>
                                                <input type="text" name="address2" class="form-control" id="inputAddress2"
                                                    placeholder="Building, street name" value="<?php echo $address2;?>">
                                            </div>
                                            <!-- City, State, Zip -->
                                            <div class="form-row">
                                                <!-- City -->
                                                <div class="form-group col-md-6">
                                                    <label for="inputCity">City</label>
                                                    <input type="text" name="city" class="form-control" id="inputCity" value="<?php echo $city; ?>">
                                                </div>
                                                <!-- State -->
                                                <div class="form-group col-md-4">
                                                    <label for="inputState">State</label>
                                                    <select id="inputState" name="state" class="form-control" style="height:45px;">
                                                        <option selected><?php echo $state; ?></option>
                                                        <option>Johor</option>
                                                        <option>Kedah</option>
                                                        <option>Kelantan</option>
                                                        <option>Malacca</option>
                                                        <option>Negeri Sembilan</option>
                                                        <option>Pahang</option>
                                                        <option>Penang</option>
                                                        <option>Perak</option>
                                                        <option>Perlis</option>
                                                        <option>Sabah</option>
                                                        <option>Sarawak</option>
                                                        <option>Selangor</option>
                                                        <option>Terengganu</option>
                                                        <option>Federal Territory of Kuala Lumpur</option>

                                                    </select>
                                                </div>
                                                <!-- Zip -->
                                                <div class="form-group col-md-2">
                                                    <label for="inputZip">Zip</label>
                                                    <input type="text" name="zip" class="form-control" id="inputZip" value="<?php echo $zip;?>">
                                                </div>
                                            </div>
                                            <!-- Social Media Links -->
                                            <div class="form-group">
                                                <label>Social Media Links</label>
                                                <!-- Twitter -->
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fab fa-twitter"></i>
                                                    </div>
                                                    <input type="text" name="twitter_acc" class="form-control" id="socTwitter"
                                                        placeholder="Twitter account link" value="<?php echo $twitter_acc;?>">
                                                </div>
                                                <!-- Facebook -->
                                                <div class="input-group-prepend mt-3">
                                                    <div class="input-group-text">
                                                        <i class="fab fa-facebook"></i>
                                                    </div>
                                                    <input type="text" name="facebook_acc" class="form-control " id="socFacebook"
                                                        placeholder="Facebook account link" value="<?php echo $facebook_acc;?>">
                                                </div>
                                            </div>
                                            <input type="submit" name="updatePersonal" class="btn btn-primary" value="Save Changes"></input>
                                    </form>
                                </div>
                            </div>

                            <!--Experience-->
                            <div id="experience" class="card">
                                <div class="card-header exp-header">
                                    <h5 class="card-title mb-0">Experience</h5>
                                    <a href="#" data-toggle="modal" data-target="#newExp" class="exp-icon-container">
                                        <img src="imgs/icons/add.svg" alt="add-icon" class="exp-icon">
                                    </a>
                                </div>

                                <div class="card-body">
                                    <?php
                                        $action = isset($_GET['action']) ? $_GET['action'] : "";
                                        if ($action == "add_successful") {
                                    ?>
                                            <div class="alert alert-success alert-dismissible" role="alert">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                Experience added successfully!
                                            </div>
                                    <?php
                                        }
                                        else if($action == "experience_deleted"){
                                    ?>
                                            <div class="alert alert-warning alert-dismissible" role="alert">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                Experience has been removed
                                            </div>
                                    <?php
                                        }
                                    ?>
                                    <?php
                                        if(isset($_SESSION['studentID'])){
                                            $studentID = $_SESSION['studentID'];
                                        }
                                        $experience = mysqli_query($mysqli,"SELECT * FROM student_exp_t WHERE studentID = $studentID ORDER BY experienceID ASC");
                                        while($exp = mysqli_fetch_array($experience)){
                                            $experienceID = $exp['experienceID'];
                                            $project = $exp['project'];
                                            $position = $exp['position'];
                                            $startDate = $exp['startDate'];
                                            $endDate = $exp['endDate'];
                                            $details = $exp['details'];
                                     ?>   
                                     <!--Experience view-->
                                        <div>    
                                            <div class="exp-header">
                                                
                                                <h5 class="text-custom"><?php echo $project;?></h5>
                                                <a href="#" data-toggle="modal" data-target="#editExp<?php echo $experienceID;?>" class="exp-icon-container">
                                                    <img src="imgs/icons/edit2.svg" alt="edit-icon" class="exp-icon">
                                                </a>
                                            </div>
                                                <p class="mb-0"><?php echo $position;?></p>
                                                <p><b><?php echo $startDate;?>
                                                <?php if($endDate != '0000-00-00'){
                                                    echo "   -   ".$endDate;}
                                                    else{echo "(One day event)";}?>
                                                </b></p>
                                                <p class="text-muted font-13 mb-0 text-limit"><?php echo $details;?></p>
                                        </div>
                                        <hr>
                                        <!--Edit experience modal-->
                                        <div class="tab-pane modal fade" id="editExp<?php echo $experienceID;?>" tabindex="-1" role="tabpanel" aria-hidden="true">
                                            <div class="modal-dialog modal-notify modal-info" role="document">
                                                
                                                <!--Content-->
                                                <div class="modal-content text-center">
                                                    <!--Header-->
                                                    <div class="modal-header d-flex pb-1">
                                                        <h4>Edit experience</h4>
                                                        <a href="#" class="close" data-dismiss="modal" aria-label="close">&times;</a>
                                                        
                                                    </div>
                                                    <!--Body-->
                                                    <form method="post" action="accountsettings.php">
                                                    <div class="modal-body" style="text-align:left">
                                                            <?php
                                                                $action = isset($_GET['action']) ? $_GET['action'] : "";
                                                                if ($action == "edit_success") { 
                                                            ?>
                                                                    <div class="alert alert-success alert-dismissible" role="alert">
                                                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                                        Changes have been saved!
                                                                    </div>
                                                            <?php
                                                                }
                                                            ?>
                                                            <div class="form-group">
                                                                <label for="project">Project</label>
                                                                <input type="text" name="project" class="form-control"
                                                                    value="<?php echo $project;?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="position">Position</label>
                                                                <input type="text" name="position" class="form-control" 
                                                                    value="<?php echo $position;?>">
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-md-6">
                                                                    <label for="startDate">Start Date</label>
                                                                    <input type="date" name="startDate" class="form-control"
                                                                    value="<?php $startDate; ?>">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="endDate">End Date</label>
                                                                    <input type="date" name="endDate" class="form-control"
                                                                    value="<?php $endDate; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group">
                                                                    <label for="activityinfo">Activity Information</label>
                                                                    <textarea rows="5" name="details" class="form-control" ><?php echo $details;?></textarea>
                                                                </div>
                                                            </div>
                                                    </div>

                                                    <!--Footer-->
                                                    <div class="modal-footer flex-center">
                                                        <input type="hidden" name="experienceID" value=<?php echo $experienceID;?>>
                                                        <input type="hidden" name="studentID" value=<?php echo $studentID;?>>
                                                        <input type="submit" name="delete" class="btn btn-outline-danger mr-5" value="Delete" onClick="return confirm('Are you sure you want to delete?')"></input>
                                                        <div style="width:350px;  display:inline-block;"></div>
                                                        <input type="submit" name="update" class="btn btn-primary" value="Save Changes"></input>
                                                        
                                                        
                                                    </div>
                                                    </form>

                                                </div>
                                                <!--/.Content-->
                                            </div>
                                        </div>
                                    <?php
                                        }
                                    ?>

                                    <!--New experience modal-->
                                    <div class="tab-pane modal fade" id="newExp" tabindex="-1" role="tabpanel" aria-hidden="true">
                                        <div class="modal-dialog modal-notify modal-info" role="document">
                                            <!--Content-->
                                            <div class="modal-content text-center">
                                                <!--Header-->
                                                <div class="modal-header d-flex pb-1">
                                                    <h4>Add experience</h4>
                                                    <a href="#" class="close" data-dismiss="modal" aria-label="close">&times;</a>
                                                </div>
                                                <!--Body-->
                                                <form method="post" action="accountsettings.php">
                                                <div class="modal-body" style="text-align:left">
                                                        <div class="form-group">
                                                            <label for="project">Project</label>
                                                            <input type="text" name="project" class="form-control" id="project"
                                                                placeholder="Enter project name" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="position">Position</label>
                                                            <input type="text" name="position" class="form-control" id="position"
                                                                placeholder="Participant, roles, etc." required>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label for="startDate">Start Date</label>
                                                                <input type="date" name="startDate" class="form-control" id="startDate"
                                                                    required>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="endDate">End Date</label>
                                                                <input type="date" name="endDate" class="form-control" id="endDate"
                                                                    >
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group">
                                                                <label for="activityinfo">Activity Information</label>
                                                                <textarea rows="5" name="details" class="form-control" id="activityinfo"placeholder="Describe your experience for the activity"></textarea>
                                                            </div>
                                                        </div>
                                                </div>

                                                <!--Footer-->
                                                <div class="modal-footer flex-center">
                                                    <!-- <input type="hidden" name="experienceID" value=<?php echo $experienceID;?>>
                                                    <input type="hidden" name="studentID" value=<?php echo $studentID;?>> -->
                                                    <input type="submit" name="add" class="btn btn-primary" value="Add"></input>
                                                </div>
                                                </form>

                                            </div>
                                            <!--/.Content-->
                                        </div>
                                    </div>
                                   
                                </div>
                            </div>
                            

                            <!--Deactivate Account Link-->
                            <div class="card">
                                <div class="card-body" id="deactivate_1"role="tablist">
                                    <a class="deactivate-button" data-toggle="list" href="#deactivate" role="tab">
                                        Deactivate Your Account
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- SECURITY TAB -->
                        <div class="tab-pane fade" id="password" role="tabpanel">
                            <!--Change Email-->
                            <div class="card" id="changeemail">
                                <div class="card-body">
                                    <h5>Change Email</h5>
                                    <div>
                                        <?php
                                            if(isset($_SESSION['logged_in']) && isset($_SESSION['studentID'])){
                                                $studentID = $_SESSION['studentID'];
                                            }
                                            //echo "Student ID is: ".$studentID;
                                            $result = mysqli_query($mysqli,"SELECT email FROM student_t WHERE studentID=$studentID  ");

                                            $res = mysqli_fetch_array($result);
                                            $email = $res['email'];
                                            
                                        ?>
                                        <div class="form-group">
                                            <label for="inputEmail">Email</label>
                                            <input type="email" class="form-control" id="inputEmail"
                                                value="<?php echo $email;?>" disabled>
                                            <small class="ml-1">You may only change your email through siswamail</small>

                                        </div>
                                    </div>
                                    
                                </div>
                            </div>

                            <!--Change Password-->
                            <div class="card" id="changepass">
                                <div class="card-body">
                                    <h5 class="card-title">Change Password</h5>

                                        <div class="form-group">
                                            <?php
                                                $action = isset($_GET['action']) ? $_GET['action'] : "";
                                                if ($action == "password_match") {
                                            ?>
                                                <div class="alert alert-success alert-dismissible" role="alert">
                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                    <strong>Password match!</strong> You can now proceed with your password change
                                                </div>
                                            <?php
                                                }
                                                else if($action == "invalid_pass"){
                                            ?>
                                                 <div class="alert alert-danger alert-dismissible" role="alert">
                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                    <strong>Incorrect password!</strong> Please try again
                                                </div>
                                            <?php
                                                }
                                                else if($action == "update_success"){
                                            ?>
                                                <div class="alert alert-success alert-dismissible" role="alert">
                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                    Password updated successfully!
                                                </div>
                                            <?php
                                                }else if($action == "password_error"){
                                            ?>
                                                <div class="alert alert-warning alert-dismissible" role="alert">
                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                    New password cannot be similar to your previous one. Please try again
                                                </div>
                                            <?php
                                                }
                                            ?>

                                            <!-- Verifies current password -->
                                            <form method="post" action="securitysettings.php">
                                            <div id="currentpassfield">
                                                <label for="inputPasswordCurrent">Enter your current password</label>
                                                <div>
                                                    <input type="password" name="inputpass" class="form-control" id="inputPasswordCurrent" placeholder="Enter current password">

                                                    <small class="ml-1">
                                                        <a href="resetreq.php">Forgot your
                                                            password?
                                                        </a>
                                                    </small>
                                                </div>
                                               
                                                <input id="verifyPass" type="submit" name="verifyPass" class="mt-3 btn btn-primary" value="Verify"></input>
                                            </div>
                                                
                                            </form>
                                    
    
                                        </div>
                                        
                                        <!-- Password change -->
                                        <form method="post" action="securitysettings.php">
                                            <div id="passfield" class="form-group" style="display:none;" >
                                                <!--Label-->
                                                <label>New password</label>

                                                <!--Password input-->
                                                <div class="input-group form-group">
                                                    <input type="password" id="reg_userpassword" name="newPass"
                                                        class="form-control" data-placement="bottom" data-toggle="popover"
                                                        data-container="body" data-html="true" value=""
                                                        placeholder="Password">
                                                        
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            id="button-append1" onclick="togglePassword()">
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                                <!--Password Progress Bar-->
                                                <div class="progress mt-1" id="reg-password-strength">
                                                    <div id="password-strength" class="progress-bar progress-bar-success"
                                                        role="progressbar" aria-valuenow="40" aria-valuemin="0"
                                                        aria-valuemax="100" style="width:0%">
                                                    </div>
                                                </div>

                                                <!--Password remember and results-->
                                                <div class="form-text">
                                                    <span id="reg-password-quality" class="hide pull-left block-help">
                                                        <small id="reg-password-strength">Password Strength: <span
                                                                id="reg-password-quality-result"></span></small>
                                                    </span>
                                                </div>
                                                <!--Password Rules-->
                                                <div id="reg_passwordrules" class="hide password-rule mt-2">
                                                    <small>
                                                        <ul class="list-unstyled">
                                                            <li class="">
                                                                <span class="eight-character"><i class="fa fa-check-circle"
                                                                        aria-hidden="true"></i></span>
                                                                &nbsp; Min. 8 characters</li>
                                                            <li class="">
                                                                <span class="low-upper-case"><i class="fa fa-check-circle"
                                                                        aria-hidden="true"></i></span>
                                                                &nbsp; Min. 1 uppercase & 1 lowercase character</li>
                                                            <li class="">
                                                                <span class="one-number"><i class="fa fa-check-circle"
                                                                        aria-hidden="true"></i></span>
                                                                &nbsp; Min. 1 number</li>
                                                            <li class="">
                                                                <span class="one-special-char"><i class="fa fa-check-circle"
                                                                        aria-hidden="true"></i></span>
                                                                &nbsp; Min. 1 special character (!@#$%^&*)</li>
                                                        </ul>
                                                    </small>
                                                </div>
                                            </div>

                                            <div id="confirmpassfield" class="form-group" style="display:none;">
                                                <!-- Password-confirm label -->
                                                <label>Confirm Password</label>

                                                <!-- Password-confirm input -->
                                                <div class="input-group">
                                                    <input type="password" id="reg_userpasswordconfirm" name="confirmPass" 
                                                        class="form-control"  data-placement="bottom" data-toggle="popover" 
                                                        data-container="body" data-html="true" 
                                                        placeholder="Confirm Password" required >

                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            id="button-append2" onclick="togglePassword_Confirm()">
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                                <!-- Password-confirm error message -->
                                                <div class="help-block text-left">
                                                    <small><span id="error-confirmpassword"
                                                            class="hide pull-right block-help">
                                                            <i class="fa fa-info-circle text-danger" aria-hidden="true"></i>
                                                            Password mismatch!</span></small>
                                                </div>
                                            </div>
                                            <input id="submitpass" type="submit" name="updateChange" class="btn btn-primary" style="display:none;" value="Save Changes" ></input>
                                        </form>

                                </div>
                            </div>

                            <!-- Security Question -->
                            <div class="card" id="changesec">
                                <div class="card-body">
                                    <h5 class="card-title">Security Question</h5>
                                    <?php
                                        if(isset($_SESSION['logged_in']) && isset($_SESSION['studentID'])){
                                            $studentID = $_SESSION['studentID'];
                                        }

                                        $result = mysqli_query($mysqli,"SELECT question,answer FROM student_t WHERE studentID=$studentID  ");
                                        $res = mysqli_fetch_array($result);
                                        $question = $res['question'];
                                        $answer = $res['answer'];
                                    ?>
                                    <form action="securitysettings.php" method="post">
                                        <!-- Question -->
                                        <div class="form-group">
                                            <?php
                                                $action = isset($_GET['action']) ? $_GET['action'] : "";
                                                if ($action == "password_match_security") {
                                            ?>
                                                <div class="alert alert-success alert-dismissible" role="alert">
                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                    <strong>Password match!</strong> You can now change your security question
                                                </div>
                                            <?php
                                                }
                                                else if($action == "securityq_update_successfully"){
                                            ?>
                                                <div class="alert alert-success alert-dismissible" role="alert">
                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                    Security questions updated successfully!
                                                </div>
                                            <?php
                                                }
                                            ?>

                                            <label>Question</label>
                                            <select id="reg_userquestion" class="form-control" name="user_question" disabled>
                                                <option> Select Questions </option>
                                                <option selected><?php echo $question; ?></option>
                                                <option>Street you grew up in?</option>
                                                <option>Name of first pet?</option>
                                                <option>Favorite teacher during high school?</option>
                                                <option>In what city or town was your first job?</option>
                                            </select>
                                            <small id="changeopt" class="ml-1">
                                                <a href="#" data-toggle="modal" data-target="#sec_modal">
                                                    Change question
                                                </a>
                                            </small>
                                        </div>

                                        <div id="sec_ans" class="form-group" style="display:none;" >
                                            <label class="sr-only">Answer</label>
                                            <input type="text" id="reg_useranswer" name="user_answer"
                                                class="form-control" value="<?php echo $answer;?>" 
                                            placeholder="Answer">
                                        </div>

                                        <input id="submit_sec" type="submit" class="btn btn-primary" name="updateSecurity" style="display:none;"  value="Save Changes"></input>

                                    </form>
                                    <!-- Verification to change securtiy question -->
                                    <div class="tab-pane modal fade" id="sec_modal" tabindex="-1" role="tabpanel"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-notify modal-info" role="document">
                                            <!--Content-->
                                            <div class="modal-content text-center">
                                                <!--Header-->
                                                <div class="modal-header d-flex pb-1">
                                                    <h2>Verify your password</h2>
                                                    <a href="#" class="close" data-dismiss="modal" aria-label="close">&times;</a>
                                                </div>
                                                <!--Body-->
                                                <form action="securitysettings.php" method="post">
                                                    <div class="modal-body" style="text-align:left">
                                                        <?php
                                                            $action = isset($_GET['action']) ? $_GET['action'] : "";
                                                            if ($action == "invalid_pass_security") {   
                                                        ?>
                                                            <div class="alert alert-danger alert-dismissible" role="alert">
                                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                                <strong>Incorrect password!</strong> Please try again.
                                                            </div>
                                                        <?php
                                                            }
                                                        ?>
                                                        <p class="text-muted">Please re-enter your CARS password to change your security question</p>
                                                            <label for="email-for-pass">Password</label>
                                                            <input class="form-control" name="inputpass" type="password" id="pass-for-pass" required="">
                                                        
                                                    </div>

                                                    <!--Footer-->
                                                    <div class="modal-footer flex-center">
                                                        <input type="submit" name="verifyPassSec" class="btn btn-primary waves-effect" value="Verify"></input>
                                                    </div>
                                                </form>
                                            </div>
                                            <!--/.Content-->
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- DEACTIVATE ACCOUNT -->
                        <div class="tab-pane fade" id="deactivate" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Deactivate Your Account</h5>

                                    <div class="deactivate-info">
            
                                        <a href="userprofile.php" style="text-decoration:none">
                                            <div class="profile-preview">
                                            
                                                <img alt="default picture" src="<?php echo $image;?>"
                                                    class="rounded-circle img-responsive mt-2" width="60" height="60">
                                                <span style="font-size:20px"><?php echo $username;?></span>
                                            </div>
                                        </a>

                                    </div>

                                    <div class="deactivate-info">
                                        <h5>This will deactivate your account</h5>
                                        <p>You’re about to start the process of deactivating your CARS account. Your
                                            display name, @username, and public profile will no longer be viewable on
                                            CARS.com</p>
                                    </div>

                                    <div class="deactivate-info">
                                        <form>
                                            <h5>What else you should know</h5>
                                            <div>
                                                <p>If you just want to change your @username, you don’t need to
                                                    deactivate your account — edit it in your settings.</p>
                                            </div>
                                            <div>
                                                <p>To use your current @username or email address with a different CARS
                                                    account, change them before you deactivate this account.</p>
                                            </div>
                                        </form>
                                    </div>

                                    <div id="deactivateConfirm" class="card-body" role="tablist">

                                        <a class="deactivate-button" data-toggle="list" href="#confirmation" role="tab">
                                            Deactivate Your Account
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- DEACTIVATE TAB -->
                        <div class="tab-pane fade" id="confirmation" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Re-enter Password</h5>
                                    <form method="post" action="accountsettings.php">
                                        <div class="form-group">
                                            <label for="deactivatePass">Confirm your deactivation by re-entering your
                                                current password</label>
                                            <input type="password" name="password" class="form-control" id="deactivatePass"
                                                placeholder="Enter Password" required>
                                        </div>
                                        
                                        <input type="submit" name="deleteAcc" class="btn btn-danger" value="Deactivate"></input>
                                    </form>

                                </div>
                            </div>
                        </div>


                    </div> <!-- END TAB CONTENT-->
                </div> <!-- END MIDDLE PART-->
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
    <script src="http://netdna.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script type="text/javascript" src="js/home.js"></script>
    <script type="text/javascript" src="js/usersettings.js"></script>
    
     <!-- using AJAX to climit characters in biography -->
     <script>
        function showLimit(str) {
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
            document.getElementById("bioLimit").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "accountsettings.php?bio="+str, true);
        xhttp.send();   
        }
    </script>

    <!-- Personal details change -->
    <?php
         $action = isset($_GET['action']) ? $_GET['action'] : "";
         if ($action == "personal_update_successful") {
    ?>
        <script>
            document.getElementById("personalinfo").scrollIntoView();

        </script>
    <?php
         } else if (($action == "add_successful")|| ($action == "experience_deleted")){ // Add experience
    ?>
        <script>
            document.getElementById("experience").scrollIntoView();
        </script>
    <?php
         }
    ?>

    <!-- Opens experience modal after edit -->
    <?php
        $action = isset($_GET['action']) ? $_GET['action'] : "";
        if ($action == "edit_success") {
            $experienceID = $_GET['experienceID'];
            echo "<script>$('#editExp$experienceID').modal('show');</script>";
        }
    ?>

    <!-- Password changes -->
    <?php
         $action = isset($_GET['action']) ? $_GET['action'] : "";
         if (($action == "password_match")||($action == "password_error")) {
    ?>
        <script>
            document.getElementById("passfield").removeAttribute("style");
            document.getElementById("confirmpassfield").removeAttribute("style");
            document.getElementById("submitpass").removeAttribute("style");
            document.getElementById("currentpassfield").style.display="none";
            $('#settingtabs a[href="#password"]').tab('show');
        </script>
    <?php
         } else if(($action == "update_success") || ($action == "invalid_pass") || ($action == "securityq_update_successfully") )  {
            echo "<script> $('#settingtabs a[href=\"#password\"]').tab('show')</script>";
         }
    ?>

    <!-- Security question changes -->
    <?php
        $action = isset($_GET['action']) ? $_GET['action'] : "";
        if ($action == "invalid_pass_security") {
    ?>
        <script>
            $('#settingtabs a[href="#password"]').tab('show');
            $('#sec_modal').modal('show');
        </script>
    <?php 
        } else if($action == "password_match_security") {
    ?>
        <script>
            $('#settingtabs a[href="#password"]').tab('show');
            document.getElementById("reg_userquestion").disabled=false;
            document.getElementById("sec_ans").removeAttribute("style");
            document.getElementById("submit_sec").removeAttribute("style");
            document.getElementById("changeopt").style.display="none";

        </script>
    <?php
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
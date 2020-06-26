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

if ($_SESSION['logged_in'] == false)
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/fontawesome-free-5.13.0-web/css/all.css">
    <link rel="stylesheet" type="text/css" href="css/home.css">
    <link rel="stylesheet" type="text/css" href="css/form.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="js/jquery-1.12.0.min.js" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            $("#sel_category").change(function() {
                var cateid = $(this).val();

                $.ajax({
                    url: 'getType.php',
                    type: 'post',
                    data: {
                        cat: cateid
                    },
                    dataType: 'json',
                    success: function(response) {

                        var len = response.length;

                        $("#sel_type").empty();
                        for (var i = 0; i < len; i++) {
                            var id = response[i]['id'];
                            var name = response[i]['name'];

                            $("#sel_type").append("<option value='" + name + "'>" + name + "</option>");

                        }
                    }
                });
            });

        });
    </script>

    <title>CARS (Report Form)</title>
</head>

<body>
    <header class="blog-header py-5">

    </header>

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
                                <a href="#" data-toggle="dropdown" id="username_profile" class="nav-link dropdown-toggle user-action">
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
    <!-- End of navbar -->

    <div class="container" style="width: 75%">

        <h2 class="text-center"><strong>Complaint Form</strong></h2>

        <div class="container-fluid px-1 py-3 mb-5">
            <div class="row d-flex justify-content-center">
                <div class="col-md-11">

                    <div class="card">
                        <div class="alert alert-warning" role="alert">Please fill in this form. Required information is
                            marked with an asterisk (*).</div>

                        <form class="form-horizontal" id="thefrm" enctype="multipart/form-data" name="thefrm" method="post" action="processForm.php">

                            <div class="form-group">
                                <label for="problem" class="col-md-6 control-label px-0"><strong>Problem Category
                                        *</strong></label>
                                <div class="col-md-12 px-0">
                                    <select id="sel_category" name="category" class="form-control select2" style="width: 100%;" required>
                                        <option value="0">- Select -</option>
                                        <?php
                                        // Fetch category
                                        $sql_category = "SELECT DISTINCT category FROM type_T";
                                        $category_data = mysqli_query($mysqli, $sql_category);
                                        while ($row = mysqli_fetch_assoc($category_data)) {
                                            $cat_name = $row['category'];

                                            // Option
                                            echo "<option value='" . $cat_name . "' >" . $cat_name . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="problem" class="col-md-6 control-label px-0"><strong>Problem Type
                                        *</strong></label>
                                <div class="col-md-12 px-0">
                                    <select id="sel_type" name="type" class="form-control select2" style="width: 100%;" required>
                                        <option value="0">- Select -</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="details" class="col-md-6 control-label px-0"><strong>Problem
                                        Details</strong></label>
                                <div class="col-md-12 px-0">
                                    <textarea name="details" rows="3" class="form-control" id="message1" placeholder="Please describe your problem"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="phoneNo" class="col-md-6 control-label px-0"><strong>Mobile Phone No
                                        *</strong></label>
                                <div class="col-md-12 px-0">
                                    <input name="phoneNo" type="text" class="form-control" id="tel" value="" placeholder="Enter mobile phone no" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="location" class="col-md-6 control-label px-0"><strong>Problem Location
                                        *</strong></label>
                                <div class="col-md-12 px-0">
                                    <textarea name="location" rows="3" class="form-control" id="hd_location" placeholder="Please describe your problem location" required></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputFile" class="col-md-6 control-label px-0"><strong>Upload
                                        File</strong></label>
                                <div class="col-md-12 px-0">
                                    <input name="file" type="file" id="uploadedfile">
                                    <p class="help-block">Note: only .jpg/jpeg, .gif, .png, .pdf, .doc, .docx files allowed. Maximum file size 5
                                        MB.</p>
                                </div>
                            </div>

                            <div class="my-auto">
                                <a href="helpdesk.php" class="btn btn-light btn-outline-secondary pull-right" role="button" aria-pressed="true">Cancel</a>
                                <button type="submit" value="Submit" class="btn btn-primary my-0">Submit</button>
                            </div>

                    </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
    </div>


    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <script type="text/javascript" src="js/form.js"></script>



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
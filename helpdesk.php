<?php
// Start the session
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

$ct =0;
$output = '';
//colect
if(isset($_POST['search'])) {
    $studentID = $_SESSION['studentID'];
    $searchq = $_POST['search'];

    $sqls = "SELECT * FROM complaint_t WHERE studentID = '$studentID' AND complaint_type LIKE '%".$searchq."%'";
    $results = mysqli_query($mysqli, $sqls);
    $count = mysqli_num_rows($results);

    if($count == 0) {
        $output = 'There was no search results.';
    } else {
        $ct = 1;
    }
}
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/fontawesome-free-5.13.0-web/css/all.css">
    <link rel="stylesheet" type="text/css" href="css/home.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" type="text/css" href="css/helpdesk.css">

    <title>CARS (Help Desk)</title>
</head>

<body>
    <header class="dark-bg"></header>

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


    <!-- Section 1 -->
    <div class="top-sec">
        <div id="header-container">
            <div class="text-center mb-4">
                <h1 id="cover-header">Welcome to our Help Desk</h1>
                <h3>How can we help you?</h3>
            </div>
            <!-- <br> -->

            <div class="top-in">
                <a href="faq.php" class="mx-3">
                    <figure class="one">
                        <figcaption>
                            <h2>FAQs</h2>
                            <p>Head over our frequently asked questions.</p>
                        </figcaption>
                    </figure>
                </a>

                <a href="#report" class="mx-3">
                    <figure class="two">
                        <figcaption>
                            <h2>My Report</h2>
                            <p>Retrieve your summitted report to helpdesk.</p>
                        </figcaption>
                    </figure>
                </a>
            </div>
        </div>
    </div>


    <div class="container my-5 white-bg rpt" id="report">
        <h2><strong>Report an Issue</strong></h2>
        <hr>

        <h2 class="comp my-4"><i class="fa fa-edit"></i>My Complaint(s)</h2>

        <div class="row">
            <div class="col-lg-4">
                <div class="info-box green-bg rounded">
                    <i class="fa fa-check-circle py-auto float"></i>
                    <?php
                    $sql = "SELECT complaint_status FROM complaint_t WHERE complaint_status='Completed' AND studentID=$studentID";
                    $result = mysqli_query($mysqli, $sql);
                    $rowcount = mysqli_num_rows($result);
                    echo "<div class='count'>".$rowcount;
                    ?>
                    <div class="title">Completed  </div></div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="info-box yellow-bg rounded">
                    <i class="fa fa-clock float"></i>
                    <?php
                    $sql = "SELECT complaint_status FROM complaint_t WHERE complaint_status='In progress' AND studentID=$studentID";
                    $result = mysqli_query($mysqli, $sql);
                    $rowcount = mysqli_num_rows($result);
                    echo "<div class='count'>".$rowcount;
                    ?>
                    <div class="title">In progress </div></div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="info-box red-bg rounded">
                    <i class="fa fa-exclamation-circle"></i>
                    <?php
                    $sql = "SELECT complaint_status FROM complaint_t WHERE complaint_status='Pending' AND studentID=$studentID";
                    $result = mysqli_query($mysqli, $sql);
                    $rowcount = mysqli_num_rows($result);
                    echo "<div class='count'>".$rowcount;
                    ?>
                    <div class="title">Pending            </div></div>
                </div>
            </div>
        </div>

        <div class="bg-transparent clearfix">
            <div class="search-row">
                <form action="helpdesk.php" method="post">
                <input class="form-control" name="search" placeholder="Search" type="text"></form>
                <?php if($output != null && $count == 0){print($output);} ?>

            </div>

            <div><a href="form.php" class="btn btn-primary float-right" role="button" aria-pressed="true">Create
                    New</a></div>
        </div>

        <table class="content-table table-sortable">
            <thead>
                <tr class="table-head">
                    <th>
                        <div><img class="sorticon" src="imgs/hdesk/sort.svg" style="float: right; padding-top: 5px;"
                                alt="" width="15px"></div>No.
                    </th>
                    <th>
                        <div><img class="sorticon" src="imgs/hdesk/sort.svg" style="float: right; padding-top: 5px;"
                                alt="" width="15px"></div>Problem Type
                    </th>
                    <th>
                        <div><img class="sorticon" src="imgs/hdesk/sort.svg" style="float: right; padding-top: 5px;"
                                alt="" width="15px"></div>Status
                    </th>
                    <th>
                        <div><img class="sorticon" src="imgs/hdesk/sort.svg" style="float: right; padding-top: 5px;"
                                alt="" width="15px"></div>Date
                    </th>
                    <th>
                        <div><img class="sorticon" src="imgs/hdesk/sort.svg" style="float: right; padding-top: 5px;"
                                alt="" width="15px"></div>Satisfaction
                    </th>
                    <th>
                        <div><img class="sorticon" src="imgs/hdesk/sort.svg" style="float: right; padding-top: 5px;"
                                alt="" width="15px"></div>Edit
                    </th>
                </tr>
            </thead>

            <tbody>

            <?php
            if($ct>0){
                $cnt = 1;
                if (mysqli_num_rows($results) > 0) {
                    while($row = mysqli_fetch_assoc($results)) {
                        echo "<tr>
                        <td>".$cnt++."</td>
                        <td>". $row["complaint_type"]."</td>";
                        if($row["complaint_status"]=='Completed'){
                            echo "<td><label class='badge badge-success'>Completed</label></td>";
                            echo "<td>". $row["complaint_date"]."</td>";
                            if($row["complaint_rate"] == 0) {
                                echo "<td><a class='nav-link px-0' data-toggle='modal' data-target='#exampleModal' href='#'>Click here to rate</a></td>
                                <div class='modal fade' id='exampleModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                    <div class='modal-dialog modal-dialog-centered modal-sm'>
                                        <div class='modal-content'>
                                            <div class='modal-header py-0'>
                                                <h5 class='modal-title my-auto' id='exampleModalLabel'>Rate Your Satisfaction</h5>
                                                <button type='button' class='testx' data-dismiss='modal' aria-label='Close'>
                                                    <span aria-hidden='true'>&times;</span>
                                                </button>
                                            </div>
                                
                                            <div class='modal-body mx-auto text-center'>
                                                <form id='review-form' action='processEdit.php' method='post'>
                                
                                                <div class='fieldset w3hubs mt-1'>
                                                    <input type='radio' name='rate' value='5' id='star5'><label for='star5'></label>
                                                    <input type='radio' name='rate' value='4' id='star4'><label for='star4'></label>
                                                    <input type='radio' name='rate' value='3' id='star3'><label for='star3'></label>
                                                    <input type='radio' name='rate' value='2' id='star2'><label for='star2'></label>
                                                    <input type='radio' name='rate' value='1' id='star1' required=''><label for='star1'></label>
                                                </div>
                                
                                                    <div class='save px-auto mx-auto'>
                                                    <input type='hidden' name='complaintID' value='".$row["complaintID"]."'>
                                                    <button type='submit' name='save' id='submit-review-btn' value='save'>Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                </td>";
                            }
                            else {
                                echo "<td><a class='nav-link px-0' href='#'>";
                                for ($x = 0; $x < $row["complaint_rate"]; $x++) {
                                    echo "<span class='fa fa-star checked'>";
                                }
                                echo "</a></td>";
                            }
                        echo "<td><a class='nav-link disabled px-0' href='#' tabindex='-1' aria-disabled='true'>Successful</a>";

                        }elseif($row["complaint_status"]=='In progress'){
                            echo "<td><label class='badge badge-warning'>In progress</label></td>";
                            echo "<td>". $row["complaint_date"]."</td>";
                            echo "<td><a class='nav-link disabled px-0' href='#' tabindex='-1' aria-disabled='true'>Not
                            Applicable</a></td>";
                            echo "<td><a class='nav-link disabled px-0' href='#' tabindex='-1' aria-disabled='true'>Not Applicable</a>";
                            
                        }
                        else {
                            echo "<td><label class='badge badge-danger'>Pending</label></td>";
                            echo "<td>". $row["complaint_date"]."</td>";
                            echo "<td><a class='nav-link disabled px-0' href='#' tabindex='-1' aria-disabled='true'>Not
                            Applicable</a></td>";
                            echo "<td><a class='nav-link px-0' href='editForm.php?edit=".$row['complaintID']."'>Edit</a></td>";
                            
                        }
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td> </td><td> </td><td> </td><td> 0 results</td><td> </td><td> </td></tr>";
                }
                
            }elseif(($output == null ||$ct==0)){
                $sql = "SELECT * FROM complaint_t WHERE studentID=$studentID";
                $result = mysqli_query($mysqli, $sql);
                $cnt = 1;
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                        <td>".$cnt++."</td>
                        <td>". $row["complaint_type"]."</td>";
                        if($row["complaint_status"]=='Completed'){
                            echo "<td><label class='badge badge-success'>Completed</label></td>";
                            echo "<td>". $row["complaint_date"]."</td>";
                            if($row["complaint_rate"] == 0) {
                                echo "<td><a class='nav-link px-0' data-toggle='modal' data-target='#exampleModal' href='#'>Click here to rate</a></td>
                                <div class='modal fade' id='exampleModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                    <div class='modal-dialog modal-dialog-centered modal-sm'>
                                        <div class='modal-content'>
                                            <div class='modal-header py-0'>
                                                <h5 class='modal-title my-auto' id='exampleModalLabel'>Rate Your Satisfaction</h5>
                                                <button type='button' class='testx' data-dismiss='modal' aria-label='Close'>
                                                    <span aria-hidden='true'>&times;</span>
                                                </button>
                                            </div>
                                
                                            <div class='modal-body mx-auto text-center'>
                                                <form id='review-form' action='processEdit.php' method='post'>
                                
                                                <div class='fieldset w3hubs mt-1'>
                                                    <input type='radio' name='rate' value='5' id='star5'><label for='star5'></label>
                                                    <input type='radio' name='rate' value='4' id='star4'><label for='star4'></label>
                                                    <input type='radio' name='rate' value='3' id='star3'><label for='star3'></label>
                                                    <input type='radio' name='rate' value='2' id='star2'><label for='star2'></label>
                                                    <input type='radio' name='rate' value='1' id='star1' required=''><label for='star1'></label>
                                                </div>
                                
                                                    <div class='save px-auto mx-auto'>
                                                    <input type='hidden' name='complaintID' value='".$row["complaintID"]."'>
                                                    <button type='submit' name='save' id='submit-review-btn' value='save'>Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                </td>";
                            }
                            else {
                                echo "<td><a class='nav-link px-0' href='#'>";
                                for ($x = 0; $x < $row["complaint_rate"]; $x++) {
                                    echo "<span class='fa fa-star checked'>";
                                }
                                echo "</a></td>";
                            }
                        echo "<td><a class='nav-link disabled px-0' href='#' tabindex='-1' aria-disabled='true'>Successful</a>";

                        }elseif($row["complaint_status"]=='In progress'){
                            echo "<td><label class='badge badge-warning'>In progress</label></td>";
                            echo "<td>". $row["complaint_date"]."</td>";
                            echo "<td><a class='nav-link disabled px-0' href='#' tabindex='-1' aria-disabled='true'>Not
                            Applicable</a></td>";
                            echo "<td><a class='nav-link disabled px-0' href='#' tabindex='-1' aria-disabled='true'>Not Applicable</a>";
                            
                        }
                        else {
                            echo "<td><label class='badge badge-danger'>Pending</label></td>";
                            echo "<td>". $row["complaint_date"]."</td>";
                            echo "<td><a class='nav-link disabled px-0' href='#' tabindex='-1' aria-disabled='true'>Not
                            Applicable</a></td>";
                            echo "<td><a class='nav-link px-0' href='editForm.php?edit=".$row['complaintID']."'>Edit</a></td>";
                            
                        }
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td> </td><td> </td><td> </td><td> 0 results</td><td> </td><td> </td></tr>";
                }
            }
            ?>
            </tbody>
        </table>

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

    <script type="text/javascript" src="js/helpdesk.js"></script>

    <?php
        mysqli_close($mysqli);
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
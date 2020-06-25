<?php
// Start the session
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (
        (isset($_POST["username"]) &&
            isset($_POST["password"])) ||
        isset($_POST["remember_me"])
    ) {

        // Include the database connection file: include_once("config.php");
        include_once("config.php");

        // Define new variables to store username and password sent from the login.php page using the POST method.
        $username = $_POST['username'];
        $password = $_POST['password'];
        $rememberMe = false;

        if (!empty($_POST["remember_me"])) {
            $rememberMe = true;
        }

        // Validate whether the login is valid or not. Connect to the database and write mySQLi and SELECT SQL statement 
        // to check whether the username and password entered by the user is correct.
        $_SESSION['invalid_username'] = false;

        // Validate username
        if (empty($username)) {
            $_SESSION['invalid_username'] = true;
        }
        // Check if username has whitespaces
        else if (preg_match('/\s/', $username)) {
            $_SESSION['invalid_username'] = true;
        }

        // Method 1: Using MySQLi (Procedural)
        $check = mysqli_query($mysqli, "SELECT * FROM student_T WHERE username='$username'");
        while ($res = mysqli_fetch_assoc($check)) {
            $pass_hash = $res['password'];
        }

        if (!$_SESSION['invalid_username'] && password_verify($password, $pass_hash)) {
            $result = mysqli_query($mysqli, "SELECT * FROM student_T WHERE username='$username' and password='$pass_hash'");

            // If valid login: register $_SESSION variables that can be used to set values for the logged in user
            if (mysqli_num_rows($result) > 0) {

                while ($res = mysqli_fetch_assoc($result)) {
                    $username = $res['username'];
                    $password = $res['password'];
                    $studentID = $res['studentID'];
                }

                mysqli_close($mysqli);

                $_SESSION['logged_in'] = true;
                $_SESSION['studentID'] = $studentID;
                $_SESSION['username'] = $username;

                // Taking now logged in time.
                $_SESSION['loggedin_time'] = time();

                // Ending a session in 30 minutes from the starting time (if user doesn't check 'Remember Me' box)
                if (!$rememberMe)
                    $_SESSION['expire'] = $_SESSION['loggedin_time'] + (5);
                // Ending a session in 24 hours from the starting time (if user checks 'Remember Me' box)
                else
                    $_SESSION['expire'] = $_SESSION['loggedin_time'] + (24 * 60 * 60);

                header("Location: home.php?action=login_success");
            }
            // If invalid login: redirect the page to login.php page and pass the ‘action’ value to login.php
            else {
                header("Location: home.php?action=login_failed");
            }
        }
        // If invalid login: redirect the page to login.php page and pass the ‘action’ value to login.php
        else {
            header("Location: home.php?action=login_failed");
        }
    }
}

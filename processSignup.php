<?php
// Start the session
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST["username"]) &&
        isset($_POST["password"]) &&
        isset($_POST["cpassword"]) &&
        isset($_POST["email"]) &&
        isset($_POST["matric_number"]) &&
        isset($_POST["sec_question"]) &&
        isset($_POST["sec_answer"])
    ) {

        // Include the database connection file: include_once("config.php");
        include_once("config.php");

        $username = $_POST["username"];
        $password = $_POST["password"];
        $cpassword = $_POST["cpassword"];
        $email = $_POST["email"];
        $matric_number = $_POST["matric_number"];
        $sec_question = $_POST["sec_question"];
        $sec_answer = $_POST["sec_answer"];

        // Add validation codes to validate all the variables sent from the Registration form 
        // Sessions to check if username/email/student ID is taken (for user info)
        $_SESSION['username_taken'] = false;
        $_SESSION['email_taken'] = false;
        $_SESSION['studentID_taken'] = false;

        // Sessions to check if email/password/username/student ID is invalid
        $_SESSION['invalid_email'] = false;
        $_SESSION['invalid_pass'] = false;
        $_SESSION['invalid_username'] = false;
        $_SESSION['invalid_studentID'] = false;

        // Validate username
        if (empty($username)) {
            $_SESSION['invalid_username'] = true;
        }
        // Check if username has whitespaces
        else if (preg_match('/\s/', $username)) {
            $_SESSION['invalid_username'] = true;
        }

        // Validate email input
        if (empty($email)) {
            $_SESSION['invalid_email'] = true;
        } else {
            $temp = test_input($_POST['email']);

            # Check if email address is valid (got '@')
            if (filter_var($temp, FILTER_VALIDATE_EMAIL)) {
                $um_domain = "siswa.um.edu.my";

                // Separate string by @ characters (there should be only one)
                $parts = explode('@', $email);

                // Remove and return the last part, which should be the domain
                $domain = array_pop($parts);

                // Check if UM domain matches with email domain
                if ($domain != $um_domain) {
                    $_SESSION['invalid_email'] = true;
                }
            } else {
                $_SESSION['invalid_email'] = true;
            }
        }

        // Validate password
        if (empty($password) || empty($cpassword)){
            $_SESSION['invalid_pass'] = true;
        }
        else if (!checkPassword($password, $cpassword)) {
            $_SESSION['invalid_pass'] = true;
        }

        // Validate student ID
        if (empty($matric_number)) {
            $_SESSION['invalid_studentID'] = true;
        }
        // Check for the format of the student ID
        else if (!is_int($matric_number) && !(floor(log10($matric_number) + 1) == 8)) {
            $_SESSION['invalid_studentID'] = true;
        }

        // If all key details are valid
        if (!$_SESSION['invalid_email'] && !$_SESSION['invalid_pass'] && !$_SESSION['invalid_studentID'] && !$_SESSION['invalid_username']) {

            // PHP codes with MySQLi statements to add new user record into “cars_kk8” database.
            $username = mysqli_real_escape_string($mysqli, $_POST["username"]);
            $password = mysqli_real_escape_string($mysqli, $_POST["password"]);
            $email = mysqli_real_escape_string($mysqli, $_POST["email"]);
            $matric_number = mysqli_real_escape_string($mysqli, $_POST["matric_number"]);
            $sec_question = mysqli_real_escape_string($mysqli, $_POST["sec_question"]);
            $sec_answer = mysqli_real_escape_string($mysqli, $_POST["sec_answer"]);

            // Method 1: Using MySQLi Procedural
            $check_username =  mysqli_query($mysqli, "SELECT username FROM student_T WHERE username = '$username'");
            $check_email = mysqli_query($mysqli, "SELECT email FROM student_T WHERE email = '$email'");
            $check_studentID = mysqli_query($mysqli, "SELECT studentID FROM student_T WHERE studentID = '$matric_number'");

            // If it is a new member -> registration successful
            if (mysqli_num_rows($check_email) == 0 && mysqli_num_rows($check_username) == 0 && mysqli_num_rows($check_studentID) == 0) {

                // Method 1: Using MySQLi
                // Hash the user's password
                $pass_hash = password_hash($password, PASSWORD_DEFAULT);

                // Insert data into student_T table
                $file = "profile_pic_placeholder.png";
                $query2 = "INSERT INTO student_T(studentID, username, password, email, profile_pic_path, question, answer)
                    VALUES('$matric_number','$username','$pass_hash','$email','$file','$sec_question', '$sec_answer')";

                $result2 = mysqli_query($mysqli, $query2);

                // Debuggging
                // if ($result2 && $result3) {
                //     echo "New record created successfully";
                // } else {
                //     echo "Error:";
                //     echo mysqli_error($mysqli);
                // }

                mysqli_close($mysqli);

                // Set log in session (after register = auto log in)
                $_SESSION['logged_in'] = true;
                $_SESSION['studentID'] = $matric_number;
                $_SESSION['username'] = $username;

                // Taking now logged in time and default expired time
                $_SESSION['loggedin_time'] = time();
                $_SESSION['expire'] = $_SESSION['loggedin_time'] + (30 * 60);

                header("Location: confirmReg.php?action=reg_success");
            }
            // Email/username/student ID already exists
            else {

                // Set corresponding validation sessions to be true 
                // if email/username/student ID is taken
                if (mysqli_num_rows($check_email) > 0)
                    $_SESSION['email_taken'] = true;
                if (mysqli_num_rows($check_username) > 0)
                    $_SESSION['username_taken'] = true;
                if (mysqli_num_rows($check_studentID) > 0)
                    $_SESSION['studentID_taken'] = true;

                header("Location: home.php?action=reg_failed");
            }
        } else {

            // Check if username/email/student ID exists in database
            $check_username =  mysqli_query($mysqli, "SELECT username FROM student_T WHERE username = '$username'");
            $check_email = mysqli_query($mysqli, "SELECT email FROM student_T WHERE email = '$email'");
            $check_studentID = mysqli_query($mysqli, "SELECT studentID FROM student_T WHERE studentID = '$matric_number'");

            // Set corresponding validation sessions to be true 
            // if email/username/student ID is taken
            if (mysqli_num_rows($check_email) > 0)
                $_SESSION['email_taken'] = true;
            if (mysqli_num_rows($check_username) > 0)
                $_SESSION['username_taken'] = true;
            if (mysqli_num_rows($check_studentID) > 0)
                $_SESSION['studentID_taken'] = true;

            header("Location: home.php?action=reg_failed");
        }
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function checkPassword($pass1, $pass2)
{
    if ($pass1 == $pass2)
        return true;
    else
        return false;
}

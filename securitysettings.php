<?php
    session_start();
    include_once("config.php");
?>

<!-- Password verification -->
<?php
    if( isset($_POST["verifyPass"]) && isset($_SESSION['studentID']) && isset($_SESSION['logged_in']) ){
        $studentID = $_SESSION['studentID'];
        $inputpass = $_POST['inputpass'];

        $check = mysqli_query($mysqli, "SELECT password FROM student_t WHERE studentID=$studentID ");
        $res = mysqli_fetch_assoc($check);
        $checkpass = $res['password'];

        if(password_verify($inputpass,$checkpass)){
            header("Location:usersettings.php?action=password_match");
        }

        else{
            header("Location:usersettings.php?action=invalid_pass");
        }
        mysqli_close($mysqli);
    }
?>

<!-- Password change normal -->
<?php
    if(isset($_POST["updateChange"])){
        $studentID = $_SESSION['studentID'];
        $confirmPass = $_POST['confirmPass'];

        $check = mysqli_query($mysqli, "SELECT password FROM student_t WHERE studentID=$studentID ");
        $res = mysqli_fetch_assoc($check);
        $checkpass = $res['password'];

        if(password_verify($confirmPass,$checkpass)){
            header("Location:usersettings.php?action=password_error");
        }
        else{
            $pass_hash = password_hash($confirmPass, PASSWORD_DEFAULT);
            $result = mysqli_query($mysqli, "UPDATE student_t SET password='$pass_hash' WHERE studentID=$studentID");
            header("Location: usersettings.php?action=update_success");
        }
       
        mysqli_close();
    }
?>

<!-- Password change for forgotten password -->
<?php
    if(isset($_POST["updateChangeForgot"])){
        $studentID = $_SESSION['studentID'];
        $confirmPass = $_POST['confirmPass'];

        $check = mysqli_query($mysqli, "SELECT password FROM student_t WHERE studentID=$studentID ");
        $res = mysqli_fetch_assoc($check);
        $checkpass = $res['password'];

        if(password_verify($confirmPass,$checkpass)){
            header("Location:resetpassword.php?action=forgot_password_error");
        }
        else{
            $pass_hash = password_hash($confirmPass, PASSWORD_DEFAULT);
            $result = mysqli_query($mysqli, "UPDATE student_t SET password='$pass_hash' WHERE studentID=$studentID");
            header("Location: usersettings.php?action=update_success");
        }
       
        mysqli_close();
    }
?>

<!-- Password verification for security question -->
<?php
    if( isset($_POST["verifyPassSec"]) && isset($_SESSION['studentID']) && isset($_SESSION['logged_in']) ){
        $studentID = $_SESSION['studentID'];
        $inputpass = $_POST['inputpass'];

        $check = mysqli_query($mysqli, "SELECT password FROM student_t WHERE studentID=$studentID ");
        $res = mysqli_fetch_assoc($check);
        $checkpass = $res['password'];

        if(password_verify($inputpass,$checkpass)){
            header("Location:usersettings.php?action=password_match_security");
        }

        else{
            header("Location:usersettings.php?action=invalid_pass_security");
        }
        mysqli_close($mysqli);
    }
?>

<!-- Update security question -->
<?php
    if( isset($_POST["updateSecurity"]) && isset($_SESSION['studentID']) ){
        $studentID = $_SESSION['studentID'];
        $question = mysqli_real_escape_string($mysqli, $_POST['user_question']);
        $answer = mysqli_real_escape_string($mysqli, $_POST['user_answer']);
        $result = mysqli_query($mysqli, "UPDATE student_t SET question='$question', answer='$answer' WHERE studentID=$studentID");
        header("Location: usersettings.php?action=securityq_update_successfully");
        mysqli_close($mysqli);
    }
?>

<!-- Email verification -->
<?php
    if( isset($_POST["verifyEmail"])){
        
        $inputemail = $_POST['email'];
        

        //If user is logged in, need to verify email against email in DB
        if( isset ($_SESSION['logged_in']) ){
            $studentID = $_SESSION['studentID'];
            $check = mysqli_query($mysqli, "SELECT email FROM student_t WHERE studentID=$studentID");
            $result = mysqli_fetch_assoc($check);
            $checkemail = $result['email'];
            if($inputemail==$checkemail){
                header("Location: securityq.php");
            }
            else{
                header("Location: resetreq.php?action=incorrect_email");
            }
        }

        //user not logged in, verifies whether email exists in DB
        else{
            $check = mysqli_query($mysqli,"SELECT * FROM student_t WHERE email='$inputemail'");
            while($res = mysqli_fetch_assoc($check)){
            $email = $res['email'];
         }
            if($inputemail == $email){
                $result = mysqli_query($mysqli, "SELECT * FROM student_T WHERE email='$inputemail'");
                if(mysqli_num_rows($result) > 0){
                    $res = mysqli_fetch_assoc($result);
                    $studentID = $res['studentID'];
                    $_SESSION['studentID']=$studentID;
                    header("Location: securityq.php");
                }
            }
            
            else{
                header("Location: resetreq.php?action=incorrect_email");
            }
        }
        mysqli_close();
    }

?>
<!-- Security question verification -->
<?php
    if( isset($_POST["verifySecurity"])  && isset($_SESSION['studentID'])){
        $studentID = $_SESSION['studentID'];
        $inputans = $_POST['answer'];
        $check = mysqli_query($mysqli,"SELECT answer FROM student_t WHERE studentID='$studentID'");
        $res = mysqli_fetch_assoc($check);
        $checkans = $res['answer'];
        

        if($inputans == $checkans){
           header("Location: resetconfirm.php");
        }
        
        else{
            header("Location:securityq.php?action=invalid_answer");
        }
        mysqli_close();
    }

?>

<!-- Verification code [4599] -->
<?php
    if(isset($_POST["verifyCode"]) ){
        $studentID = $_SESSION['studentID'];
        $code1 = $_POST['code1'];
        $code2 = $_POST['code2'];
        $code3 = $_POST['code3'];
        $code4 = $_POST['code4'];
        
        $activecode='4599';
        $code = $code1.$code2.$code3.$code4;
        if($code===$activecode){
            header("Location:resetpassword.php");
        }
        else{
            header("Location:resetconfirm.php?action=invalid_code");
        }
        mysqli_close();
    }

?>







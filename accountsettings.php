<?php
    session_start();
    include_once("config.php");
?>

<!-- Update Public Details -->
<?php
    if( isset($_POST["updatePublic"]) && isset($_SESSION['studentID']) && isset($_SESSION['logged_in']) ){
        
        $studentID = $_SESSION['studentID'];
        $username = mysqli_real_escape_string($mysqli, $_POST['username']);
        $faculty = mysqli_real_escape_string($mysqli, $_POST['faculty']);
        $biography = mysqli_real_escape_string($mysqli, $_POST['biography']);
        // profile pic variables
        $file = $_FILES['file'];
        $fileName = $_FILES['file']['name']; //getting name
        $fileTmpName = $_FILES['file']['tmp_name']; //temporary distination of file
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];
        $fileType = $_FILES['file']['type'];

        $fileExt = explode('.', $fileName); //seperating the name and extention 
        $fileActualExt = strtolower(end($fileExt)); //if the extention like .JPG or .PNG
        $allowed = array('jpg','jpeg', 'png');
        //checks if any files are uploaded
        if($fileName!=""){
            if(in_array($fileActualExt,$allowed)){
                if($fileError===0){
                    if($fileSize<5000000){
                        if(!file_exists('imgs/profilepicture')){
                            mkdir('imgs/profilepicture',0777,true);
                        }
                        
                        $fileDestination = 'imgs/profilepicture/'.$fileExt[0].".".$fileActualExt;
                        move_uploaded_file($fileTmpName,$fileDestination);
                        $_SESSION['username'] = $username;
                        $result = mysqli_query($mysqli, "UPDATE student_t SET username='$username', faculty='$faculty', biography='$biography', profile_pic_path='".$fileName."' WHERE studentID=$studentID");
                        header("Location: usersettings.php?action=public_update_successful");
                    }
                    else{
                        header("Location: usersettings.php?action=file_size_error");
                    }
                }
                else{
                    header("Location: usersettings.php?action=file_upload_error");
                }
            }
            else{
                header("Location: usersettings.php?action=file_type_error");
            }
        }
        else{
            $check_username =  mysqli_query($mysqli, "SELECT username FROM student_T WHERE username = '$username'");
            $change =  mysqli_query($mysqli, "SELECT username FROM student_T WHERE studentID='$studentID'");
            $result =  mysqli_fetch_assoc($change);
            $change_username = $result['username'];
            
            //checks whether changes were made to the username
            if($username != $change_username){
                //checks whether username already exists in the DB
                if(mysqli_num_rows($check_username) == 0){
                    $_SESSION['username'] = $username;
                    $result = mysqli_query($mysqli, "UPDATE student_t SET username='$username', faculty='$faculty', biography='$biography' WHERE studentID=$studentID");
                    header("Location: usersettings.php?action=public_update_successful");
                }
                else if(mysqli_num_rows($check_username) > 0){
                    header("Location: usersettings.php?action=username_taken");
                }
            }
           else{
                $result = mysqli_query($mysqli, "UPDATE student_t SET username='$username', faculty='$faculty', biography='$biography' WHERE studentID=$studentID");
                $_SESSION['username'] = $username;
                header("Location: usersettings.php?action=public_update_successful");
                
           }
            
        }
        
        mysqli_close($mysqli);
    }
?>

<!-- Bio limitter -->
<?php

    $bio = $_REQUEST["bio"];
    if(strlen($bio)<220){
        echo strlen($bio);
    }
    else if(strlen($bio)>219 && strlen($bio)<240){
        echo "<font color=\"orange\">".strlen($bio)."</font>";
    }

    else if(strlen($bio)==240){
        echo "<font color=\"red\">Biography cannot exceed 240 characters.</font>";
    }
         
?>

<!-- Update Personal Details -->
<?php
    if(isset($_POST["updatePersonal"]) && isset($_SESSION['studentID']) && isset($_SESSION['logged_in']) ){
        $studentID = $_SESSION['studentID'];
        $first_name = mysqli_real_escape_string($mysqli, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($mysqli, $_POST['last_name']);
        $phone_no = mysqli_real_escape_string($mysqli, $_POST['phone_no']);
        $address1 = mysqli_real_escape_string($mysqli, $_POST['address1']);
        $address2 = mysqli_real_escape_string($mysqli, $_POST['address2']);
        $city = mysqli_real_escape_string($mysqli, $_POST['city']);
        $state = mysqli_real_escape_string($mysqli, $_POST['state']);
        $zip = mysqli_real_escape_string($mysqli, $_POST['zip']);
        $twitter_acc = mysqli_real_escape_string($mysqli, $_POST['twitter_acc']);
        $facebook_acc = mysqli_real_escape_string($mysqli, $_POST['facebook_acc']);
    
        $result = mysqli_query($mysqli, "UPDATE student_t SET first_name='$first_name', last_name='$last_name', phone_no='$phone_no', twitter_acc='$twitter_acc', facebook_acc='$facebook_acc' WHERE studentID=$studentID");
        $address = $address1."; ".$address2;
        $result2= mysqli_query($mysqli,"UPDATE address_t SET address='$address', city='$city', state='$state', zip='$zip' WHERE studentID=$studentID ");
        header("Location: usersettings.php?action=personal_update_successful");
        mysqli_close($mysqli);
        
    }
?>

<!-- Edit experience -->
<?php
    if(isset($_POST["update"]) && isset($_SESSION['studentID']) && isset($_SESSION['logged_in']) ){
        if( isset($_POST["project"])  && isset($_POST["position"]) && isset($_POST["startDate"]) && isset($_POST["endDate"]) && isset($_POST["details"])){
            $studentID = $_SESSION['studentID'];            
            $experienceID = mysqli_real_escape_string($mysqli, $_POST['experienceID']);
            $project = mysqli_real_escape_string($mysqli, $_POST['project']);
            $position = mysqli_real_escape_string($mysqli, $_POST['position']);
            $startDate = mysqli_real_escape_string($mysqli, $_POST['startDate']);
            $endDate = mysqli_real_escape_string($mysqli, $_POST['endDate']);
            $details = mysqli_real_escape_string($mysqli, $_POST['details']);
            
            if(($startDate != "") && ($endDate!="")){
                $result = mysqli_query($mysqli, "UPDATE student_exp_t SET project='$project', position='$position', startDate='$startDate', endDate='$endDate', details='$details' WHERE experienceID=$experienceID");
                header("Location: usersettings.php?action=edit_success&experienceID=$experienceID");
            }
            else if(($startDate != "") && ($endDate=="")){
                $result = mysqli_query($mysqli, "UPDATE student_exp_t SET project='$project', position='$position', startDate='$startDate', details='$details' WHERE experienceID=$experienceID");
                header("Location: usersettings.php?action=edit_success&experienceID=$experienceID");
            }
            else if(($startDate == "") && ($endDate!="")){
                $result = mysqli_query($mysqli, "UPDATE student_exp_t SET project='$project', position='$position', endDate='$endDate', details='$details' WHERE experienceID=$experienceID");
                header("Location: usersettings.php?action=edit_success&experienceID=$experienceID");
            }
            else{
                $result = mysqli_query($mysqli, "UPDATE student_exp_t SET project='$project', position='$position', details='$details' WHERE experienceID=$experienceID");
                header("Location: usersettings.php?action=edit_success&experienceID=$experienceID");
            }
            
            mysqli_close($mysqli);
            
        }
    }
?>

<!-- Add experience -->
<?php    
    if(isset($_POST["add"]) && isset($_SESSION['studentID']) && isset($_SESSION['logged_in'])){
        $studentID = $_SESSION['studentID'];        
        $experienceID = mysqli_real_escape_string($mysqli, $_POST['experienceID']);
        $project = mysqli_real_escape_string($mysqli, $_POST['project']);
        $position = mysqli_real_escape_string($mysqli, $_POST['position']);
        $startDate = mysqli_real_escape_string($mysqli, $_POST['startDate']);
        $endDate = mysqli_real_escape_string($mysqli, $_POST['endDate']);
        $details = mysqli_real_escape_string($mysqli, $_POST['details']);
        
        if(empty($project) || empty($position) || empty($startDate)) {
            
            if(empty($project)) {
                echo "<font color='red'>Please enter project name.</font><br/>";
            }
            
            if(empty($position)) {
                echo "<font color='red'>Please state your position in the project.</font><br/>";
            }
            
            if(empty($email)) {
                echo "<font color='red'>Please specify the start date of the project.</font><br/>";
            }
            
        }

        else{

            $result = mysqli_query($mysqli, "INSERT INTO student_exp_t (studentID,project,position,startDate,endDate,details) VALUES('$studentID','$project','$position','$startDate','$endDate','$details')");
            header("Location: usersettings.php?action=add_successful");
            mysqli_close($mysqli);
        }
        
    }
?>

<!-- Delete experience -->
<?php
    if(isset($_POST["delete"]) && isset($_SESSION['studentID']) && isset($_SESSION['logged_in'])){
        $studentID = $_SESSION['studentID'];        
        $experienceID = mysqli_real_escape_string($mysqli, $_POST['experienceID']);
        
        $result = mysqli_query($mysqli, "DELETE FROM student_exp_t WHERE experienceID=$experienceID");
        header("Location: usersettings.php?action=experience_deleted");
        mysqli_close($mysqli);
    }
?>

<!-- Delete account -->
<?php
    if(isset($_POST["deleteAcc"]) && isset($_SESSION['studentID']) && isset($_SESSION['logged_in'])){
        $studentID = $_SESSION['studentID'];
        $inputpass = $_POST['password'];

        $check = mysqli_query($mysqli, "SELECT password FROM student_t WHERE studentID=$studentID ");
        $res = mysqli_fetch_assoc($check);
        $checkpass = $res['password'];

        if(password_verify($inputpass,$checkpass)){
            $result = mysqli_query($mysqli, "DELETE FROM address_t WHERE studentID=$studentID");
            $result2 = mysqli_query($mysqli, "DELETE FROM complaint_t WHERE studentID=$studentID");
            $result3 = mysqli_query($mysqli, "DELETE FROM registration_t WHERE studentID=$studentID");
            $result5 = mysqli_query($mysqli, "DELETE FROM security_questions_t WHERE studentID=$studentID");
            $result6 = mysqli_query($mysqli, "DELETE FROM student_exp_t WHERE studentID=$studentID");
            $result7 = mysqli_query($mysqli, "DELETE FROM student_t WHERE studentID=$studentID");
            header("Location: deleteacc.php?action=deleted_acc");
        }
        else{
            header("Location:usersettings.php?action=invalid_deac");
        }
        mysqli_close();
    }
?>



<?php 
    session_start();

    $studentID = $_SESSION['studentID'];

    if ( isset($_POST["phoneNo"]) && isset($_POST["location"]) ) {

        include_once("config.php");

        $type = $_POST["type"];
        $category = $_POST["category"];
        $details = $_POST["details"];
        $phoneNo = $_POST["phoneNo"];
        $location = $_POST["location"];
        
        $file = $_FILES['file'];

        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name']; //temporary distination of file
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];
        $fileType = $_FILES['file']['type'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg','jpeg', 'png','pdf');

        if(in_array($fileActualExt,$allowed)){
            if($fileError===0){
                if($fileSize<5000000){
                    if(!file_exists('uploads/form')){
                        mkdir('uploads/form',0777,true);
                    }
                    $fileDestination = 'uploads/form/'.$fileExt[0].".".$fileActualExt;
                    move_uploaded_file($fileTmpName,$fileDestination);
                    
                }else{
                    echo "<script type='text/javascript'>alert('Your file is too big!');history.go(-1);</script>";
                }
            }else{
                echo "<script type='text/javascript'>alert('There was an error uploading your file!');history.go(-1);</script>";
            }
        }else{
            echo "<script type='text/javascript'>alert('Cannot upload files of this type!');history.go(-1);</script>";
        }
    } else {
        echo "<script type='text/javascript'>alert('Please fill the required details!');history.go(-1);</script>";
    }

    $sql = "INSERT INTO complaint_t (studentID, complaint_type, complaint_category, complaint_details, complaint_phoneNo, complaint_location, complaint_file, complaint_status, complaint_rate) 
    VALUES ($studentID, '$type', '$category', '$details', '$phoneNo', '$location', '$fileName', 'Pending', 0)";

    if (mysqli_query($mysqli, $sql)) {
        header("Location:helpdesk.php#report");
    } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($mysqli);
    }
    
    mysqli_close($mysqli);

?>
<?php

include_once("config.php");

if(isset($_POST['submit'])) {
    $compid = $_POST["complaintID"];
    $type = $_POST["type"];
    $category = $_POST["category"];
    $details = $_POST["details"];
    $phoneNo = $_POST["phoneNo"];
    $location = $_POST["location"];
    
    $file = $_FILES['file'];

    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    if ($fileName == '') {
        $sql = "UPDATE complaint_t SET complaint_type='$type', complaint_category='$category', complaint_details='$details', complaint_phoneNo='$phoneNo',complaint_location='$location',complaint_date=now()   WHERE complaintID=$compid";
    } else {
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

                    $sql = "UPDATE complaint_t SET complaint_type='$type', complaint_file='$fileName', complaint_category='$category', complaint_details='$details', complaint_phoneNo='$phoneNo',complaint_location='$location', complaint_date=now()   WHERE complaintID=$compid";
    
    
                } else{
                    echo "<script type='text/javascript'>alert('Your file is too big!');history.go(-1);</script>";
                }
            } else{
                echo "<script type='text/javascript'>alert('There was an error uploading your file!');history.go(-1);</script>";
            }
        } else{
            echo "<script type='text/javascript'>alert('Cannot upload files of this type!');history.go(-1);</script>";
        }

    }

    if (mysqli_query($mysqli, $sql)) {
    header("Location:helpdesk.php#report");
    } else {
    echo "Error updating record: " . mysqli_error($mysqli);
    }

} else if(isset($_POST['delete'])) {
    $compid = $_POST["complaintID"];

    $sql = "DELETE FROM complaint_T WHERE complaintID=$compid";
    if (mysqli_query($mysqli, $sql)) {
        header("Location:helpdesk.php#report");
    } else {
        echo "Error deleting record: " . mysqli_error($mysqli);
    }
} else if(isset($_POST['save'])) {

    $id = $_POST['complaintID'];
    $rate = $_POST['rate'];

    $sql = "UPDATE complaint_t SET complaint_rate=$rate   WHERE complaintID=$id";

    if (mysqli_query($mysqli, $sql)) {
        header("Location:helpdesk.php#report");
    } else {
        echo "Error updating record: " . mysqli_error($mysqli);
    }

}

mysqli_close($mysqli);
?>
<?php
include "config.php";

$category = $_POST['cat'];

$sql = "SELECT id,name FROM type_T WHERE category='$category'";

$result = mysqli_query($mysqli,$sql);

$users_arr = array();

while( $row = mysqli_fetch_array($result) ){
    $typeid = $row['id'];
    $type = $row['name'];

    $users_arr[] = array("id" => $typeid, "name" => $type);
}

// encoding array to json format
echo json_encode($users_arr);
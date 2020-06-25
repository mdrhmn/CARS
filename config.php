<?php

// METHOD 1: MYSQLI (PROCEDURAL)
$databaseHost = 'localhost';
$databaseName = 'cars_kk8';
$databaseUsername = 'admin';
$databasePassword = 'test123#';

$mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName); 
// echo "Database connected successfully.<br>"; 

if (mysqli_connect_errno() ) {
	die( "Database connection failed: " . mysqli_connect_error() );
} 

?>



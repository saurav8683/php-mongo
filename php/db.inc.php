<?php 
$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
$dbname = "Faculty.user_register";

$dbServer = "127.0.0.1";
$dbUsername = "root";
$dbPassword = "";

$dbName1 = "faculty_portal";
$conn = mysqli_connect($dbServer, $dbUsername, $dbPassword, $dbName1);
?>
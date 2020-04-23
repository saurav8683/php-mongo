<?php

    include 'php/db.per.php';
    include 'php/db.inc.php';

    $leave_id = $_GET["leave_id"];
    $signed_by = $_GET["direcID"];
    $state = $_GET["heirarchy"];
    $loc = $_GET["URL"];

//    echo $loc;

    $sql = "UPDATE leave_portal SET leave_status = '3' WHERE id = '$leave_id';";
    mysqli_query($conn, $sql); 

    
    header("Location: $loc");
?>
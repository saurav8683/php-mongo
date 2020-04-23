<?php

    include 'php/db.per.php';
    include 'php/db.inc.php';

    $leave_id = $_POST["leave_id"];
    $signed_by = $_POST["signing_id"];
    $loc = $_POST["URL"];
    $comment = $_POST["comment"];

    $sql = "UPDATE leave_portal SET leave_status = '1' WHERE id = '$leave_id';";
    mysqli_query($conn, $sql); 

    $date = date("Y/m/d");
    

    $sql_com = "INSERT INTO comment_portal (leave_id, comment, person_id, comment_date) VALUES ('$leave_id', '$comment', '$signed_by', '$date');";
    
    mysqli_query($conn, $sql_com);

    header("Location: $loc");


?>
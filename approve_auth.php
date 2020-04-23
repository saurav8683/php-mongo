<?php

    include 'php/db.per.php';
    include 'php/db.inc.php';

    $leave_id = $_GET["leave_id"];
    $signed_by = $_GET["direcID"];

    $date = date("Y/m/d");
    $time = date("h:i:sa");

    $sqli1 = "SELECT * FROM leave_portal WHERE id = '$leave_id'";

    $result = mysqli_fetch_assoc(mysqli_query($conn, $sqli1));
    
    $person_id = $result['person_id'];
    $start = $result['start_D'];
    $end = $result['end_D'];

    $sql= "INSERT into log_table (person_id, start_D, end_D, signed_by, signed_date) values ('$person_id', '$start', '$end', '$signed_by', '$date');";
    
    mysqli_query($conn, $sql);

    $sql2 = "UPDATE leave_portal SET leave_status = '2' WHERE id = '$leave_id';";

    mysqli_query($conn, $sql2);

    header("Location: leave_to_check_director.php");

?>
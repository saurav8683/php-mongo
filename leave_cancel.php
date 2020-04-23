<?php 
    include 'php/db.per.php';
    
    $var = $_GET['id'];
    echo $_GET['id'];
    
    $sql = "DELETE FROM leave_portal WHERE leave_portal.id = '$var'";

    mysqli_query($conn, $sql);

    header("Location: leave_status.php");
?>

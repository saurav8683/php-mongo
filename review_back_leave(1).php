<?php

    include 'php/db.per.php';
    include 'php/db.inc.php';

    $leave_id = $_POST["leave_id"];
    $start_D = $_POST["start_D"];
    $end_D = $_POST["end_D"];
    $loc = $_POST["URL"];
    $reason = $_POST["reason"];

    $endDate = strtotime($end_D);
    $startDate = strtotime($start_D);

    $days = ($endDate - $startDate) / 86400 + 1;

    $no_full_weeks = floor($days / 7);
    $no_remaining_days = fmod($days, 7);

    $the_first_day_of_week = date("N", $startDate);
    $the_last_day_of_week = date("N", $endDate);

    if ($the_first_day_of_week <= $the_last_day_of_week) {
        if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
        if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
    }
    else {
     
        if ($the_first_day_of_week == 7) {
            
            $no_remaining_days--;

            if ($the_last_day_of_week == 6) {
                
                $no_remaining_days--;
            }
        }
        else {
            $no_remaining_days -= 2;
        }
    }

   $workingDays = $no_full_weeks * 5;
    if ($no_remaining_days > 0 )
    {
      $workingDays += $no_remaining_days;
    }

    $n_days = $workingDays;


    $sql = "UPDATE leave_portal SET leave_status = '0', start_D = '$start_D' , end_D = '$end_D', reason = '$reason', number_of_days = '$n_days' WHERE id = '$leave_id';";
    
    mysqli_query($conn, $sql); 


    $sql_com = "DELETE FROM comment_portal WHERE leave_id = '$leave_id';";
    
    mysqli_query($conn, $sql_com);

    header("Location: $loc");


?>
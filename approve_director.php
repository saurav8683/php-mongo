<?php

include 'php/db.per.php';
include 'php/db.inc.php';

$leave_id = $_GET["leave_id"];
$signed_by = $_GET["direcID"];
$state = $_GET["heirarchy"];

    $sql_max = "SELECT MAX(heirarchy_no) as max FROM state_table ;";

    $max_result = mysqli_fetch_assoc(mysqli_query($conn, $sql_max));


    //echo $max_result['max'];
    if($max_result['max'] === $state){
        
        $date = date("Y/m/d");
        $time = date("h:i:sa");

        $sqli1 = "SELECT * FROM leave_portal WHERE id = '$leave_id';";

        $result = mysqli_fetch_assoc(mysqli_query($conn, $sqli1));
    
        $person_id = $result['person_id'];
        $start = $result['start_D'];
        $end = $result['end_D'];



        $sql= "INSERT into log_table (person_id, start_D, end_D, signed_by, signed_date, leave_status) values ('$person_id', '$start', '$end', '$signed_by', '$date', '2');";
    
        mysqli_query($conn, $sql);

        $sql2 = "UPDATE leave_portal SET leave_status = '2' WHERE id = '$leave_id';";

        mysqli_query($conn, $sql2);


        ///////////////////////////////
    $endDate = strtotime($end);
    $startDate = strtotime($start);

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
    //////////////////////////////////

        //////////////////////////////////

        $sqli2 = "SELECT * FROM faculty WHERE id = '$person_id';";

        $result = mysqli_fetch_assoc(mysqli_query($conn, $sqli2));

        $n_avl_this = $result['leaves_available_this_year'];
        $n_avl_next = $result['leaves_available_next_year'];

        if($n_days <= $n_avl_this){
            
            $n_days = $n_avl_this - $n_days;
            $sql3 = "UPDATE faculty SET leaves_available_this_year = '$n_days' WHERE id = '$person_id';";

            mysqli_query($conn, $sql3);

        }
        else{

            $n_days = $n_avl_next - ($n_days - $n_avl_this);

            $sql3 = "UPDATE faculty SET leaves_available_this_year = '0', leaves_available_next_year = '$n_days' WHERE id = '$person_id';";

            mysqli_query($conn, $sql3);

        }

        header("Location: leave_to_check_director.php");
    }
    else{

        $date = date("Y/m/d");
        $time = date("h:i:sa");

        $sqli1 = "SELECT * FROM leave_portal WHERE id = '$leave_id';";

        $result = mysqli_fetch_assoc(mysqli_query($conn, $sqli1));
    
        $person_id = $result['person_id'];
        $start = $result['start_D'];
        $end = $result['end_D'];

        $sql= "INSERT into log_table (person_id, start_D, end_D, signed_by, signed_date, leave_status) values ('$person_id', '$start', '$end', '$signed_by', '$date', '0');";
    
        mysqli_query($conn, $sql);

        $sql_pos = "SELECT position from leave_portal WHERE id = '$leave_id'";

        $res_pos = mysqli_fetch_assoc(mysqli_query($conn, $sql_pos));

        $position = $res_pos['position'];
        
        $position = $position+1;

        $sql2 = "UPDATE leave_portal SET position = '$position' WHERE id = '$leave_id';";

        mysqli_query($conn, $sql2);

        header("Location: leave_to_check_dean.php");
    }

?>
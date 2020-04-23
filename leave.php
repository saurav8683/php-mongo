<?php 
    
    include 'php/db.per.php';

    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];
    $reason = $_POST["reason"];
    $borrow = $_POST["borrow"];

    $person_id = substr($_POST["id"], 22, 24);

    $sql_des = "SELECT * FROM faculty WHERE id = '$person_id';";

    $result_des = mysqli_fetch_assoc(mysqli_query($conn, $sql_des));

    $designation = $result_des['designation'];
    $department = $result_des['department'];
    $sql_des_check = "SELECT heirarchy_no FROM state_table WHERE designation = '$designation';";

    $result_hei = mysqli_fetch_assoc(mysqli_query($conn, $sql_des_check));


    $endDate = strtotime($end_date);
    $startDate = strtotime($start_date);

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


    $sqli2 = "SELECT * FROM faculty WHERE id = '$person_id';";

    $result1 = mysqli_fetch_assoc(mysqli_query($conn, $sqli2));

    $n_avl_this1 = $result1['leaves_available_this_year'];
    $n_avl_next1 = $result1['leaves_available_next_year'];

    

    if(empty($result_hei)){
        
        if($n_avl_this1 < $n_days){

            if($borrow == 1){
                if(!strcmp($department,"")){
                    $sql= "INSERT into leave_portal (person_id, start_D, end_D, number_of_days, reason, leave_status, position) values ('$person_id', '$start_date', '$end_date', '$n_days', '$reason', '0', '1');";
    
                    mysqli_query($conn, $sql);
                }
                else{
                    $sql= "INSERT into leave_portal (person_id, start_D, end_D, number_of_days, reason, leave_status, position) values ('$person_id', '$start_date', '$end_date', '$n_days', '$reason', '0', '0');";
    
                    mysqli_query($conn, $sql);
                }
                header("Location: index_user.php");
            }
            else{
                header("Location: index_user.php");
            }
        }
        else{
            if(!strcmp($department,"")){
                $sql= "INSERT into leave_portal (person_id, start_D, end_D, number_of_days, reason, leave_status, position) values ('$person_id', '$start_date', '$end_date', '$n_days', '$reason', '0', '1');";

                mysqli_query($conn, $sql);
            }
            else{
                $sql= "INSERT into leave_portal (person_id, start_D, end_D, number_of_days, reason, leave_status, position) values ('$person_id', '$start_date', '$end_date', '$n_days', '$reason', '0', '0');";

                mysqli_query($conn, $sql);
            }
            header("Location: index_user.php");
        }
    }
    else{

        $sql_max = "SELECT MAX(heirarchy_no) as max FROM state_table ;";

        $max_result = mysqli_fetch_assoc(mysqli_query($conn, $sql_max));

        if($max_result['max'] === $result_hei['heirarchy_no']){


            $date = date("Y/m/d");
            $time = date("h:i:sa");

            $sql= "INSERT into log_table (person_id, start_D, end_D, signed_by, signed_date, leave_status) values ('$person_id', '$start_date', '$end_date', '$signed_by', '$date', '2');";
    
            mysqli_query($conn, $sql);


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


        }
        else{

            if($n_avl_next1 <$n_days){

                if($borrow == 1){
                    $hei = $result_hei['heirarchy_no']+1;
                    $sql= "INSERT into leave_portal (person_id, start_D, end_D, number_of_days, reason, leave_status, position) values ('$person_id', '$start_date', '$end_date', '$n_days', '$reason', '0', '$hei');";

                    mysqli_query($conn, $sql);
                }  
            }
            else{
                $hei = $result_hei['heirarchy_no']+1;
                $sql= "INSERT into leave_portal (person_id, start_D, end_D, number_of_days, reason, leave_status, position) values ('$person_id', '$start_date', '$end_date', '$n_days', '$reason', '0', '$hei');";

                mysqli_query($conn, $sql);
            }
            
        }

        header("Location: index_dean.php");
    }


?>

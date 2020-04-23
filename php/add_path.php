<?php

    include 'db.inc.php';
    include 'db.per.php';

    $entrant = $_POST["entrant"];
    $start_pos = $_POST["start"];
    $end_pos = $_POST["end"];
    
    
    $sql = "SELECT * FROM state_table WHERE designation = '$start_pos';";
    $result = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    $h_start = $result['heirarchy_no'];


    $sql = "SELECT * FROM state_table WHERE designation = '$end_pos';";
    $result = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    $h_end = $result['heirarchy_no'];

    
    $sql = "SELECT MAX(heirarchy_no) as maxi FROM state_table;";
    $result = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    $h_max = $result['maxi'];

    $sql = "SELECT MIN(heirarchy_no) as mini FROM state_table;";
    $result = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    $h_min = $result['mini'];


    $sql2 = "SELECT * FROM state_table;";

    $result2 = mysqli_query($conn, $sql2);

    if($h_start === $h_max){

        $upd_h = $h_max+1;
        $sql3 = "INSERT INTO state_table (designation, heirarchy_no) VALUES ('$entrant', '$upd_h');";
        mysqli_query($conn, $sql3);

    }
    else if($h_end === $h_min){
        
        if(mysqli_num_rows($result2)>0){

            while($row = mysqli_fetch_assoc($result2)){
    
                    $upd_h = $row['heirarchy_no']+1;
    
                    $sql3 = "UPDATE state_table SET heirarchy_no = '$upd_h' WHERE heirarchy_no = '$row[heirarchy_no]';";
                    mysqli_query($conn, $sql3);
                
            }

        }

        $upd_h = $h_min;
        $sql3 = "INSERT INTO state_table (designation, heirarchy_no) VALUES ('$entrant', '$upd_h');";
        mysqli_query($conn, $sql3);
        
    }
    else{


        if(mysqli_num_rows($result2)>0){

            while($row = mysqli_fetch_assoc($result2)){
                    if($row[heirarchy_no] > $h_start){
                        $upd_h = $row['heirarchy_no']+1;
    
                        $sql3 = "UPDATE state_table SET heirarchy_no = '$upd_h' WHERE heirarchy_no = '$row[heirarchy_no]';";
                        mysqli_query($conn, $sql3);
                    }
            }

        }

        $upd_h = $h_start+1;
        $sql3 = "INSERT INTO state_table (designation, heirarchy_no) VALUES ('$entrant', '$upd_h');";
        mysqli_query($conn, $sql3);

    }
    header("Location: ../index_admin.php");
?>
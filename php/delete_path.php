<?php

    include 'db.inc.php';
    include 'db.per.php';
    
    $departer = $_POST["departer"];

    $sql = "SELECT * FROM state_table WHERE designation = '$departer';";

    $result = mysqli_fetch_assoc(mysqli_query($conn, $sql));

    $h_no = $result['heirarchy_no'];

    $sql2 = "SELECT * FROM state_table ORDER BY heirarchy_no;";

    $result2 = mysqli_query($conn, $sql2);

    echo $h_no."<br>";

    if(mysqli_num_rows($result2)>0){
        
        
        while($row = mysqli_fetch_assoc($result2)){

            if($row['heirarchy_no'] > $h_no){
                
                echo $row['heirarchy_no']."<br>";
                echo "hey<br>";
                $upd_h = $row['heirarchy_no']-1;
                echo "upd_h: ".$upd_h."<br>";
                
                $sql3 = "UPDATE state_table SET heirarchy_no = '$upd_h' WHERE heirarchy_no = '$row[heirarchy_no]';";

                mysqli_query($conn, $sql3);
            }
            
        }

    }
    
    $sql4 = "DELETE FROM state_table WHERE designation = '$departer';";

    mysqli_query($conn, $sql4);
    header("Location: ../index_admin.php");
?>
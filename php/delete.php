<?php
    include 'db.inc.php';
    include 'db.per.php';
    $bulk = new MongoDB\Driver\BulkWrite;
    $bulk2 = new MongoDB\Driver\BulkWrite;
    $id = $_GET["id"];


    $query_user = new MongoDB\Driver\Query([]);
    $rows = $manager->executeQuery($dbname, $query_user);
    $username_i="";   
    $firstname_i="";
    $lastname_i="";
    $password_i="";
    $person_i="";
    
    foreach($rows as $row){
        if(!strcmp($row->_id,$id)){
            $username_i = $row->username;
            $firstname_i= $row->firstname;
            $lastname_i= $row->lastname;
            $password_i= $row->password;
            $person_i = $row->person;
            break;
        }   
    }

    
    if(strcmp($person_i,"")){

        $rows_info = $manager->executeQuery($dbname_info, $query_user);
        $dep_info="";   
        $designation_info="";
    
        foreach($rows_info as $row){
            if(!strcmp($row->per_email,$person_i)){
                $dep_info = $row->dep;
                $designation_info= $row->designation;
                break;
            }   
        }

        $sql5= "SELECT * FROM faculty WHERE firstname = '$firstname_i' and lastname = '$lastname_i' and department = '$dep_info' and designation = '$designation_info' ;";

        $result5 = mysqli_fetch_assoc(mysqli_query($conn, $sql5));
        
        $sql6 = "DELETE FROM leave_portal WHERE person_id = '$result5[id]';";
        mysqli_query($conn, $sql6);


        $sql = "DELETE FROM faculty WHERE firstname = '$firstname_i' and lastname = '$lastname_i' and department = '$dep_info' and designation = '$designation_info' ;";
        mysqli_query($conn, $sql);
        
        try {
            $bulk->delete(['per_email' => $person_i]);
            $result = $manager->executeBulkWrite($dbname_info, $bulk);

        }catch(MongoDB\Driver\Exception\Exception $e){
            die("Error Encountered ".$e);
        }


        //////////////////////////////////////////////////////////////////////////////////////////////
        $sql = "SELECT * FROM state_table WHERE designation = '$designation_info';";

        $xyz = mysqli_query($conn, $sql);
        if(mysqli_num_rows($xyz)>0){
            $result = mysqli_fetch_assoc($xyz);
            $departer = $designation_info;

            $sql = "SELECT * FROM state_table WHERE designation = '$departer';";

            $result3 = mysqli_fetch_assoc(mysqli_query($conn, $sql));

            $h_no = $result3['heirarchy_no'];

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
        
            $sql4 = "DELETE FROM designation_table WHERE designation = '$departer' and dep ='$dep_info';";
            mysqli_query($conn, $sql4);

        }


    }
    else{

        $sql = "DELETE FROM faculty WHERE firstname = '$firstname_i' and lastname = '$lastname_i' ;";
        mysqli_query($conn, $sql);
        
    }

    try {
        $bulk2->delete(['_id' => new MongoDB\BSON\ObjectId($id)]);
        $result = $manager->executeBulkWrite($dbname, $bulk2);
        header("Location: ../userlist.php");
    }catch(MongoDB\Driver\Exception\Exception $e){
        die("Error Encountered ".$e);
    }

?>
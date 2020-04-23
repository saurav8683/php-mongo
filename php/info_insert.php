<?php 
    include 'db.per.php';
    $dbname = "Faculty.user_register";

    $bulk = new MongoDB\Driver\BulkWrite;
    $bulk2 = new MongoDB\Driver\BulkWrite;

    $dep = $_POST["dep"];
    $age = $_POST["age"];
    $designation = $_POST["designation"];
    $per_email = $_POST["per_email"];
    $mobile_no = $_POST["mobile_no"];
    $office_no = $_POST["office_no"];
    
    $user_info = [
        '_id' => new MongoDB\BSON\ObjectId,
        'dep' => $dep, 
        'age' => $age, 
        'designation' => $designation, 
        'per_email' => $per_email,
        'mobile_no' => $mobile_no,
        'office_no' => $office_no
    ];
    $str = (string) $_POST["id"];
    $str2="";
    
    for($i=22;$i<46;$i++){
        $str2 = $str2.$str[$i];
    }
    
    $firstname = substr($_POST["firstname"], 22, 24);
    $lastname = substr($_POST["lastname"], 22, 24);

    /////////////////////////////////////////////

    if((strcasecmp($designation, "professor")) && (strcasecmp($designation, "assc professor"))){
        
        $sql = "SELECT * FROM faculty WHERE designation = '$designation' AND department = '$dep';";

        $result = (mysqli_query($conn, $sql));

        if(mysqli_num_rows($result)>0){
            
            
            echo "<script type='text/javascript'>alert('Designation already exists!')</script>";

            header("Location: ../index_user.php");

        }
        else{

            if(preg_match('/^[0-9a-f]{24}$/i', $str2) === 1){

                try{
                    $bulk2->update(['_id' => new MongoDB\BSON\ObjectId($str2)],
                    [   
                        'firstname' => substr($_POST["firstname"], 22, 24) ,
                        'lastname' => substr($_POST["lastname"], 22, 24) ,
                        'username' => substr($_POST["username"], 22, 24) ,
                        'password' => substr($_POST["password"], 22, 24) ,
                        'person' => $per_email
                    ]);
                    $result1 = $manager->executeBulkWrite($dbname, $bulk2);
                }catch(MongoDB\Driver\Exception\Exception $e){
                    die("Error Encountered: ".$e);
                }
        
            }

            $bulk->insert($user_info);

            $result = $manager->executeBulkWrite($dbname_info, $bulk);


            $sql2 = "SELECT id FROM faculty WHERE faculty.firstname = '$firstname' and faculty.lastname = '$lastname' ;";

            $id = mysqli_fetch_assoc(mysqli_query($conn, $sql2));

            $sql= "UPDATE faculty SET department = '$dep', designation = '$designation' WHERE id=$id[id] ;";
    
            mysqli_query($conn, $sql);
            
            $person_id = $id['id'];     
            $date_i = date("Y/m/d");

            $sql ="INSERT INTO designation_table (person_id, dep, designation, start_D) VALUES ('$person_id', '$dep', '$designation', '$date_i');";
            mysqli_query($conn, $sql);
            if(!strcasecmp($designation,"Dean") || !strcasecmp($designation,"Associate Dean") || !strcasecmp($designation,"hod")){
                header("Location: ../index_dean.php");
            }
            else if(!strcasecmp($designation,"Director")){
                header("Location: ../index_director.php");
            }
            else{
                header("Location: ../index_user.php");
            }

            $query_user = new MongoDB\Driver\Query([]);
            $rows = $manager->executeQuery($dbname_info, $query_user);
                  
        
            foreach($rows as $row){
                if(!strcmp($row->_id,$user_info->_id)){
                    $person = $row;
                    break;
                }   
            }
        }
    }
    else{


    /////////////////////////////////////////////


    if(preg_match('/^[0-9a-f]{24}$/i', $str2) === 1){

        try{
            $bulk2->update(['_id' => new MongoDB\BSON\ObjectId($str2)],
            [   
                'firstname' => substr($_POST["firstname"], 22, 24) ,
                'lastname' => substr($_POST["lastname"], 22, 24) ,
                'username' => substr($_POST["username"], 22, 24) ,
                'password' => substr($_POST["password"], 22, 24) ,
                'person' => $per_email
            ]);
            $result1 = $manager->executeBulkWrite($dbname, $bulk2);
        }catch(MongoDB\Driver\Exception\Exception $e){
            die("Error Encountered: ".$e);
        }

    }

    $sql2 = "SELECT id FROM faculty WHERE faculty.firstname = '$firstname' and faculty.lastname = '$lastname' ;";

    $id = mysqli_fetch_assoc(mysqli_query($conn, $sql2));

    $sql= "UPDATE faculty SET department = '$dep', designation = '$designation' WHERE id=$id[id] ;";
    
    mysqli_query($conn, $sql);

    try{
        $bulk->insert($user_info);

        $result = $manager->executeBulkWrite($dbname_info, $bulk);

        if(!strcasecmp($designation,"Dean") || !strcasecmp($designation,"Associate Dean") || !strcasecmp($designation,"hod")){
            header("Location: ../index_dean.php");
        }
        else if(!strcasecmp($designation,"Director")){
            header("Location: ../index_director.php");
        }
        else{
            header("Location: ../index_user.php");
        }
        
    }   catch(MongoDB\Driver\Exception\Exception $e){
        die("Error Encountered: ".$e);
    }

    
    $query_user = new MongoDB\Driver\Query([]);
    $rows = $manager->executeQuery($dbname_info, $query_user);
          

    foreach($rows as $row){
        if(!strcmp($row->_id,$user_info->_id)){
            $person = $row;
            break;
        }   
    }
}
    

?>

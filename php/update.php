<?php session_start();?>
<?php
    include 'db.inc.php';
    include 'db.per.php';
    $bulk = new MongoDB\Driver\BulkWrite;
    $bulk2 = new MongoDB\Driver\BulkWrite;
    $bulk3 = new MongoDB\Driver\BulkWrite;

    $id = $_POST["id"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $personal_id = $_POST["personal_id"];
    $designation = $_POST["designation"];
    $department = $_POST["department"];

    $query_user = new MongoDB\Driver\Query([]);
    $rows = $manager->executeQuery($dbname, $query_user);
    $username_i="";   
    $firstname_i="";
    $lastname_i="";
    $password_i="";
    
    foreach($rows as $row){
        if(!strcmp($row->_id,$id)){
            $username_i = $row->username;
            $firstname_i= $row->firstname;
            $lastname_i= $row->lastname;
            $password_i= $row->password;
            break;
        }   
    }
    echo $firstname_i."<br>".$lastname_i;

    $sql2 = "SELECT * FROM faculty WHERE faculty.firstname = '$firstname_i' and faculty.lastname = '$lastname_i';";

    $id1 = mysqli_fetch_assoc(mysqli_query($conn, $sql2));

    echo $id1['id'];
    $dep_info = $id1['department'];
    $des_info = $id1['designation'];
    

    $result_firstname = "";
    $result_lastname ="";
    $EMP ="";
    
    
    if(strcasecmp($designation,$des_info)){         //Change ho gaya hai
        
        $sql= "SELECT * FROM designation_table WHERE designation = '$designation';";
        $abc = mysqli_query($conn, $sql);
        $result = mysqli_fetch_assoc($abc);
        
        $end_Da = date("Y/m/d");
        
        if(mysqli_num_rows($abc)>0){
            
            if(mysqli_num_rows($abc)>1){
                $sql= "SELECT * FROM designation_table WHERE department='$department' and designation = '$designation';";
                $abc = mysqli_query($conn, $sql);
                $result = mysqli_fetch_assoc($abc);
            }
            $sql2 = "INSERT INTO designation_log_table (person_id, department, designation, start_D, end_D) VALUES ('$result[person_id]', '$result[dep]', '$designation', '$result[start_D]', '$end_Da');";
            mysqli_query($conn, $sql2);    
        
        }
        

        $sql3= "UPDATE designation_table SET person_id = '$id1[id]', dep = '$department' , designation= '$designation' , start_D ='$end_Da' WHERE id='$result[id]' ;";
        mysqli_query($conn, $sql3);
        $EMP ="Professor";
        $sql= "UPDATE faculty SET firstname = '$firstname', lastname = '$lastname' , designation= '$designation' , department= '$department' WHERE id='$id1[id]' ;";
        mysqli_query($conn, $sql);
        

        $sql = "SELECT * FROM faculty WHERE id ='$result[person_id]';";

        $result_exit = mysqli_fetch_assoc(mysqli_query($conn, $sql));
        $result_firstname = $result_exit['firstname'];
        $result_lastname = $result_exit['lastname'];

        $sql= "UPDATE faculty SET firstname = '$result_exit[firstname]', lastname = '$result_exit[lastname]' , designation= '$EMP' , department= '$result[dep]' WHERE id='$result[person_id]' ;";
        mysqli_query($conn, $sql);
    
//////////////////////////////////////////////

        $filter = [
            'firstname' => $result_firstname,
            'lastname' => $result_lastname
        ];
        $query = new MongoDB\Driver\Query($filter);

        try {
            $result = $manager->executeQuery($dbname, $query);

            $row = $result->toArray();
            
            $id_mongo_user= $row[0]->_id;
            $changed_per_emailid = $row[0]->person;
        }catch(MongoDB\Driver\Exception\Exception $e){
            die("Error Encountered ".$e);
        }

        $info_filter1 = [
            'per_email' => $changed_per_emailid
        ];
        $query = new MongoDB\Driver\Query($info_filter1);

        try {
            $result = $manager->executeQuery($dbname_info, $query);

            $row = $result->toArray();
            
            $id_mongo1= $row[0]->_id;
            $dep_mongo1 = $row[0]->dep;
            $age_mongo1 = $row[0]->age;
            $designation_mongo1 = $row[0]->designation;
            $mob_mongo1 = $row[0]->mobile_no;
            $office_mongo1 = $row[0]->office_no;
        }catch(MongoDB\Driver\Exception\Exception $e){
            die("Error Encountered ".$e);
        }

        try {
            $bulk->update(['_id' => new MongoDB\BSON\ObjectId($id_mongo1)],
            [
                'dep' => $dep_mongo1,
                'age' => $age_mongo1,
                'designation' => $EMP,
                'per_email' => $changed_per_emailid,
                'mobile_no' => $mob_mongo1,
                'office_no' => $office_mongo1
            ]);
            $result = $manager->executeBulkWrite($dbname, $bulk);
        
        }catch(MongoDB\Driver\Exception\Exception $e){
            die("Error Encountered ".$e);
        }



















        $info_filter = [
            'per_email' => $personal_id
        ];
        $query = new MongoDB\Driver\Query($info_filter);

        try {
            $result = $manager->executeQuery($dbname_info, $query);

            $row = $result->toArray();
            
            $id_mongo= $row[0]->_id;
            $dep_mongo = $row[0]->dep;
            $age_mongo = $row[0]->age;
            $designation_mongo = $row[0]->designation;
            $mob_mongo = $row[0]->mobile_no;
            $office_mongo = $row[0]->office_no;
        }catch(MongoDB\Driver\Exception\Exception $e){
            die("Error Encountered ".$e);
        }

        try {
            $bulk2->update(['_id' => new MongoDB\BSON\ObjectId($id_mongo)],
            [
                'dep' => $department,
                'age' => $age_mongo,
                'designation' => $designation,
                'per_email' => $personal_id,
                'mobile_no' => $mob_mongo,
                'office_no' => $office_mongo
            ]);
            $result = $manager->executeBulkWrite($dbname_info, $bulk2);
            
        }catch(MongoDB\Driver\Exception\Exception $e){
            die("Error Encountered ".$e);
        }










        //////////////////////////////////////////
    }
    else{

        $sql= "UPDATE faculty SET firstname = '$firstname', lastname = '$lastname' , designation = '$designation', department = '$department' WHERE id='$id1[id]' ;";
    
        mysqli_query($conn, $sql);
    }
    


    










    try {
        $bulk3->update(['_id' => new MongoDB\BSON\ObjectId($id)],
        [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'username' => $username,
            'password' => $password,
            'person' => $personal_id
        ]);
        $result = $manager->executeBulkWrite($dbname, $bulk3);
        header("Location: ../userlist.php");
    }catch(MongoDB\Driver\Exception\Exception $e){
        die("Error Encountered ".$e);
    }
    

?>
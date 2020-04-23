<?php 
    session_start();
    include 'db.inc.php';
    $username = $_POST["username"];
    $password = $_POST["password"];

    $filter = [
        'username' => $username, 
        'password' => $password
    ];
    $query = new MongoDB\Driver\Query($filter);


    try{
        $result = $manager->executeQuery($dbname, $query);
        
        $row = $result->toArray();
        if($row == NULL){
            echo "EITHER USERNAME OR PASSWORD IS INCORRECT.\n";
            header("Location: ../login.php");
        }
        else{

            $firstname = $row[0]->firstname;
            $lastname = $row[0]->lastname;
            $user = $row[0]->username;
            $pass = $row[0]->password;
            $_SESSION['username'] = $user;
            if( !strcmp($user, $username) && !strcmp($pass,$password)){
            
                if(!strcmp($username, "admin")){
                    header("Location: ../index_admin.php");
                }
                else{

                    $sql2 = "SELECT * FROM faculty WHERE faculty.firstname = '$firstname' and faculty.lastname = '$lastname' ;";
                    
                    $id1 = mysqli_fetch_assoc(mysqli_query($conn, $sql2));

                    $designation =  $id1['designation'];

                    echo $designation;
                    if(!strcasecmp($designation,"Dean") || !strcasecmp($designation,"Associate Dean") || !strcasecmp($designation,"hod")){
                        header("Location: ../index_dean.php");
                    }
                    else if(!strcasecmp($designation,"Director")){
                        header("Location: ../index_director.php");
                    }
                    else{
                        header("Location: ../index_user.php");
                    }
                    
                }
            }
        }
        
        
    }   catch(MongoDB\Driver\Exception\Exception $e){
        die("Error Encountered: ".$e);
    }
?>

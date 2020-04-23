<?php 
    include 'db.inc.php';
    $bulk = new MongoDB\Driver\BulkWrite;

    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    

    $user = [
        '_id' => new MongoDB\BSON\ObjectId,
        'firstname' => $firstname, 
        'lastname' => $lastname, 
        'username' => $username, 
        'password' => $password,
        'person' => ""
    ];

    $sql= "INSERT into faculty (firstname, lastname, leaves_available_this_year, leaves_available_next_year) values ('$firstname', '$lastname', '30', '30');";

    mysqli_query($conn, $sql);

    try{
        $bulk->insert($user);
        $result = $manager->executeBulkWrite($dbname, $bulk);
        header("Location: ../login.php");
    }   catch(MongoDB\Driver\Exception\Exception $e){
        die("Error Encountered: ".$e);
    }

?>

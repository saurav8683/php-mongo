<!DOCTYPE html>
<html lang="en">
<head>
    <script language = "javascript" type="text/javascript">
        window.history.forward();
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Userlist</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <?php 
    include 'topnav_user.php';
    ?>
    <div class="container mt-5 pt-5">
        <div class="row">
            <h2>Users List</h2>
            <?php 
            try{
                include 'php/db.inc.php';
                $query = new MongoDB\Driver\Query([]);

                $rows = $manager->executeQuery($dbname, $query);
                
                

                echo "<table class='table'>
                    <thead>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Department</th>
                        <th>Designation</th>
                    </thead>";
                
                foreach($rows as $row){
                    
                    $sql = "SELECT * FROM faculty WHERE firstname = '$row->firstname' and lastname = '$row->lastname';";
                    $result = mysqli_fetch_assoc(mysqli_query($conn, $sql));
                    echo "<tr>".
                        "<td>".$row->firstname."</td>".
                        "<td>".$row->lastname."</td>".
                        "<td>".$result['department']."</td>".
                        "<td>".$result['designation']."</td>".
                    "</tr>";
                }
                    
                echo"</table>";
            }   catch(MongoDB\Driver\Exception\Exception $e){
                die("Error Encountered: ".$e);
            }
            ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>

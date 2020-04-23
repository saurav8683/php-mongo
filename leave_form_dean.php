<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head> 
<script language = "javascript" type="text/javascript">
        window.history.forward();
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Leave Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <?php include 'topnav_auth.php';?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 mt-5">                
                <form action="leave.php" method="POST">
                    <h2 class="text-center">LEAVE APPLICATION</h2>
                    <input type="hidden" name="id" value="
                    <?php 
                        include 'php/db.inc.php';
          
                        $query_user = new MongoDB\Driver\Query([]);
                        
                        $rows = $manager->executeQuery($dbname, $query_user);
                        
                        $firstname="";
                        $lastname="";
                        
                        foreach($rows as $row){
                          if(!strcmp($row->username,$_SESSION['username'])){
                            
                            $lastname = $row->lastname;
                            $firstname = $row->firstname; 
                          break;
                          }   
                        }
                        
                        $sql2 = "SELECT id FROM faculty WHERE faculty.firstname = '$firstname' and faculty.lastname = '$lastname' ;";

                        $id = mysqli_fetch_assoc(mysqli_query($conn, $sql2));

                        echo $id['id'];
                         
                    ?>">
                    <input type="hidden" name="firstname" value="
                    <?php 
                        include 'php/db.inc.php';
          
                        $query_user = new MongoDB\Driver\Query([]);
                        $rows = $manager->executeQuery($dbname, $query_user);
          
                        foreach($rows as $row){
                          if(!strcmp($row->username,$_SESSION['username'])){
                            echo $row->firstname;
                          break;
                          }   
                        }                    
                         
                    ?>">
                    <input type="hidden" name="lastname" value="
                    <?php 
                        include 'php/db.inc.php';
          
                        $query_user = new MongoDB\Driver\Query([]);
                        $rows = $manager->executeQuery($dbname, $query_user);
          
                        foreach($rows as $row){
                          if(!strcmp($row->username,$_SESSION['username'])){
                            echo $row->lastname;
                          break;
                          }   
                        }                    
                         
                    ?>">
                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" placeholder="Enter Start Date">
                    </div>
                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" placeholder="Enter End Date">
                    </div>
                    <div class="form-group">
                        <label for="reason">Reason</label>
                        <input type="text" class="form-control" id="reason" name="reason" placeholder="Enter Reason">
                    </div>
                    <div class="form-group">
                        <label for="borrow">Borrow from next year</label>
                        <input type="int" class="form-control" id="borrow" name="borrow" placeholder="Enter 1 to borrow and 0 to not borrow.">
                    </div>
                    <input type="submit" value="SUBMIT" class="btn btn-primary btn-block">
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!-- <script>
        var password = document.getElementById("password")
        , confirm_password = document.getElementById("confirm");

        function validatePassword(){
        if(password.value != confirm_password.value) {
            confirm_password.setCustomValidity("Passwords Don't Match");
        } else {
            confirm_password.setCustomValidity('');
        }
        }

        password.onchange = validatePassword;
        confirm_password.onkeyup = validatePassword;
    </script> -->
</body>
</html>
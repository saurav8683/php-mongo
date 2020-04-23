<?php session_start();?>
<!doctype html>
<html lang="en">
  <head>
  <script language = "javascript" type="text/javascript">
        window.history.forward();
    </script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>Portal</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"><link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  </head>

  <body>

    <?php include 'topnav_user.php';?>

    <main role="main">

      <!-- Main jumbotron for a primary marketing message or call to action -->
      <div class="jumbotron">
        <div class="container">
          <h1 class="display-3">Hello, 
          <?php 
            if(isset($_SESSION['username'])){
              echo $_SESSION['username'];
            }else {
              echo 'world!';
            }
          ?>
          </h1>
          <p>
            <?php
              include 'php/db.per.php';
              include 'php/db.inc.php';

              $query_user = new MongoDB\Driver\Query([]);
              $rows = $manager->executeQuery($dbname, $query_user);

              $id = "";
              $firstname="";
              $lastname="";
              $person="";
              foreach($rows as $row){
                if(!strcmp($row->username,$_SESSION['username'])){
                  $id = $row->_id;
                  $firstname= $row->firstname;
                  $lastname= $row->lastname;
                  $person = $row->person;
                break;
                }   
              } 

              $info_rows = $manager->executeQuery($dbname_info, $query_user);
              $dep=""; $age=0; $design="";$per_email=""; $mob_no=""; $office_no="";
              
              foreach($info_rows as $row){
                if(!strcmp($row->per_email,$person)){
                  
                  $dep=$row->dep; 
                  $age=$row->age; 
                  $design=$row->designation;
                  $per_email=$row->per_email; 
                  $mob_no=$row->mobile_no; 
                  $office_no=$row->office_no;
                  
                  break;
                }   
              }
              
              echo "Name: ".$firstname." ".$lastname."<br>";
              echo "Department: ".$dep."<br>";
              echo "Designation: ".$design."<br>";
              echo "Mobile Number: ".$mob_no."<br>";
              echo "Office Number: ".$office_no."<br>";
              echo "Personal EmailId: ".$per_email."<br>";
              
              $sql = "SELECT * FROM faculty WHERE faculty.firstname = '$firstname' and faculty.lastname = '$lastname' and faculty.department='$dep';";

              $id1 = mysqli_fetch_assoc(mysqli_query($conn, $sql));

              echo "Number of Leaves Available: ".$id1['leaves_available_this_year']."<br>";

            ?>
          </p>
          <p><a class="btn btn-primary btn-lg" href="info_register.php" role="button">Add | Edit &raquo;</a></p>
          <p><a class="btn btn-primary btn-lg" href="leave_form.php" role="button">Apply for Leave &raquo;</a></p>
          <p><a class="btn btn-primary btn-lg" href="leave_status.php" role="button">Leave Status &raquo;</a></p>
        </div>
      </div>

    </main>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>

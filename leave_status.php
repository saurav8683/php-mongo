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

    <title>Leave Status</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"><link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  </head>

  <body>

    <?php include 'topnav_user.php';?>
    <div class= "leave cancel">
        
        <a href="leave_cancel.php">Cancel Leave</a>
        <!--<p><a class="btn btn-primary btn-lg" href="info_register.php" role="button">Add | Edit &raquo;</a></p>-->
        </div>
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
            
              
              $sql = "SELECT * FROM faculty WHERE faculty.firstname = '$firstname' and faculty.lastname = '$lastname' ;";

              $id = mysqli_fetch_assoc(mysqli_query($conn, $sql));
              $idi = $id['id'];
              $leaves_next_year = $id['leaves_available_next_year'];
              $sql2 = "SELECT * FROM leave_portal WHERE person_id = $idi ";

              $result = mysqli_query($conn, $sql2);
              
              if(mysqli_num_rows($result) > 0){

                while($row = mysqli_fetch_assoc($result)){
                    $stat="";
                    $leave_id = $row['id'];
                    if($row['leave_status'] == 0){
                        $stat = "Pending";
                    }
                    else if($row['leave_status'] == 1){
                        $stat = "Review";
                    }
                    else if($row['leave_status'] == 2){
                        $stat = "Approved";
                    }
                    else if($row['leave_status'] == 3){
                        $stat = "Rejected";
                    }

                    $url = $_SERVER['REQUEST_URI'];
                    echo "LEAVES:<br>";
                    echo "Start Date: ".$row['start_D']."<br>"."End Date: ".$row['end_D']."<br>"."Number of Days: ".$row['number_of_days']."<br>"."Status: ".$stat."<br>";
                    
                    
                    if($row['leave_status'] == 1){
                      
                      $sql1 = "SELECT * FROM comment_portal WHERE leave_id='$leave_id';";

                      $result1 = mysqli_fetch_assoc(mysqli_query($conn, $sql1));

                      $comment = $result1['comment'];

                      echo "Comment: ".$comment."<br>";
                      echo "<a href='review_leave_form.php?leave_id=".$leave_id.
                      "&start_D=".$row['start_D'].
                      "&end_D=".$row['end_D'].
                      "&reason=".$row['reason'].
                      "&URL=".$url."'>Review Leave</a>"."<br>";
                    }
                    else if($row['leave_status'] == 2 && $leaves_next_year < 30){
                        echo "Leaves successfully Borrowed.<br>";
                        echo "<a href=leave_cancel.php?id=$leave_id>Cancel Leave | Remove if Approved</a>"."<br>";
                    }
                    else{
                      echo "<a href=leave_cancel.php?id=$leave_id>Cancel Leave</a>"."<br>";
                    }
                    
                }
              }
              else{
                  echo "NO APPLIED LEAVE <br>";
              }

            ?>
          </p>

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

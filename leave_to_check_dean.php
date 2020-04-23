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

    <title>Leaves Check</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"><link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  </head>

  <body>

    <?php include 'topnav_auth.php';?>

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
          <h3>Leaves To Approve</h3>
          
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
              
              if(empty($dep)){


              
              
              $sql_direcID = "SELECT * FROM faculty WHERE designation = '$design'";

              $result_direc = mysqli_query($conn, $sql_direcID);

              $arr = mysqli_fetch_assoc($result_direc);
              
              $direcI = $arr['firstname']." ".$arr['lastname'];

              $signing_id = $arr['id'];

              $designation =strtoupper($design);
              
              $sql = "SELECT * FROM state_table WHERE designation = '$designation';";

              $id1 = mysqli_fetch_assoc(mysqli_query($conn, $sql));

              $state= $id1['heirarchy_no'];
    
              $sql = "SELECT * FROM leave_portal WHERE leave_portal.position='$state' and leave_portal.leave_status='0' ";

              $result = mysqli_query($conn, $sql);
              
              echo "<table class='table'>
                    <thead>
                        <th>Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Number of Days</th>
                        <th>Reason</th>
                        <th>Action</th>
                    </thead>";

              if(mysqli_num_rows($result) > 0){

                while($row = mysqli_fetch_assoc($result)){
                    $stat="";
                    $leave_id = $row['id'];
                    $person_id = $row['person_id'];

                    $sql2 = "SELECT * FROM faculty WHERE id= '$person_id' ";
                    $person_result = mysqli_query($conn, $sql2);
                    
                    $person_info = mysqli_fetch_assoc($person_result);
                    
                    $url = $_SERVER['REQUEST_URI'];

                    echo "<tr>".
                        "<td>".$person_info['firstname']." ".$person_info['lastname']."</td>".
                        "<td>".$row['start_D']."</td>".
                        "<td>".$row['end_D']."</td>".
                        "<td>".$row['number_of_days']."</td>".
                        "<td>".$row['reason']."</td>".
                        "<td><a class='btn btn-info' href='approve_director.php?leave_id=".$leave_id.
                        "&direcID=".$direcI.
                        "&heirarchy=".$state.
                        "'>Approve</a>".
                        "<a class='btn btn-danger' href='reject_leave.php?leave_id=".$leave_id.
                        "&direcID=".$direcI.
                        "&heirarchy=".$state.
                        "&URL=".$url.
                        "'>Reject</a>".
                        "<a class='btn btn-info' href='comment_portal.php?leave_id=".$leave_id.
                        "&signing_id=".$signing_id.
                        "&heirarchy=".$state.
                        "&URL=".$url.
                        "'>Review</a>"."</td>".
                    "</tr>";

                    //echo "Name: ".$person_info['firstname']." ".$person_info['lastname']." "."Start Date: ".$row['start_D']."<br>"."End Date: ".$row['end_D']."<br>"."Number of Days: ".$row['number_of_days']."<br>";
                    
                    //echo "<a href=leave_cancel.php?id=$leave_id>Cancel Leave</a>"."<br>";
                }
            }
            }
            else{

                $sql_direcID = "SELECT * FROM faculty WHERE designation = '$design' and department = '$dep'";

              $result_direc = mysqli_query($conn, $sql_direcID);

              $arr = mysqli_fetch_assoc($result_direc);
              
              $direcI = $arr['firstname']." ".$arr['lastname'];
                $signing_id = $arr['id'];
              $designation =strtoupper($design);
              
              $sql = "SELECT * FROM state_table WHERE designation = '$designation';";

              $id1 = mysqli_fetch_assoc(mysqli_query($conn, $sql));

              $state= $id1['heirarchy_no'];
                
              $sql = "SELECT * FROM leave_portal WHERE leave_portal.position='$state' and leave_portal.leave_status='0';";

              $result = mysqli_query($conn, $sql);
              
              echo "<table class='table'>
                    <thead>
                        <th>Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Number of Days</th>
                        <th>Reason</th>
                        <th>Action</th>
                    </thead>";

              if(mysqli_num_rows($result) > 0){

                while($row = mysqli_fetch_assoc($result)){
                    $stat="";
                    $leave_id = $row['id'];
                    $person_id = $row['person_id'];


                    $sql2 = "SELECT * FROM faculty WHERE id= '$person_id' and department = '$dep'";
                    $person_result = mysqli_query($conn, $sql2);
                    $url = $_SERVER['REQUEST_URI'];
                    $person_info = mysqli_fetch_assoc($person_result);
                    if(!empty($person_info)){
                    
                    echo "<tr>".
                        "<td>".$person_info['firstname']." ".$person_info['lastname']."</td>".
                        "<td>".$row['start_D']."</td>".
                        "<td>".$row['end_D']."</td>".
                        "<td>".$row['number_of_days']."</td>".
                        "<td>".$row['reason']."</td>".
                        "<td><a class='btn btn-info' href='approve_director.php?leave_id=".$leave_id.
                        "&direcID=".$direcI.
                        "&heirarchy=".$state.
                        "'>Approve</a>".
                        "<a class='btn btn-danger' href='reject_leave.php?leave_id=".$leave_id.
                        "&direcID=".$direcI.
                        "&heirarchy=".$state.
                        "&URL=".$url.
                        "'>Reject</a>".
                        "<a class='btn btn-info' href='comment_portal.php?leave_id=".$leave_id.
                        "&signing_id=".$signing_id.
                        "&URL=".$url.
                        "'>Review</a>"."</td>".
                    "</tr>";
                    }    
                    //echo "Name: ".$person_info['firstname']." ".$person_info['lastname']." "."Start Date: ".$row['start_D']."<br>"."End Date: ".$row['end_D']."<br>"."Number of Days: ".$row['number_of_days']."<br>";
                    
                    //echo "<a href=leave_cancel.php?id=$leave_id>Cancel Leave</a>"."<br>";
                }
            }   
            }
          ?>
          <h3>Already on Leave</h3>
          
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
            
            $designation =strtoupper($design);
            
            $sql = "SELECT * FROM state_table WHERE designation = '$designation';";

            $id1 = mysqli_fetch_assoc(mysqli_query($conn, $sql));

            $state= $id1['heirarchy_no'];
  
            $sql = "SELECT * FROM log_table WHERE leave_status = '2' ";

            $result = mysqli_query($conn, $sql);
            
            echo "<table class='table'>
                  <thead>
                      <th>Name</th>
                      <th>Start Date</th>
                      <th>End Date</th>
                      <th>Signed By</th>
                      <th>Signed Date</th>
                  </thead>";

            if(mysqli_num_rows($result) > 0){

              while($row = mysqli_fetch_assoc($result)){
                  $stat="";
                  
                  $person_id = $row['person_id'];

                  $sql2 = "SELECT * FROM faculty WHERE id= '$person_id' ";
                  $person_result = mysqli_query($conn, $sql2);
                  
                  $person_info = mysqli_fetch_assoc($person_result);


                  
                  echo "<tr>".
                      "<td>".$person_info['firstname']." ".$person_info['lastname']."</td>".
                      "<td>".$row['start_D']."</td>".
                      "<td>".$row['end_D']."</td>".
                      "<td>".$row['signed_by']."</td>".
                      "<td>".$row['signed_date']."</td>".
                  "</tr>";

                  //echo "Name: ".$person_info['firstname']." ".$person_info['lastname']." "."Start Date: ".$row['start_D']."<br>"."End Date: ".$row['end_D']."<br>"."Number of Days: ".$row['number_of_days']."<br>";
                  
                  //echo "<a href=leave_cancel.php?id=$leave_id>Cancel Leave</a>"."<br>";
              }
            }
          ?>
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


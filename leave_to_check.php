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

    <title>Leaves Ccheck</title>

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
              
              $designation =strtoupper($design);
              
              $sql = "SELECT * FROM state_table WHERE designation = '$designation';";

              $id1 = mysqli_fetch_assoc(mysqli_query($conn, $sql));

              $state= $id1['heirarchy_no'];
              
              echo "Heirarchy Number: ".$state."<br>";

            ?>
          </p>
        </div>
      </div>

      <div class="container">
        <!-- Example row of columns -->
        <div class="row">
          <div class="col-md-4">
            <h2>Heading</h2>
            <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
            <p><a class="btn btn-secondary" href="#" role="button">View details &raquo;</a></p>
          </div>
          <div class="col-md-4">
            <h2>Heading</h2>
            <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
            <p><a class="btn btn-secondary" href="#" role="button">View details &raquo;</a></p>
          </div>
          <div class="col-md-4">
            <h2>Heading</h2>
            <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
            <p><a class="btn btn-secondary" href="#" role="button">View details &raquo;</a></p>
          </div>
        </div>

        <hr>

      </div> <!-- /container -->

    </main>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>


<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 mt-5">                
                <form action="review_back_leave.php" method="POST">
                    <h2 class="text-center">Edit User</h2>
                    
                    <input type="hidden" name="leave_id" value="<?php echo $_GET["leave_id"]; ?>">
                    <input type="hidden" name="URL" value="<?php echo $_GET["URL"]; ?>">
                    <div class="form-group">
                        <label for="start_D">Start Date</label>
                        <input type="date" class="form-control" id="start_D" name="start_D"  value="<?php echo $_GET["start_D"]; ?>" placeholder="<?php echo $_GET["start_D"]; ?>">
                    </div>
                    <div class="form-group">
                        <label for="end_D">End Date</label>
                        <input type="date" class="form-control" id="end_D" name="end_D" value="<?php echo $_GET["end_D"]; ?>" placeholder="<?php echo $_GET["end_D"]; ?>">
                    </div>
                    <div class="form-group">
                        <label for="reason">Reason</label>
                        <input type="text" class="form-control" id="reason" name="reason" value="<?php echo $_GET["reason"]; ?>" placeholder="<?php echo $_GET["reason"]; ?>">
                    </div>
                    <input type="submit" value="SEND" class="btn btn-primary btn-block">
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
<?php
	  include "config/config.php";
	  session_start();

	  $errors = array();
	if (isset($_POST['submit'])) {

		  $admin_username = mysqli_real_escape_string($conn,$_POST['admin_username']);
		  $admin_password = mysqli_real_escape_string($conn,$_POST['admin_password']);
		
		  $check_admin_username = "SELECT * FROM admins WHERE admin_username = '$admin_username'";
		  $result = mysqli_query($conn, $check_admin_username);
		  $row = mysqli_fetch_assoc($result);

		  if (!empty($row)) {
			
			    if ($row['admin_username'] == $admin_username) {

				      $verified_pass = $row['admin_password'];

				      if ($verified_pass){

					        $_SESSION['admin_id']= $row['admin_id'];
						      echo '<meta http-equiv="refresh" content="0; url= index.php">';
					    }
				  }else {
					    array_push($errors, "Email or Passoword is incorrect.");
				  }
		  }else {
			    array_push($errors, "Email or Passoword is incorrect.");
		  }  	
	} 
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="PhiLander">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Stock Management System</title>
</head>
<body>
    <div class="container">
        <div class="heading-text">
            <h2>Welcome to Stock Manager</h2>
            <p>please enter your details below to start a stock management session, please not a time or ticket starts as soon as you login, and when done, must logout to end session</p>
        </div>
        <div class="login-form">
            <form action="" method="post" class="form" enctype="multipart/form-data">
                <input type="text" name="admin_username" placeholder="admin_username">
                <input type="password" name="admin_password" placeholder="admin_password">
                <button type="submit" name="submit">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
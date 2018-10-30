<?php
session_start();
?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login</title>
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
</head>

<body>
<script src="js/jquery-1.11.3.min.js"></script>

<?php
	  $servername = "localhost";
	  $username = "root";
	  $password = "root";
	  $dbname = "CouCou";
	  
	  $conn = new mysqli($servername, $username, $password, $dbname);
		
	  // if a staff member entered a username in order to login
	  if (!empty($_POST["username"]))
	  {
		  // get the username and password from the login page
	  	  $username= $_POST["username"];
		  $pass = $_POST["password"];
		  
		  // check if the username exists in the database
	      $sql = "SELECT username FROM Staff WHERE username='$username'";
	      $result = mysqli_query($conn, $sql);
		  
		  // if the username exists in the database
	      if (mysqli_num_rows($result) > 0)
	      {
			// get the staff member's password based on the entered username and password
		  	$qry = "SELECT password FROM Staff WHERE username='$username' AND password='$pass'";
		  	$res = mysqli_query($conn, $qry);
			  
			// if a password exists for the username
		  	if (mysqli_num_rows($res) > 0)
		  	{
				while($row = $res->fetch_assoc())
				{
						// store the username in a session
						$_SESSION["username"] = $username;
				
						// redirect the staff member to the welcome page
						echo "<script>";
						echo "window.location.href = \"welcome.php\";";
						echo "</script";	
				}
			}
			else
			{
				// staff member entered incorrect password
				// display error message and an error image
				// provide option for staff member to go back and enter their details again
		  	  	echo "<p id=\"errorMessage\">Incorrect Password!</p>";
		      	echo "<div class=\"handler-area\">";
		      	echo "<img id=\"handler-image\" src=\"images/error.png\" width=\"150\" height=\"150\">";
		      	echo "<a href=\"index.html\" class=\"btn btn-lg btn-default animsition-link button handlerButton\" role=\"button\">Back</a>";
		      	echo "</div>";  
			}
		  }
		  else
		  {
			  // the staff username entered does not exist
			  // display error message and an error image
			  // provide option for staff member to go back and enter their details again
		  	  echo "<p id=\"errorMessage\">Staff Member Doesn't Exist!</p>";
		      echo "<div class=\"handler-area\">";
		      echo "<img id=\"handler-image\" src=\"images/error.png\" width=\"150\" height=\"150\">";
		      echo "<a href=\"index.html\" class=\"btn btn-lg btn-default animsition-link button handlerButton\" role=\"button\">Back</a>";
		      echo "</div>";
		  }
	  }
?>

<script src="js/bootstrap.js"></script>
</body>
</html>
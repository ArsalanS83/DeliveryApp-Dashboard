<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CouCou Food</title>
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
  </head>
  <body>
	<script src="js/jquery-1.11.3.min.js"></script>
	<img src="images/Logo.jpg" alt="CouCou Logo" class="img-rounded img-responsive" id="logo">
	
	<div class="header">
		<p id="welcomeText">Hello
		
		<?php
			
			  $servername = "localhost";
			  $username = "root";
			  $password = "root";
			  $dbname = "CouCou"; 
			  
			  $conn = new mysqli($servername, $username, $password, $dbname);
			  
			  // get the staff member's username
			  $user= $_SESSION["username"];
			  
			  // get the staff member's first name and last name from the database using the staff member's username
			  $sql = "SELECT firstName, lastName FROM Staff WHERE username= '$user'";
			  $result = mysqli_query($conn, $sql);
			
			  // display welcome message for staff member
			  if (mysqli_num_rows($result) > 0) {
				  
				  while($row = $result->fetch_assoc())
				  {
					  // display the first name and surname of the staff member
					  echo " ";
					  echo $row["firstName"];
					  echo " ";
					  echo $row["lastName"];
				  } 
			  }
			
			 mysqli_close($conn);
		?>
		
		</p>
	</div>
	
	<div id="date">
		<p id="theDate"></p>
	</div>
	
	<div id="time">
		<p id="theTime"></p>
	</div>
	
	<div class="welcome-area">
		<a href="orders.php" class="btn btn-lg btn-default button welcomeButtons">Manage Customer Orders</a>
		<a href="monitor.php" class="btn btn-lg btn-default button welcomeButtons">Monitor Customer Reviews</a>
		<a href="index.html" class="btn btn-lg btn-default button welcomeButtons signOutButton">Sign Out</a>
	</div>
	
	<script src="js/bootstrap.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.js"></script>
	
	<script>
		
		// display the current time which dynamically updates
		function startTime() {
			var today = new Date();
    		document.getElementById('theTime').innerHTML = today.toLocaleTimeString();
			var t = setTimeout(startTime, 500);
		}
		
		startTime();
		
		// display the current date
		var d = new Date();
		document.getElementById("theDate").innerHTML = d.toDateString();
		
	</script>
  </body>
</html>
<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Sign Up</title>
		<link href="css/bootstrap.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="css/animsition.min.css">
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
	  
	  // Get the email from the signup form
	  $email = $_POST["email"];
	  
	  // check if the entered email exists in the database
	  $sql = "SELECT email FROM Customer WHERE email='$email'";
	  $result = mysqli_query($conn, $sql);
	
	  // If the entered email exists in the database, display an error message and an error image 
	  // provide a back button to allow the user to return to the signup form
	  if (mysqli_num_rows($result) > 0)
	  {
		  echo "<div class=\"animsition\">";
		  echo "<div class=\"appHeader\">";
		  echo "<p id=\"headerText\">User Already Exists!</p>";
		  echo "</div>";
		  
		  echo "<div class=\"signup-handler-area\">";
		  echo "<img id=\"handler-image\" src=\"images/error.png\" width=\"150\" height=\"150\">";
		  echo "<a href=\"sign-up.html\" class=\"btn btn-lg btn-default animsition-link button homeButtons\" role=\"button\">Back</a>";
		  echo "</div>";  
	  }
	  else
	  {
		  // if an email was entered in the signup form
		  if (!empty($_POST["email"]))
		  {
			  // retrieve the signup form details
			  $firstName = $_POST["firstName"];
		  	  $lastName = $_POST["surname"];
	  	  	  $email = $_POST["email"];
			  
			  $password = $_POST["password"];
			  
			  // apply hashing algorithm to the plain text password entered by the user to securely store their password
			  $hash = password_hash($password,PASSWORD_DEFAULT);
			  
			  // retrieve the rest of the signup form details
	          $phone = $_POST["phone"];
	          $addressLine1 = $_POST["addressLine1"];
	          $addressLine2 = $_POST["addressLine2"];
	          $city = $_POST["city"];
	          $postcode= $_POST["postcode"];
			  
			  // insert the new customer data into the database using the signup form details
		      $sql = "INSERT INTO Customer (firstName, lastName, email,password,phoneNumber,addressLine1,addressLine2,city,postCode)
		  
		     VALUES ('$firstName', '$lastName', '$email','$hash','$phone','$addressLine1','$addressLine2','$city','$postcode')";

		  	 // display signup successful message and an image
			 // provide the user with a button link to the login page to allow the user to log in to the mobile app
			 echo "<div class=\"animsition\">";
		     echo "<div class=\"appHeader\">";
		     echo "<p id=\"headerText\">Signed Up!</p>";
		     echo "</div>";
		  
		     echo "<div class=\"signup-handler-area\">";
		     echo "<img id=\"handler-image\" src=\"images/tick.png\" width=\"150\" height=\"150\">";
		     echo "<a href=\"login.html\" class=\"btn btn-lg btn-default animsition-link button homeButtons\" role=\"button\">Login</a>";
		     echo "</div>";    
		  }
	  }
		
	  	// have the details been inserted into the database successfully?
		if (mysqli_query($conn, $sql)) {
		}
		else
		{
			// if not, then an SQL error occured
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	  mysqli_close($conn);
	?>
	
	<script src="js/bootstrap.js"></script>
	<script src="js/animsition.min.js"></script>
	<script>
	  $(document).ready(function() {
		  $(".animsition").animsition({
			  inClass: 'fade-in',
			  outClass: 'fade-out',
			  inDuration: 900,
			  outDuration: 800,
			  linkElement: '.animsition-link',
			  loading: true,
			  loadingParentElement: 'body', 
			  loadingClass: 'animsition-loading',
			  loadingInner: '',
			  timeout: false,
			  timeoutCountdown: 5000,
			  onLoadEvent: true,
			  browser: [ 'animation-duration', '-webkit-animation-duration'],
			  overlay : false,
			  overlayClass : 'animsition-overlay-slide',
			  overlayParentElement : 'body',
			  transition: function(url){ window.location.href = url; }
		  });
	  });
	 </script>
	</body>
</html>
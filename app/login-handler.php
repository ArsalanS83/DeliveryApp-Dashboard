<?php
session_start();
?>

<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Login Handler</title>
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
		
	  // if an email address has been entered when logging in	
	  if (!empty($_POST["email"]))
	  {
		  // Get the email and password entered in the login form
	  	  $email = $_POST["email"];
		  $pass = $_POST["password"];
	  
		  // check if the entered email exists in the database
	      $sql = "SELECT email FROM Customer WHERE email='$email'";
	      $result = mysqli_query($conn, $sql);
	
	      // if the email exists in the database
	      if (mysqli_num_rows($result) > 0)
	      {
			// attempt to get the user's hashed password based on the entered email address
		  	$qry = "SELECT password FROM Customer WHERE email='$email'";
		  	$res = mysqli_query($conn, $qry);
		  
		  	// if a password exists for the entered email address
		  	if (mysqli_num_rows($res) > 0)
		  	{
				while($row = $res->fetch_assoc())
				{
					// check if entered password matches stored password hash
					$passwordMatch = password_verify($pass,$row["password"]);
					
					// if the password matches
					if ($passwordMatch == true)
					{
						// display welcome page
						
						// Store logged in customer's email address in a session variable
						$_SESSION["emailAddress"] = $email;
				
						// setup an array holding the user's items in their order cart
						$addedItems = array();
				
						// store this array in a session variable
						$_SESSION["addedItems"] = $addedItems;
				
						// redirect customer to welcome page
						echo "<script>";
						echo "window.location.href = \"welcome.php\";";
						echo "</script";	
					}
					else
					{
						// Incorrect password entered for existing account
						// display error message and an error image
						// provide an option for the user to go back and attempt to login again
			  			echo "<div class=\"animsition\">";
			  			echo "<div class=\"appHeader\">";
		  	  			echo "<p id=\"headerText\">Incorrect Password!</p>";
		  	  			echo "</div>";
		  
		      			echo "<div class=\"signup-handler-area\">";
		      			echo "<img id=\"handler-image\" src=\"images/error.png\" width=\"150\" height=\"150\">";
		      			echo "<a href=\"login.html\" class=\"btn btn-lg btn-default animsition-link button homeButtons\" role=\"button\">Back</a>";
		      			echo "</div>";  
					}
				}		
		  	}
	  	  }
	  	  else
		  {
			  // The email does not exist
			  // display error message and an error image
			  // provide an option for the user to go back and attempt to login again
		  	  echo "<div class=\"animsition\">";
			  echo "<div class=\"appHeader\">";
		  	  echo "<p id=\"headerText\">Email Doesn't Exist!</p>";
		  	  echo "</div>";
		  
		      echo "<div class=\"signup-handler-area\">";
		      echo "<img id=\"handler-image\" src=\"images/error.png\" width=\"150\" height=\"150\">";
		      echo "<a href=\"login.html\" class=\"btn btn-lg btn-default animsition-link button homeButtons\" role=\"button\">Back</a>";
		      echo "</div>";
		  }
	  }
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
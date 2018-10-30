<?php
session_start();
?>

<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Edit Account</title>
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
		
		// get posted edited account data
		$firstName = $_POST["firstName"];
		$surname = $_POST["surname"];
		$newemail = $_POST["email"];
		$pwd = $_POST["password"];
		$phone = $_POST["phone"];
		$addressLine1 = $_POST["addressLine1"];
		$addressLine2 = $_POST["addressLine2"];
		$city = $_POST["city"];
		$postcode = $_POST["postcode"];
		
		// get session email
		$currentemail = $_SESSION["emailAddress"];
		
		// check if posted email == session email
		if ($newemail == $currentemail)
		{
			// update all customer details except email
			// where the session email is equal to the email field
			$upd = "UPDATE Customer SET firstName = '$firstName', lastName = '$surname', password = '$pwd', phoneNumber = '$phone', addressLine1 = '$addressLine1', addressLine2 = '$addressLine2', city = '$city', postcode = '$postcode' WHERE email = '$currentemail'";

			if (mysqli_query($conn, $upd))
			{
				    // display details updated message and image and redirect to welcome page
					echo "<div class=\"animsition\">";
		  			echo "<div class=\"appHeader\">";
		  			echo "<p id=\"headerText\">Details Updated!</p>";
		  			echo "</div>";
		  
		  			echo "<div class=\"signup-handler-area\">";
		  			echo "<img id=\"handler-image\" src=\"images/tick.png\" width=\"150\" height=\"150\">";
		  			echo "</div>";
				
					echo "<p id=\"responseText\">Redirecting to Welcome Page in 5 Seconds...";
				
					echo "<script>setTimeout(function(){window.location.href='welcome.php'},5000);</script>";
			}
		}
		else
		{		
			// otherwise, the customer is updating their email address
			// check if posted email exists in the database
			$sql = "SELECT email FROM Customer WHERE email='$newemail'";
	  		$res = mysqli_query($conn, $sql);
			
			// if email exists, display an error message and provide a back button to the edit details page
			if (mysqli_num_rows($res) > 0)
			{
				echo "<div class=\"animsition\">";
		  		echo "<div class=\"appHeader\">";
		  		echo "<p id=\"headerText\">Email Already Exists!</p>";
		  		echo "</div>";
		  
		  		echo "<div class=\"signup-handler-area\">";
		  		echo "<img id=\"handler-image\" src=\"images/error.png\" width=\"150\" height=\"150\">";
		  		echo "<a href=\"edit-account.php\" class=\"btn btn-lg btn-default animsition-link button homeButtons\" role=\"button\">Back</a>";
		  		echo "</div>";  
			}
			else
			{
				// otherwise, update customer details using the posted data
				$qry = "UPDATE Customer SET firstName = '$firstName', lastName = '$surname', email = '$newemail', password = '$pwd', phoneNumber = '$phone', addressLine1 = '$addressLine1', addressLine2 = '$addressLine2', city = '$city', postcode = '$postcode' WHERE email = '$currentemail'";

				// if the update worked
				if (mysqli_query($conn, $qry))
				{
					// set session email to the new email
					$_SESSION["emailAddress"] = $newemail;
			
					// display details updated message and image and redirect the user to the welcome page
					echo "<div class=\"animsition\">";
		  			echo "<div class=\"appHeader\">";
		  			echo "<p id=\"headerText\">Details Updated!</p>";
		  			echo "</div>";
		  
		  			echo "<div class=\"signup-handler-area\">";
		  			echo "<img id=\"handler-image\" src=\"images/tick.png\" width=\"150\" height=\"150\">";
		  			echo "</div>";
				
					echo "<p id=\"responseText\">Redirecting to Welcome Page in 5 Seconds...";
				
					echo "<script>setTimeout(function(){window.location.href='welcome.php'},5000);</script>";
				}
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
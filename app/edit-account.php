<?php
session_start();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Account</title>
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="css/animsition.min.css">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
  </head>
  <body id="sign-up-page">
	<script src="js/jquery-1.11.3.min.js"></script>
	
	<div class="animsition">
	
		<div class="appHeader">
			<p id="headerText">Edit Account Details</p>
		</div>
	
		<div class="back-button">
			<a href="my-account.html" id="back-button">
			<img src="images/back.png" height="50" width="50" alt="Back Button" class="img-rounded img-responsive"></a>
		</div>
		
		<div class="edit-area">
			<form action="edit-account-handler.php" method="post" role="form" data-toggle="validator">
			
				<?php
				
					$servername = "localhost";
	  				$username = "root";
	  				$password = "root";
	  				$dbname = "CouCou";
	  
	  				$conn = new mysqli($servername, $username, $password, $dbname);
				
					// get users email from session
				    $email = $_SESSION["emailAddress"];
				
					// run query to get the account details
				     $sql = "SELECT firstName, lastName, email, password,phoneNumber, addressLine1, addressLine2, city, postcode FROM Customer WHERE email='$email'";
					
				    $result = mysqli_query($conn, $sql);
				
				    // if account details exist for logged in user
				    if (mysqli_num_rows($result) > 0)
					{
						 while($row = mysqli_fetch_assoc($result)) {
							 
							 // create the form elements
							 // create the labels
							 // create input types and load the account data from the result of the query = e.g. firstName
							 
							 // load the first name
							 echo "<div class=\"form-group\">";
							 echo "<label for=\"firstName\">First Name</label>";
							 echo "<input type=\"text\" class=\"form-control\" id=\"firstName\" placeholder=\"First Name\" name=\"firstName\" pattern=\"^[A-z]{1,}$\" required value=\"";
							 echo $row["firstName"];
							 echo "\">";
							 echo "</div>";
							 
							 // load the surname
							 echo "<div class=\"form-group\">";
							 echo "<label for=\"surname\">Surname</label>";
							 echo "<input type=\"text\" class=\"form-control\" id=\"surname\" placeholder=\"Surname\" name=\"surname\" pattern=\"^[A-z]{1,}$\" required value=\"";
							 echo $row["lastName"];
							 echo "\">";
							 echo "</div>";
							 
							 // load the email
							 echo "<div class=\"form-group\">";
							 echo "<label for=\"email\">Email</label>";
							 echo "<input type=\"email\" class=\"form-control\" id=\"email\" placeholder=\"Email\" data-error=\"Invalid Email!\" name=\"email\" value=\"";
							 echo $row["email"];
							 echo "\">";
							 echo "<div class=\"help-block with-errors\"></div>";
							 echo "</div>";
							 
							 // load the password
							 echo "<div class=\"form-group\">";
							 echo "<label for=\"password\">Password</label>";
							 echo "<input type=\"password\" class=\"form-control\" id=\"password\" placeholder=\"Password\" name=\"password\" required value=\"";
							 echo $row["password"];
							 echo "\">";
							 echo "<div class=\"help-block with-errors\">Minimum of 6 characters</div>";
							 echo "</div>";
							 
							 // load the phone number
							 echo "<div class=\"form-group\">";
							 echo "<label for=\"phone\">Phone Number</label>";
							 echo "<input type=\"text\" class=\"form-control\" id=\"phone\" placeholder=\"Phone Number\" name=\"phone\" required value=\"";
							 echo $row["phoneNumber"];
							 echo "\">";
							 echo "</div>";
							 
							 // display the address header
							 echo "<div class=\"form-group\">";
							 echo "<label class=\"address-label\">Address</label>";
							 
							 // load address line 1
							 echo "<input type=\"text\" class=\"form-control\" id=\"addressLine1\" placeholder=\"Address Line 1\" name=\"addressLine1\" required value=\"";
							 echo $row["addressLine1"];
							 echo "\">";
							 
							 // load address line 2
							 echo "<input type=\"text\" class=\"form-control\" id=\"addressLine2\" placeholder=\"Address Line 2\" name=\"addressLine2\" value=\"";
							 echo $row["addressLine2"];
							 echo "\">";
							 
							 // load city
							 echo "<input type=\"text\" class=\"form-control\" id=\"city\" placeholder=\"City\" name=\"city\" required value=\"";
							 echo $row["city"];
							 echo "\">";
							 
							 // load postcode
							 echo "<input type=\"text\" class=\"form-control\" id=\"postcode\" placeholder=\"Postcode\" name=\"city\" required value=\"";
							 echo $row["postcode"];
							 echo "\">";
							 echo "</div>";
							 
							 // display submit button
							 echo "<div class=\"form-group\">";
							 echo "<button type=\"submit\" class=\"btn btn-lg btn-default button\" id=\"signup-button\">Save</button>";
							 echo "</div>";
						 }
					}
				?>
			</form>
		</div>
	</div>
	 	
	<script src="js/bootstrap.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.7/validator.min.js"></script>
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
<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order History</title>
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="css/animsition.min.css">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
  </head>
  <body>
	<script src="js/jquery-1.11.3.min.js"></script>
	
	<div class="animsition">
	
		<div class="appHeader">
			<p id="headerText">Order History</p>
		</div>
	
		<div class="back-button">
			<a href="my-account.html" id="back-button">
			<img src="images/back.png" height="50" width="50" alt="Back Button" class="img-rounded img-responsive"></a>
		</div>
		
		<div class="account-area">
			<form action="order-details.php" method="post">
		
		<?php

			// Display all orders by the customer
			// Use the email address of the customer to identify the customer ID
			// Create a button containing the order ID and the date of the order for each order
				
 			$servername = "localhost";
 			$username = "root";
 			$password = "root";
 			$dbname = "CouCou";
	  
 			$conn = new mysqli($servername, $username, $password, $dbname);

			// get the session email
			$email = $_SESSION["emailAddress"];
				
			$customerID = "";	
		    // get the customer id using the customer's email address
			$sql = "SELECT customerID FROM Customer WHERE email='$email'";
			$result = mysqli_query($conn, $sql);

 			if (mysqli_num_rows($result) > 0)
 			{
	 			while($row = mysqli_fetch_assoc($result))
	 			{
		 			// get the customer id
		 			$customerID = $row["customerID"];
	 			}
 			}
				
			// get the order dates of the orders made by the customer	
			$qry = "SELECT orderDate FROM Orders WHERE customerID = '$customerID'";
			$res = mysqli_query($conn, $qry);
			$orderDate = "";
			
			if (mysqli_num_rows($res) > 0)
 			{
	 			while($row = mysqli_fetch_assoc($res))
	 			{
					// get the order date
					$orderDate = $row["orderDate"];					
	 			}				
 			}
				
		    // get the order id as well as the order date of all the customer's orders
			$ord = "SELECT orderID, orderDate FROM Orders WHERE customerID = '$customerID' AND orderDate = '$orderDate'";
			$dta = mysqli_query($conn, $ord);
			
			if (mysqli_num_rows($dta) > 0)
 			{
	 			while($row = mysqli_fetch_assoc($dta))
	 			{
					// create buttons to represent the order id and the order date of all the customer's orders
					
					// create a date from the retrieved order date
					$date = date_create($row["orderDate"]);
					
					// create a button
					echo "<div class=\"form-group\">";					
					echo "<input type=\"submit\" class=\"btn btn-lg btn-default button accountButtons \" name=\"orderIDButton\" value=\"";
					
					// display the text "Order" followed by a space in the button
					echo "Order ";
					
					// use the retrieved order id to display the order id in the button
					echo $row["orderID"];
					
					// concatenate a : symbol after the order id
					echo ":";
					
					// add a space
					echo " ";
					
					// using the created date to format it to to represent a full date
					echo date_format($date,"l j F Y");				
					
					echo "\"";
					echo ">";
					echo "</div>";
				}
			}
		?>
			</form>
	</div>
	</div>

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
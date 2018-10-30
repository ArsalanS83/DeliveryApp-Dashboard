<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Review History & Responses</title>
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="css/animsition.min.css">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
  </head>
  <body>
	<script src="js/jquery-1.11.3.min.js"></script>
	
	<div class="animsition">
	
		<div class="appHeader">
			<p id="headerText"> Review History & Responses</p>
		</div>
	
		<div class="back-button">
			<a href="welcome.php" id="back-button">
			<img src="images/back.png" height="50" width="50" alt="Back Button" class="img-rounded img-responsive"></a>
		</div>
		
		<div class="account-area">
			<form action="review-details.php" id="review-area" method="post">
		
		<?php
				
			// Display all orders which have been reviewed
			// Display a button for each reviewed order containing the order id and the date

 			$servername = "localhost";
 			$username = "root";
 			$password = "root";
 			$dbname = "CouCou";
	  
 			$conn = new mysqli($servername, $username, $password, $dbname);

			// get the session email
			$email = $_SESSION["emailAddress"];
				
			$customerID = "";
			
		    // get the customer id based on the customer's email address
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
				
		    // get all the customer's orders which contain reviewed items
			$qry = "SELECT Orders.orderDate, Orders.orderID FROM Orders INNER JOIN Review ON Orders.orderID = Review.orderID WHERE Orders.customerID = '$customerID' AND Review.rating IS NOT NULL GROUP BY Orders.orderID";
			$res = mysqli_query($conn, $qry);
			
			if (mysqli_num_rows($res) > 0)
 			{
	 			while($row = mysqli_fetch_assoc($res))
	 			{
					// create a date from the retrieved date
					$date = date_create($row["orderDate"]);
					
					// create buttons representing the order id of each order
					// display the date of that order on the button
											
					echo "<div class=\"form-group\">";			
					
					// create the button			
					echo "<input type=\"submit\" class=\"btn btn-lg btn-default button accountButtons \" name=\"orderIDButton\" value=\"";
					
					// display the string "Order" followed by a space on the button's text
					echo "Order ";
					
					// display the order id string on the button's text
					echo $row["orderID"];
					
					// create a colon to separate the order id string
					echo ":";
					
					// create a space
					echo " ";
					
					// format the date using the retrieved date in order to display a full date string on the button's text
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
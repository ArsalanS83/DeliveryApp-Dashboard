<?php
session_start()
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Write Review</title>
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="css/animsition.min.css">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/fontawesome-stars.css">
  </head>
  <body>
	<script src="js/jquery-1.11.3.min.js"></script>
	
	<div class="animsition">
	
		<div class="appHeader">
			<p id="headerText">Write Review</p>
		</div>
	
		<div class="back-button">
			<a href="welcome.php" id="back-button">
			<img src="images/back.png" height="50" width="50" alt="Back Button" class="img-rounded img-responsive"></a>
		</div>
		
		<p id="orderDate">
		
		<?php
	
			// Display date of the latest order by the customer, where the order has no reviews
			
			$servername = "localhost";
			$username = "root";
			$password = "root";
			$dbname = "CouCou";
						   
			$conn = new mysqli($servername, $username, $password, $dbname);

			// get the session email
    		$email = $_SESSION["emailAddress"];

			$customerID = "";

			// get the customer id using the customer's email address
    		$sql = "SELECT customerID FROM Customer WHERE email = '$email'";

    		$result = mysqli_query($conn, $sql);

    		if (mysqli_num_rows($result) > 0)
			{
				while($row = mysqli_fetch_assoc($result))
				{
					// get the customer id
					$customerID = $row["customerID"];
				}
			}

			// get the latest order that consists of items that have not been reviewed
			$qry = "SELECT MAX(Orders.orderDate) FROM Orders INNER JOIN Review ON Review.orderID = Orders.orderID WHERE rating IS NULL";

			$res = mysqli_query($conn, $qry);

            if (mysqli_num_rows($res) > 0)
			{
				while($row = mysqli_fetch_assoc($res))
				{
					// display the order date of the retrieved latest order
					// create a date from the retrieved date of the latest order
					// format the date in order to display a full date
					echo "Order Date: ";
					$date = date_create($row["MAX(Orders.orderDate)"]);
					echo date_format($date,"l j F Y");
				}
			}
			else
			{
				echo "error";
			}
		?>
			
		</p>
		
		<div class="review-item-area">
			<form action="review-submitted.php" method="post" role="form" data-toggle="validator">
			
			<?php
				
				// Display each menu item ordered for the latest order which has not been reviewed
				// Display a star rating option for each item
				// Display a review description text area for each item to be reviewed
				
				$servername = "localhost";
				$username = "root";
				$password = "root";
				$dbname = "CouCou";
						   
				$conn = new mysqli($servername, $username, $password, $dbname);
				
				// get session email
				$email = $_SESSION["emailAddress"];
				
				$customerID = "";

				// get the customer id using the customer's email address
    			$sql = "SELECT customerID FROM Customer WHERE email = '$email'";

    			$result = mysqli_query($conn, $sql);

    			if (mysqli_num_rows($result) > 0)
				{
					while($row = mysqli_fetch_assoc($result))
					{
						// get the customer id
						$customerID = $row["customerID"];
					}
				}

				// get the order id of the customer's latest order from the Review table using the customer's customer id			
				$qry = "SELECT MAX(orderID) FROM Review WHERE customerID = '$customerID'";
				
				$res = mysqli_query($conn, $qry);
				
    			if (mysqli_num_rows($res) > 0)
				{
					while($row = mysqli_fetch_assoc($res))
					{
						// get the order id of the customer's latest order
						$orderID = $row["MAX(orderID)"]; 
						
						// store the order id of the customer's latest order in a session array
						$_SESSION["currentOrderID"] = $orderID;
						
						// store the names of the unreviewed items for that order in a session array
						$_SESSION["reviewItemNames"] = array();
						
						// initialise an index in order to display multiple star rating options per menu item to be reviewed
						// this is because this index value is to be used as an id for the star rating option
						// this is also because the value of the id for the star rating option must be unique
						$index = 0;
						
						// get the names of those unreviewed menu items from the customer's latest order							
						$dta = "SELECT MenuItem.itemName FROM MenuItem INNER JOIN Review ON MenuItem.itemID = Review.itemID WHERE orderID = '$orderID' AND rating IS NULL";
				
						$ans = mysqli_query($conn, $dta);
						
						if (mysqli_num_rows($ans) > 0)
						{
							while($row = mysqli_fetch_assoc($ans))
							{
								// get the name of the unreviewed menu item
								$itemName = $row["itemName"];
								
								// store the name of the unreviewed menu item in a session array for later use
								$_SESSION["reviewItemNames"][$index] = $row["itemName"];
								
								// display the name of the menu item to be reviewed
								// display a star rating option for the menu item from 1-5
								echo "<div class=\"form-group\">";
								echo "<label for=\"rating\">";
								echo $row["itemName"];
								echo "</label>";
								echo "<select id=\"$index\" class=\"form-control\"";
								echo "name=\"itemRating[]\" required>";
								echo "<option value=\"\"></option>";
								echo "<option value=\"1\">1</option>";
								echo "<option value=\"2\">2</option>";
							    echo "<option value=\"3\">3</option>";
								echo "<option value=\"4\">4</option>";
								echo "<option value=\"5\">5</option>";
							    echo "</select>";
							    echo "</div>";
								
								// increment the index in order to display another star rating option for another menu item
								// this is because their may be more than one menu item that is ordered
								// this is also because the id for the star rating option must be unique
								$index++;
						
								// create a review description text area for the item
								echo "<div class=\"form-group\">";
								echo "<label for \"review\">Review Description</label>";
								echo "<textarea class=\"form-control\" rows=\"3\" id=\"reviewDescription\" name=\"reviewDescription[]\" required></textarea>";
								echo "</div>";
							}
						
							// create a submit button to allow the customer to submit their menu item reviews for the order
							echo "<div class=\"form-group\">";
							echo "<button type=\"submit\" class=\"btn btn-lg btn-default button\" id=\"signup-button\">Submit Review</button>";
							echo "</div>";
							echo "</form>";
						}
					}
				}
			?>
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
	  
	  <script src="js/jquery.barrating.min.js"></script>
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.js"></script>
	  <script type="text/javascript">
			$(function() {
				
				var myNodelist = document.getElementsByTagName("select");
				
				var i;
				
				for (i = 0; i<myNodelist.length; i++)
				{
					var theID = myNodelist[i].id;
					
					$('#'+theID).barrating({
						theme: 'fontawesome-stars'
					});
				}
			});
	  </script>
  </body>
</html>
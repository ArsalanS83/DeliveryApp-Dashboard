<?php
session_start()
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Review Responses</title>
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
			<p id="headerText">Review Responses</p>
		</div>
	
		<div class="back-button">
			<a href="review-history-responses.php" id="back-button">
			<img src="images/back.png" height="50" width="50" alt="Back Button" class="img-rounded img-responsive"></a>
		</div>
		
		<p id="orderDate">
		
		<?php
			
			// Display each menu item, its rating and the review text by the customer
			// for the selected reviewed order determined by the button selected
			// Display the staff response for the review of the item, even if no staff response
				
			$servername = "localhost";
			$username = "root";
			$password = "root";
			$dbname = "CouCou";
						   
			$conn = new mysqli($servername, $username, $password, $dbname);

			// get the session emai laddress
    		$email = $_SESSION["emailAddress"];

			$customerID = "";

			// get the customer id based on the customer's email address
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

			// get the selected order button 
            $theOrderID = $_POST['orderIDButton'];

			// extract the order id string from the selected button's text
			$string = substr($theOrderID,6,2);

			// remove the colon separating the order id from the review date
			$FinalOrderID = trim($string,":");

			// get the date of the selected order based on the extracted order id
			$qry = "SELECT orderDate FROM Orders WHERE orderID = '$FinalOrderID'";

			$res = mysqli_query($conn, $qry);

            if (mysqli_num_rows($res) > 0)
			{
				while($row = mysqli_fetch_assoc($res))
				{
					// display the order date using the retrieved date
					// display the date in full after formatting it
					echo "Order Date: ";
					$date = date_create($row["orderDate"]);
					echo date_format($date,"l j F Y");
				}
			}
		?>
			
		</p>
		
		<div class="review-item-area">
			<form>
			
			<?php
				
				$servername = "localhost";
				$username = "root";
				$password = "root";
				$dbname = "CouCou";
						   
				$conn = new mysqli($servername, $username, $password, $dbname);
				
				// get the selected order button			
				$orderIDText = $_POST['orderIDButton'];
				
				// extract the order id string from the selected button's text
				$theString = substr($orderIDText,6,2);
				
				// remove the colon separating the order id from the review date
				$orderID = trim($theString,":");
				
				// get each menu item that has been reviewed
				// obtain the menu item's star rating, review description and staff response if available
				$qry = "SELECT MenuItem.itemName, Review.rating, Review.description, Review.staffResponse FROM MenuItem INNER JOIN Review ON MenuItem.itemID = Review.itemID WHERE orderID = '$orderID'";

    			$res= mysqli_query($conn, $qry);
				
				// index number used as the id value for the star rating reviewer
				$index = 0;
				
				if (mysqli_num_rows($res) > 0)
				{
					while($row = mysqli_fetch_assoc($res))
					{
						
						// display the name of the menu item that was reviewed
						echo "<div class=\"form-group\">";
						echo "<label for=\"rating\">";
						echo $row["itemName"];
						echo "</label>";
						
						// display the star rating for that menu item
						echo "<select id=\"$index\" class=\"form-control\"";
						echo "name=\"itemRating[]\" required>";
						echo "<option value=\"";
						echo $row["rating"];
						echo "\"";
						echo "</option>";
						echo "<option>";
						echo "2";
						echo "</option>";
						echo "<option>";
						echo "3";
						echo "</option>";
						echo "<option>";
						echo "4";
						echo "</option>";
						echo "<option>";
						echo "5";
						echo "</option>";
						echo "</select>";
						echo "</div>";
						
						// increment the index to use for the id of the review selector
						// this is because their may be more than 1 item in the order and a unique id is required for each rating reviewer
						$index++;
						
						// display the review description for this menu item
						echo "<div class=\"form-group\">";
						echo "<label for \"review\">Review Description</label>";
						echo "<textarea class=\"form-control\" rows=\"3\" id=\"reviewDescription\" readonly>";
	
						echo $row["description"];
						
						echo "</textarea>";
						echo "</div>";
						
						// display the staff response for the review of this menu item, if available
						echo "<div class=\"form-group\">";
						echo "<label for \"review\">Staff Response</label>";
						echo "<textarea class=\"form-control\" rows=\"3\" id=\"reviewDescription\" readonly>";
						
						echo $row["staffResponse"];
						
						echo "</textarea>";
						echo "</div>";
						
						echo "<hr>";
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
						theme: 'fontawesome-stars',
						readonly: true
					});
				}
			});
	  </script>	  
  </body>
</html>
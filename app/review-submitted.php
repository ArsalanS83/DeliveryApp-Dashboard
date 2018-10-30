<?php
session_start();
?>

<?php

// Get the item name, star rating and review description 
// For each item reviewed, insert each reviewed item in the review table in the database

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "CouCou";
						   
$conn = new mysqli($servername, $username, $password, $dbname);
								
// get the ratings of all menu items that were reviewed
$ratings = $_POST['itemRating'];

// get the review descriptions of all menu items that were reviewed
$descriptions = $_POST['reviewDescription'];

// get the order id that those menu items belong to
$orderID = $_SESSION["currentOrderID"];

// get the names of the  reviewed items
$itemNames = $_SESSION["reviewItemNames"];

// get a count of how many menu item's were reviewed by the customer
$size = count($itemNames);

// for each of the menu item's that were reviewed
for ($x = 0; $x <= $size; $x++)
{
	// get the rating of the menu item
	$itemRating = $ratings[$x];
	
	// get the review description of the menu item
	$reviewDescription = $descriptions[$x];
	
	// get the name of the menu item
	$theItem = $itemNames[$x];
	
	$theItemID = "";
	
	// get the id of the menu item using the menu item's name
	$qry = "SELECT itemID FROM MenuItem WHERE itemName = '$theItem'";
			
	$result= mysqli_query($conn, $qry);
			
	if (mysqli_num_rows($result) > 0)
	{
		while($row = mysqli_fetch_assoc($result))
		{
			// get the item id
			$theItemID = $row["itemID"];	
		}
		
		// update the review rating and review description of the menu item for the order
		$sql = "UPDATE Review SET rating = '$itemRating', description= '$reviewDescription' WHERE orderID = '$orderID' AND itemID = '$theItemID'";
		
		if (mysqli_query($conn, $sql))
		{
			
		}
		else
		{
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}
} 
?>

<html>
	<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Review Submitted</title>
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="css/animsition.min.css">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
	</head>
	
	<body>
	
	<script src="js/jquery-1.11.3.min.js"></script>

	<div class="animsition">
		<div class="appHeader">
	     	<p id="headerText">Review Submitted</p>
	     </div>
		  
		<div class="signup-handler-area">
	     	<img id="handler-image" src="images/tick.png" width="150" height="150">
	     	<a href="welcome.php" class="btn btn-lg btn-default animsition-link button homeButtons" role="button">Home</a>
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
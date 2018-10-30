<?php
session_start();
?>

<?php

 $servername = "localhost";
 $username = "root";
 $password = "root";
 $dbname = "CouCou";
	  
 $conn = new mysqli($servername, $username, $password, $dbname);

 // get the data to insert into the order
 // including the session email
 $email = $_SESSION["emailAddress"];
 $customerID = "";
 $date = date("Y-m-d");
 $time = date("h:i:s");
 $orderType = $_POST["orderType"];
 $requirements = $_POST["additionalRequirements"];
 $points = $_POST["currentPoints"];
 $gained = $_POST["pointsGained"];

 // Get the customer id using the customer's email address stored in the session variable
 $sql = "SELECT customerID FROM Customer WHERE email='$email'";
 $result = mysqli_query($conn, $sql);

 if (mysqli_num_rows($result) > 0)
 {
	 while($row = mysqli_fetch_assoc($result))
	 {
		 // get the customer id
		 $customerID = $row["customerID"];
	 }
	 	 
	 // get the integer values of the user's current points and the points gained after the order
	 $thePoints = intval($points);
	 $thePointsGained = intval($gained);
	 
	 // set the user's new points by adding the points gained the user's current points
	 $newPoints = $thePoints + $thePointsGained;
	 
	 // obtain the string value of the user's new points
	 $newPointsBalance = strval($newPoints);
	 
	 // insert the customer's new loyalty points into the database
	 $pts = "UPDATE Customer SET loyaltyPoints = '$newPointsBalance' WHERE customerID = '$customerID'";
	 
	 if (mysqli_query($conn, $pts))
	 {
		 
	 }
	 else
	 {
		 
	 }
	 
	// insert the order data into the database
	$qry = "INSERT INTO Orders (customerID, orderDate, orderTime, orderType, additionalRequirements) VALUES ('$customerID','$date','$time','$orderType','$requirements')";

 	if (mysqli_query($conn, $qry))
 	{
	 
	}
 	else
 	{
	 	echo "Error: " . $qry . "<br>" . mysqli_error($conn);
 	}
	 
	// get the user's cart items
	$addedItems = $_SESSION["addedItems"];
	 
	// Get each item from the array of cart items
	// get the id of the item name
	// get the id of the selected extra, if selected
	// get the size id of the selected size
	// get the quantity of the item
	 
	// insert all items into the OrderItems table in the database
	// insert all items into Review table with null ratings, description, staffID and staffResponses 
	 
	foreach ($addedItems as $value)
	{
		$itemID = "";
	    $extraID = NULL;
	    $sizeID ="";
	    $itemQuantity = "";
		
		// get the item id
		$abc = "SELECT itemID FROM MenuItem WHERE itemName = '$value[0]'";
		$res= mysqli_query($conn, $abc);
		
		if (mysqli_num_rows($res) > 0)
		{
			while($row = mysqli_fetch_assoc($res))
			{
				$itemID = $row["itemID"];				
			}
		}
		
		// get the extra id
		$def = "SELECT ingredientID FROM Ingredient WHERE ingredientName = '$value[1]'";
		$ans= mysqli_query($conn, $def);
		
		if (mysqli_num_rows($ans) > 0)
		{
			while($row = mysqli_fetch_assoc($ans))
			{
				$extraID = $row["ingredientID"];				
			}
		}
		else
		{
			
		}
		
	   // get the size id
	   $ghi = "SELECT sizeID FROM MenuItemSize WHERE sizeInfo = '$value[2]'";
	   $dta = mysqli_query($conn, $ghi);
		
	   if (mysqli_num_rows($dta) > 0)
	   {
		   while($row = mysqli_fetch_assoc($dta))
		   {
			   $sizeID = $row["sizeID"];				
		   }
	   }
		
	   // get the quantity that the user ordered for that menu item
	   $itemQuantity = $value[4];
		
	   // get the order ID of the last inserted order
	   // this will always be the highest orderID
		
	   $jkl = "SELECT MAX(orderID) FROM Orders";
	   $theID = mysqli_query($conn, $jkl);
		
	   if (mysqli_num_rows($theID) > 0)
	   {
		   while($row = mysqli_fetch_assoc($theID))
		   {
			   $orderID= $row["MAX(orderID)"];				
		   }
	   }
		
	   // if extra id is an empty string then don't insert the extra id
	   // if the extra id is not an empty string then insert the extra id
	   // if the extra id is an empty string it means the customer has not selected any extra's for this menu item
	   // if the extra id is not an empty string it means the customer has selected an extra for thie menu item 
		
	   if ($extraID == "")
	   {
		   $ins = "INSERT INTO OrderItems (orderID,itemID, sizeID,itemQuantity) VALUES ('$orderID','$itemID','$sizeID','$itemQuantity')";
			
		   if (mysqli_query($conn, $ins))
		   {
			   
		   }
		   else
		   {
			   echo "Error: " . $ins . "<br>" . mysqli_error($conn);
		   }	
	   }
	   else
	   {
		   $ins = "INSERT INTO OrderItems (orderID,itemID, sizeID, extraID,itemQuantity) VALUES ('$orderID','$itemID','$sizeID','$extraID','$itemQuantity')";
			
		   if (mysqli_query($conn, $ins))
		   {
			   
		   }
		   else
		   {
			   echo "Error: " . $ins . "<br>" . mysqli_error($conn);
		   }
	   }
		
	   // insert into review table: orderiD, customerID and itemID
	   // the ratings, staff id's and staff responses for these items are left blank for now
	   // this is because the customer has to review the items before this information is manipulated.
	   // this is also because the staff have to respond to these reviews first before this information is manipulated
		
	   $rev = "INSERT INTO Review (orderID,customerID,itemID) VALUES ('$orderID','$customerID','$itemID')";
		
	   if (mysqli_query($conn, $rev))
	   {
		   
	   }
	   else
	   {
		   echo "Error: " . $ins . "<br>" . mysqli_error($conn);
	   }	
	}
 }
?>

<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Order Confirmed</title>
		<link href="css/bootstrap.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="css/animsition.min.css">
		<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
	</head>

	<body>
	<script src="js/jquery-1.11.3.min.js"></script>
	
	<div class="animsition">
		
			<div class="appHeader">
				<p id="headerText">Order Confirmed!</p>
		    </div>
		    
		    <div class="back-button">
				<a href="welcome.php" id="back-button">
				<img src="images/back.png" height="50" width="50" alt="Back Button" class="img-rounded img-responsive"></a>
			</div>
			
			<div class="signup-handler-area">
				<img id="handler-image" src="images/tick.png" width="150" height="150">
		    </div>
		    
		    <a href="live-track.php" class="btn btn-lg btn-default button" id="track">Live Track Order</a>	
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
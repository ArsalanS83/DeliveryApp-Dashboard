<?php
session_start();
?>

<?php

	// Identify the index of the item to remove using the session array representing the menu item's details
	$itemPosition = array_search($_SESSION["itemName"], $_SESSION["addedItems"]);

	// Remove the item from the order cart and re-index the session array representing the user's order cart
    unset($_SESSION["addedItems"][$itemPosition]);
?>
		  	
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Menu Item Removed</title>
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="css/animsition.min.css">
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
</head>

<body>
	<script src="js/jquery-1.11.3.min.js"></script>

	<div class="animsition">
		<div class="appHeader">
	     	<p id="headerText">Item Removed From Order!</p>
	     </div>
		  
		<div class="signup-handler-area">
	     	<img id="handler-image" src="images/tick.png" width="150" height="150">
	     	<a href="menu.html" class="btn btn-lg btn-default animsition-link button homeButtons" role="button">Menu</a>
	     	<a href="confirm-order.php" class="btn btn-lg btn-default animsition-link button homeButtons" role="button">Go To Cart</a>
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
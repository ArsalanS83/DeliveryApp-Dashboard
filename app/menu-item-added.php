<?php
session_start();
?>

<?php
	
	// Get the selected menu item's data
	$extra = $_POST["toppings"];
	$size = $_POST["size"];
	$price = $_POST["price"];
	$quantity = $_POST["quantity"];

    // Create an array representing the menu item's data and store it in a session		
	$_SESSION["itemName"] = array($_SESSION["itemName"],$extra,$size,$price,$quantity);
	
    // obtain the session array representing the logged in user's order cart
    $newarray = $_SESSION["addedItems"];

    // insert that menu item array into the array representing the cart items
    $newarray[count($newarray)+1] = $_SESSION["itemName"];		
	$_SESSION["addedItems"] = $newarray;
?>
		  
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Menu Item Added</title>
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="css/animsition.min.css">
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
</head>

<body>
	<script src="js/jquery-1.11.3.min.js"></script>

	<div class="animsition">
		<div class="appHeader">
	     	<p id="headerText">Item Added to Order!</p>
	     </div>
		  
		<div class="signup-handler-area">
	     	<img id="handler-image" src="images/tick.png" width="150" height="150">
	     	<a href="menu.html" class="btn btn-lg btn-default animsition-link button homeButtons" role="button">Menu</a>
	     	<a href="confirm-order.php" class="btn btn-lg btn-default animsition-link button homeButtons" role="button">Go To Cart</a>
	     	<a href="menu-item-removed.php" class="btn btn-lg btn-default animsition-link button homeButtons" role="button">Remove Item</a>
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
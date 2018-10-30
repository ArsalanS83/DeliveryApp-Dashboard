<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
  	<meta charset="UTF-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<title>Menu</title>
  	<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
  	<link href="css/style.css" rel="stylesheet" type="text/css">
  	<link rel="stylesheet" href="css/animsition.min.css">
  	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
  </head>
  <body>
  	<script src="js/jquery-1.11.3.min.js"></script>
  	
  	<div class="animsition">
		<div class="appHeader">
			<p id="headerText">
			
			<?php
	  
	  		// if a button is clicked to access a category menu
			// print out its name
	  		if ( isset( $_POST['menuItem'] ) )
	  		{
				echo $_POST['menuItem'];
			}
	 
			?>

			</p>
		</div>
	
		<div class="back-button">
 			<a href="menu.html" id="back-button"><img src="images/back.png" height="50" width="50" alt="Back Button" class="img-rounded img-responsive"></a>
 		</div>
 		
 		<div class="cart-button">
			<a href="confirm-order.php">
			<img src="images/cart.png" id="cart" height="50" width="50" alt="Back Button" class="img-rounded img-responsive"></a>
		</div>
 		
 		<div class="list-wrapper">
      		<div class="list-container">
        		<div class="list-body-container">
            		<ul id="list-0" class="list-0 active-list">
            			<li class="list-0-item">
              			
              			<?php
							
							// Display all items from the selected category of items
							// Check if a particular item is already in the cart
							// If so then do not display it
							// If not then display it
							
							$servername = "localhost";
 							$username = "root";
 							$password = "root";
 							$dbname = "CouCou";
	  
 							// Create connection		
 							$conn = new mysqli($servername, $username, $password, $dbname);
							
							// get the selected category name
							$itemName = $_POST['menuItem'];
							
							// extract all menu items from the chosen category
							$sql = "SELECT * FROM MenuItem WHERE itemCategory='$itemName'";

 							$result = mysqli_query($conn, $sql);
							
							if (mysqli_num_rows($result) > 0)
							{
								$index = 1;
								
	 							while($row = mysqli_fetch_assoc($result))
								{
									// retrieve shopping cart
									$addedItems = $_SESSION["addedItems"];
									
									// check if shopping cart is empty
									if (empty($addedItems))
									{
										// display the menu item and it's link
										echo "<a href=\"menu-item.php?itemName=";
										echo $row["itemName"];
										echo "\"";
									
										echo "class=\"list-link\"><span class=\"list-link-label\">". $row["itemName"]. "</span><span class=\"right-arrow\">&gt;</span></a>";
									}
									else
									{
										// fetch the current menu item from the cart
										$itemDetails = $addedItems[$index];
										
										// get the size of the shopping cart
										$arraySize = count($addedItems);
										
										// only display the menu item link if it does not exist in the shopping cart
										// and we are not at the end of the shopping cart
										if ($itemDetails[0] != $row["itemName"] && $index <= $arraySize)
										{
											echo "<a href=\"menu-item.php?itemName=";
											echo $row["itemName"];
											echo "\"";
									
											echo "class=\"list-link\"><span class=\"list-link-label\">". $row["itemName"]. "</span><span class=\"right-arrow\">&gt;</span></a>";
										}
										else
										{
											// if we still have more items to search
											// carry on searching those items in the cart
											if ($arraySize > $index)
											{
												$index++;
											}
										}
									}
								}							
							}
						?>
              			</li> 
					</ul>
				</div>
			</div>
		</div> 
	  </div>

	<script src="js/bootstrap.js"></script>
  	<script src="js/animsition.min.js"></script>
  	<script>
	  $(document).ready(function() {
		  $(".animsition").animsition({
			  inClass: 'fade-in-right',
			  outClass: 'fade-out-right',
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
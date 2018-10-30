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
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="css/animsition.min.css">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
  </head>
  <body onload="setPrice();">
  	<script src="js/jquery-1.11.3.min.js"></script>
	
	<div class="animsition">
		<div class="appHeader">
			<p id="headerText">
			
			<?php
				
				$servername = "localhost";
 				$username = "root";
 				$password = "root";
 				$dbname = "CouCou";
	  	
 				$conn = new mysqli($servername, $username, $password, $dbname);
				
				// get the selected menu item name
				$selectedItem = $_GET['itemName'];
				
				// store this menu item name in a session variable for later use
				$_SESSION["itemName"] = $_GET['itemName'];
			
				// Get the name of the menu item selected and display it
				$sql = "SELECT itemName FROM MenuItem WHERE itemName='$selectedItem'";
				
				$result = mysqli_query($conn, $sql);
							
				if (mysqli_num_rows($result) > 0)
				{
					// display the menu item name
					echo $selectedItem;
				}
				
				mysqli_close($conn);
			?>
			</p>
		</div>
	
		<div class="back-button">
			<a href="menu.html" id="back-button">
			<img src="images/back.png" height="50" width="50" alt="Back Button" class="img-rounded img-responsive"></a>
		</div>
		
		<div class="cart-button">
			<a href="confirm-order.php">
			<img src="images/cart.png" id="cart" height="50" width="50" alt="Back Button" class="img-rounded img-responsive"></a>
		</div>
		
	  <div class="item-image">
			<img id="menu-item-image"
			
			<?php
				 
				$servername = "localhost";
 				$username = "root";
 				$password = "root";
 				$dbname = "CouCou";
	  	
 				$conn = new mysqli($servername, $username, $password, $dbname);
				 
				// get the selected menu item name
				$selectedItem = $_GET['itemName'];
				 
				// Get the name of the menu item selected
				$sql = "SELECT itemName FROM MenuItem WHERE itemName='$selectedItem'";
				 
				$result = mysqli_query($conn, $sql);
				 
				if (mysqli_num_rows($result) > 0)
				{
					// Get the relevant image for the menu item selected
					echo "src=\"images/";
					echo $selectedItem;
					echo ".jpg";
					echo "\"";
				}
				 
				mysqli_close($conn);
			?>
			
			alt="Menu Item" width="300" class="img-rounded img-responsive">
	   </div>

		<div class="area">
		
		  <form class="menu-item-price" action="menu-item-added.php" method="post">
 		  	
  		  	<div class="form-group">
	  		  <label for="ingredients">Ingredients</label>
	  		  
	  		  <?php 
				
				$servername = "localhost"; 
				$username = "root"; 
				$password = "root"; 
				$dbname = "CouCou";
				
				$conn = new mysqli($servername, $username, $password, $dbname);
				
				// get the selected menu item name
				$selectedItem = $_GET['itemName']; 
				
				// get the ingredient's for the selected menu item
				$sql = "SELECT ingredientName FROM MenuItemRequirement WHERE itemName='$selectedItem'"; 

				$result = mysqli_query($conn, $sql);
				
				if (mysqli_num_rows($result) > 0)
				{ 
					echo "<br>";
					echo "<br>";
					while($row = mysqli_fetch_assoc($result))
					{
						// display the ingredients of the selected menu item
						echo "<p id=\"ingredientName\">";
						echo $row["ingredientName"]; 
						echo "</p>";
					}
					
					echo "<br>";
				}
				
				mysqli_close($conn);

               ?> 
		  	</div>
 		  	
	  		  <?php 
				
				$servername = "localhost"; 
				$username = "root"; 
				$password = "root"; 
				$dbname = "CouCou";
			  
				$conn = new mysqli($servername, $username, $password, $dbname);
				 
			    // get the selected menu item name
				$selectedItem = $_GET['itemName']; 
				
			    // get the category of the selected menu item
				$qry = "SELECT itemCategory FROM MenuItem WHERE itemName='$selectedItem'";
				  
				$ans = mysqli_query($conn, $qry);
				  
				if (mysqli_num_rows($ans) > 0)
				{
					while($b = mysqli_fetch_assoc($ans))
					{
						// if the menu item's category is a pizza or burger
						if ($b["itemCategory"] === "Pizza" or $b["itemCategory"] === "Burger" )
						{
							// display the extra's heading and initialise a list of extra options
							echo "<div class=\"form-group\">";
							echo "<label for=\"toppings\">Extras</label>";
							echo "<select id=\"toppings\" class=\"form-control\" name=\"toppings\" onchange=\"changePrice()\">";
							echo "<option id=\"item-dropdown\">No Extras Selected</option>";
						
						    // populate the possible extra options for the selected menu item
							// ensure the ingredients obtained have an extra charge to ensure they are possible extra options
							// this is because not all ingredients are possible extra options
							$sql = "SELECT ingredientName FROM Ingredient WHERE extraPrice IS NOT NULL"; 

							$result = mysqli_query($conn, $sql);
				
							if (mysqli_num_rows($result) > 0)
							{ 
								while($r = mysqli_fetch_assoc($result))
								{
									// populate all the possible extra options for the selected menu item
									echo "<option id=\"item-dropdown\">";
									echo $r["ingredientName"];
									echo "</option>";
								}
							}
							echo "</select>";
							echo "</div>";
							
							mysqli_close($conn);
						}
					}
				}
               ?> 
	  		  	
			   <?php 
			  
				$servername = "localhost"; 
				$username = "root"; 
				$password = "root"; 
				$dbname = "CouCou";
			  
				$conn = new mysqli($servername, $username, $password, $dbname);
			  				
			    // get the selected menu item name
				$selectedItem = $_GET['itemName']; 
			  
			    // get the possible sizes of the selected menu item based on the category of the selected item
			    $sql = "SELECT sizeInfo FROM MenuItemSize WHERE sizeCategory = (SELECT itemCategory FROM MenuItem WHERE itemName = '$selectedItem')";
			  
			    $result = mysqli_query($conn, $sql);
			  
			    if (mysqli_num_rows($result) > 0)
				{
					// display the size heading and initialise a list of size options
					echo "<div class=\"form-group\">";
					echo "<label for=\"size\">Size</label>";
					echo "<select class=\"form-control\" id=\"size\" name=\"size\" onchange=\"changePrice()\">";
					
					while($row = mysqli_fetch_assoc($result))
					{
						// populate and display the size options for the selected menu item
						echo "<option id=\"item-dropdown\">";
						echo $row["sizeInfo"];
						echo "</option>";
					}
					
					echo "</select>";
					echo "</div>";
				}
			   ?>
			  
		  	<div class="form-group">
	  		  <label for="price">Price</label>
	  		  
			  <?php 
				
				$servername = "localhost"; 
				$username = "root"; 
				$password = "root"; 
				$dbname = "CouCou";
				
				$conn = new mysqli($servername, $username, $password, $dbname);
								
				// get the selected menu item name
				$selectedItem = $_GET['itemName']; 
				
				// get the price of the selected menu item
				$sql = "SELECT price FROM MenuItem WHERE itemName='$selectedItem'"; 

				$result = mysqli_query($conn, $sql);
				
				if (mysqli_num_rows($result) > 0)
				{ 
					while($row = mysqli_fetch_assoc($result))
					{
						// display the price of the selected menu item
						echo "<input type=\"text\" name=\"price\" id=\"price\" class=\"form-control\" readonly value=\"";
						echo $row["price"]; 
						echo "\"";
						echo ">";
					}
				}
				
				mysqli_close($conn);

               ?> 
	  		  
		  	</div>
		  	
		  	<div class="form-group">
	  		  <label for="quantity">Quantity</label>
   			  <input type="number" class="form-control" id="quantity" name="quantity" value=1 readonly>
		  	</div>
		  	
		  	<div class="quantity-area">
		  		<img id="plus" src="images/plus.png" alt="Menu Item" width="50" class="img-rounded img-responsive" onClick="increment()">
		 		<img id="minus" src="images/minus.png" alt="Menu Item" width="50" class="img-rounded img-responsive" onClick="decrement()">
		  	</div>
		  	
		  	<div class="form-group">
 				<input type="submit" class="btn btn-lg btn-default button" id="signup-button" name="addItem" value="Add to Order">
			</div>
		  </form>
		</div>
	</div>
	
	<script>
		
		// Increment the quantity of the menu item
		// Which also increments the price of the item by multiplying it by 2
		function increment()
		{
			// increase the quantity text
			document.getElementById("quantity").stepUp(1);
			
			// get the price of the menu item
			var price = document.getElementById("price").value;
			
			// get the price without the currency symbol as a string
			var rawPrice = price.slice(1, 10);
			
			// get the value of the price as a float
			var thePrice = parseFloat(rawPrice);
			
			// multiply the price by 2
			var newPrice = thePrice*2;
			
			// set the value of the new price 
			var latest = newPrice.toFixed(2);
			document.getElementById("price").value = "£"+latest; 
		}
	</script>
	
	<script>
		
		// Decrement the Quantity
		// Check if the quantity of the item is already 1
		// To prevent decrementing to prevent negative values from being displayed for the price
		// Otherwise update the price by dividing the current price by 2
		function decrement()
		{
			// if the quantity of the menu item is not 1
			if (document.getElementById("quantity").value != 1)
			{
				// decrement the quantity text
				document.getElementById("quantity").stepDown(1);
				
				// get the price of the menu item
				var price = document.getElementById("price").value;
				
				// get the price without the currency symbol as a string
				var rawPrice = price.slice(1, 10);
				
				// get the value of the price as a float
				var thePrice = parseFloat(rawPrice);
			
				// divide the price by 2
				var newPrice = thePrice/2;
				
				// set the value of the new price
				var latest = newPrice.toFixed(2);
				document.getElementById("price").value = "£"+latest; 
			}
		}
	</script>
	
	<script>
		
		// Add the £ sign for formatting the price of the menu item
		function setPrice()
		{
			// obtain the price
			var price = document.getElementById("price").value;
			
			// concatenate the £ sign next to the price
            document.getElementById("price").value = "£"+price; 
		}
	</script>
	
	<script>
		
		// Update the price if an extra is selected
		// Update the price depending on the selected size
		
	    var extraFirstTime = true;
		var sizeFirstTime = true;
		
		function changePrice()
		{
			 	 // get the selected topping
			 	 var x = document.getElementById("toppings");
			 	 var i = x.selectedIndex;
			
			 	 // get the selected size
			 	 var y = document.getElementById("size");
			 	 var n = y.selectedIndex;
					
				 // if no extras was selected and it's the user's first time selecting this
				 if (x.options[i].text != "No Extras Selected" && extraFirstTime == true)
				 {
					// ensure next time it won't be the user's first time
					extraFirstTime = false;
					 
					// get the price of the menu item
					var price = document.getElementById("price").value;
					 
					// get the price without the currency symbol as a string
					var rawPrice = price.slice(1, 10);
					 
					// get the value of the price as a float
					var thePrice = parseFloat(rawPrice);
					
					// add 1.99 to the price
					var newPrice = thePrice+1.99;
					
					// set the price string to the updated value which is concatenated with the £ currency symbol
					document.getElementById("price").value = "£"+newPrice; 
				 }
				
				 // if the size is not small or single and it's the user's first time selecting either size
				 if ((y.options[n].text != 'Small (9")' || y.options[n].text != 'Single') && sizeFirstTime == true)
				 {
					// ensure next time it won't be the user's first time
					sizeFirstTime = false;
					 
					// get the price of the menu item
					var price = document.getElementById("price").value;
					 
					// get the price without the currency symbol as a string
					var rawPrice = price.slice(1, 10);
					
					// get the value of the price as a float
					var thePrice = parseFloat(rawPrice);
					
					// add 1.99 to the price
					var newPrice = thePrice+1.99;
					
					// set the price string to the updated value which is concatenated with the £ currency symbol
					document.getElementById("price").value = "£"+newPrice; 
				}
			
				// if no extras was selected but it's not the user's first time selecting this
				if (x.options[i].text == "No Extras Selected" && extraFirstTime == false)
				{
					// ensure next time it will be the user's first time selecting this
					extraFirstTime = true;
					
					// get the price of the menu item
					var price = document.getElementById("price").value;
					
					// get the price without the currency symbol as a string
					var rawPrice = price.slice(1, 10);
					
					// get the value of the price as a float
					var thePrice = parseFloat(rawPrice);
					
					// subtract 1.99 from the price
					var newPrice = thePrice-1.99;
					
					// set the new price
					var latest = newPrice.toFixed(2);
					
					// concatenate the new price with the £ currency symbol to set the new price string
					document.getElementById("price").value = "£"+latest; 
				}
			
				// if the size is small or single and it's not the user's first time selecting either size 
			    if ((y.options[n].text == 'Small (9")' || y.options[n].text =='Single') && sizeFirstTime == false)
				{
					// ensure the next time it will be the user's first time selecting either size
					sizeFirstTime = true;
					
					// get the price of the menu item
					var price = document.getElementById("price").value;
					
					// get the price without the currency symbol as a string
					var rawPrice = price.slice(1,10);
					
					// get the value of the price as a float
					var thePrice = parseFloat(rawPrice);
					
					// subtract 1.99 from the price
					var newPrice = thePrice-1.99;
					
					// set the new price
					var latestPrice = newPrice.toFixed(2);
					
					// concatenate the new price with the £ currency symbol to set the new price string
					document.getElementById("price").value = "£"+latestPrice;
				}	
		}

	  </script>
	
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
<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Confirmation</title>
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="css/animsition.min.css">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
  </head>
  <body id="sign-up-page">
	<script src="js/jquery-1.11.3.min.js"></script>
	
	<div class="animsition">
	
		<div class="appHeader">
			<p id="headerText">Order Confirmation</p>
		</div>
	
		<div class="back-button">
			<a href="menu.html" id="back-button">
			<img src="images/back.png" height="50" width="50" alt="Back Button" class="img-rounded img-responsive"></a>
		</div>
		
		<div class="confirm-area">
		
			<table id="basket" class="table table-striped">
			<thead>
      			<tr>
        			<th>Item</th>
        			<th>Extra</th>
       				<th>Size</th>
       				<th>Price</th>
       				<th>Quantity</th>
      			</tr>
    		</thead>
    		<tbody>
    		
    		
    		<!-- Load Items from Cart Session -->
    		<?php
				
				// get the array of cart items where each index holds another array of item details
				$addedItems = $_SESSION["addedItems"];
				
				foreach ($addedItems as $value)
				{
					echo "<tr>";
					echo "<td>";
					echo $value[0];
					echo "</td>";
					echo "<td>";
					echo $value[1];
					echo "</td>";
					echo "<td>";
					echo $value[2];
					echo "</td>";
					echo "<td>";
					echo $value[3];
					echo "</td>";
					echo "<td>";
					echo $value[4];
					echo "</td>";
					echo "<td>";
					echo "<button type=\"button\" class=\"btn btn-danger\" onclick=\"removeItem(this)\">Remove</button>";
					echo "</td>";
					echo "</tr>";
				}
			 ?>
    				
    		</tbody>
    		
			</table>
			
			<form id="additional-area" action="order-confirmed.php" method="post">
			
			   	<div class="form-group">
  					<label for="orderTotal">Order Total</label>
  					<input type="string" class="form-control" id="total"
  					
  					<?php
					
					   // Get each item's price from the array of cart items
					   // increment each menu item's price to obtain total
					   // Format the total by adding a £ sign
					
					   $addedItems = $_SESSION["addedItems"];
						
					   $total = 0;
						    
					   foreach ($addedItems as $value)
					   {
						   // extract the decimal price value
						   $price = substr($value[3],2,10);
						   $total = $price+$total;
					   }
						   
					   echo "value=\"";
					   echo "£";
					   // print out the decimal value
					   echo number_format($total,2);
					   echo "\"";
						   
				    ?>
  					
  					readonly>
				</div>
				
				<div class="form-group">
  					<label for="additionalRequirements">Additional Requirements</label>
  					<textarea class="form-control" rows="5" id="additionalRequrements" name="additionalRequirements"></textarea>
				</div>
				
  		  		<div class="form-group">
  			  		<label for="currentPoints">Available Points</label>
   			  		<input type="text" class="form-control" id="points" name="currentPoints"
   			  		
   			  		<?php
						  
						$servername = "localhost";
	  					$username = "root";
	  					$password = "root";
	  					$dbname = "CouCou";
						   
	  					$conn = new mysqli($servername, $username, $password, $dbname);
						
						// get the logged in user's email address
						$email = $_SESSION["emailAddress"];
						   
						// get loyalty points via the logged in users email address
	      				$sql = "SELECT loyaltyPoints FROM Customer WHERE email='$email'";
	      				$result = mysqli_query($conn, $sql);
						   
						if (mysqli_num_rows($result) > 0)
						{
							// display those loyalty points
							while($row = mysqli_fetch_assoc($result))
							{
								echo "value=\"";
								echo $row["loyaltyPoints"];
								echo "\"";
							}
						}
						   
				    ?>
   			  		   
   			  		readonly>
		  		</div>
		  		
		  		
 			  	<div class="form-group">
  			  		<label for="currentPoints">Points Gained</label>
   			  		<input type="text" class="form-control" id="pointsGained" name="pointsGained"
   			  		
   			  		<?php
						   
					// Calculate the points gained
					// If the item is a pizza item or a burger item then increment points gained
						 
					$addedItems = $_SESSION["addedItems"];
				    
				    $pointsGained = 0;
				       
					   foreach ($addedItems as $value)
					   {
						   if ($value[2] != "Standard")
						   {
							   $pointsGained++;
						   }
					   }
					
				    echo "value=\"";
					echo $pointsGained;
				    echo "\"";
						      
				    ?>
   			  		   
   			  		readonly>
		  		</div>
		  		
		  		
		  		<?php
											
						$servername = "localhost";
	  					$username = "root";
	  					$password = "root";
	  					$dbname = "CouCou";
						   
	  					$conn = new mysqli($servername, $username, $password, $dbname);
						
						// get the logged in user's email address
						$email = $_SESSION["emailAddress"];
						   
						// get loyalty points via the logged in users email address
	      				$sql = "SELECT loyaltyPoints FROM Customer WHERE email='$email'";
	      				$result = mysqli_query($conn, $sql);
						   
						if (mysqli_num_rows($result) > 0)
						{
							while($row = mysqli_fetch_assoc($result))
							{
								// If the loyalty points of the customer is 10
					    	    // Display a Use Points button
								if ($row["loyaltyPoints"] == 10)
								{
									echo "<div class=\"form-group\">";
									echo "<button type=\"submit\" class=\"btn btn-lg btn-default button\" id=\"redeem\" onclick=\"usePoints()\">Use Points</button>";
									echo "</div>";
								}
							}
						} 
				    ?>
   			  		
   			  	<div class="form-group">
   			  		<label for="orderType">Order Type</label>
   			  		<select id="orderType" class="form-control" name="orderType">
   			  			<option>Delivery</option>
   			  			<option>Collection</option>
   			  		</select>
   			  	</div>
		  		
				<div class="form-group">
 					<button type="submit" class="btn btn-lg btn-default button" id="signup-button">Confirm Order</button>
				</div>
 			</form>
		</div>
	</div>
	
	
	<script>
		
		// deletes an item from the table using the HTML Document Object Model
		// requires the row number of the item to remove
		function removeItem(i)
		{
			var index = i.parentNode.parentNode.rowIndex;
			
			// get the price of the item to be removed
			var price  = document.getElementById("basket").rows[index].cells.item(3).innerHTML;
			
			// obtain it's string value without the currency symbol
			var thePrice = price.slice(1,10);
			
			// obtain it's value as a float
			var priceFloat = parseFloat(thePrice);
			
			// obtain the current order total
			var oldTotal = document.getElementById("total").value;
			
			// obtain the total's string value without the currency symbol
			var theOldTotal = oldTotal.slice(1,10);
			
			// obtain it's value as a float
			var theOldTotalFloat = parseFloat(theOldTotal);
			
			// subtract the old total from the price of the item to be removed
			var newTotal = theOldTotalFloat - priceFloat;
			
			// display this new total to the user
			var theNewTotal = newTotal.toFixed(2);
		
			document.getElementById("total").value = "£"+theNewTotal;
			
			
			// check if the row has a standard sized item
			
			var size = document.getElementById("basket").rows[index].cells.item(2).innerHTML;
			
			// if the size is not standard
			// subtract 1 point from the points gained
			if (size != "Standard")
			{
				var pointsGained = document.getElementById("pointsGained").value;
				
				var thePointsGained = parseInt(pointsGained);
				
				var newPointsGained = thePointsGained - 1;
				
				document.getElementById("pointsGained").value = newPointsGained;	
			}
			
			
			// delete the row corresponding to the deleted item
			document.getElementById("basket").deleteRow(index);
			
			// make ajax call and pass the item name to the remove-item.php file
			var xmlHTTPRequest = new XMLHttpRequest();
			
			var theIndex = "index=1";
			
			xmlHTTPRequest.open("POST","remove-item.php",true);
			
			xmlHTTPRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			
		  	xmlHTTPRequest.onreadystatechange = function()
		  	{
				if (xmlHTTPRequest.readyState == 4 && xmlHTTPRequest.status == 200)
			  	{
					// on successfull deletion, notify the user that the item has been removed
					var text = xmlHTTPRequest.responseText;
					alert(text);
				}
			}
			
		    xmlHTTPRequest.send("index="+index);
		}
			

		// Update the available points field once points have been redeemed
		
		function usePoints()
		{
			document.getElementById("points").value = 0;
			
			var redeemButton = document.getElementById("redeem");
			
			// hide the use points button after redeeming points
			redeemButton.parentNode.removeChild(redeemButton);
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
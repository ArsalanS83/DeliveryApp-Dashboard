<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Past Order Details</title>
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="css/animsition.min.css">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
  </head>
  <body id="sign-up-page">
	<script src="js/jquery-1.11.3.min.js"></script>
	
	<div class="animsition">
	
		<div class="appHeader">
			<p id="headerText">Past Order:
			
			<?php
			
			// get the text of the selected past order button
            $text = $_POST['orderIDButton'];
			
			// extract the date from the text of the selected past order button
			$FinalString = substr($text,9,50);

			// create a date from the extracted date string
			$date = date_create($FinalString);
			
			// display the formatted date of the selected past order
			echo date_format($date,"d/m/Y");
				
			?>
			</p>
		</div>
	
		<div class="back-button">
			<a href="order-history.php" id="back-button">
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
    		
    		<?php
				
			$servername = "localhost";
			$username = "root";
			$password = "root";
			$dbname = "CouCou";
						   
			$conn = new mysqli($servername, $username, $password, $dbname);
			
			// get the text of the selected past order button
			$theOrderID = $_POST['orderIDButton'];

			// extract the order id from the text of the selected past order button
			$string = substr($theOrderID,6,2);

			// remove the colon from the order id which separates the order id from the date
			$FinalOrderID = trim($string,":");
				
			// get the item id based on the extracted order id	
			$sql = "SELECT itemID FROM OrderItems WHERE orderID = '$FinalOrderID'";
			
			$result = mysqli_query($conn, $sql);
			
			// create a variable to hold the item id once it is retrieved from the query
			$itemID = "";

    		if (mysqli_num_rows($result) > 0)
			{
				while($row = mysqli_fetch_assoc($result))
				{
					// display the details of each ordered item using the extracted order id and the item id
					
					// display the item id of the ordered menu item
					echo "<tr>";
					$itemID = $row["itemID"];
					
					// get the name of the ordered menu item
					$qry = "SELECT MenuItem.itemName FROM MenuItem INNER JOIN OrderItems ON MenuItem.itemID = OrderItems.itemID WHERE orderID = '$FinalOrderID' AND MenuItem.itemID = '$itemID'";
					
					$res = mysqli_query($conn, $qry);

    				if (mysqli_num_rows($res) > 0)
					{
						while($row = mysqli_fetch_assoc($res))
						{
							// display name of the ordered menu item
							echo "<td>";
							echo $row["itemName"];
							echo "</td>";
						}
					}
					
					// get any selected extra's for the ordered menu item
					$ing = "SELECT Ingredient.ingredientName FROM Ingredient INNER JOIN OrderItems ON Ingredient.ingredientID = OrderItems.extraID WHERE orderID = '$FinalOrderID' AND OrderItems.itemID = '$itemID'";
					
					$ans = mysqli_query($conn, $ing);

    				if (mysqli_num_rows($ans) > 0)
					{
						while($row = mysqli_fetch_assoc($ans))
						{
							// display the extra if an extra was selected
							echo "<td>";
							echo $row["ingredientName"];
							echo "</td>";
						}
					}
					else
					{
						// otherwise display no extra selected for the ordered menu item
						echo "<td>";
						echo "No Extra Selected";
						echo "</td>";
					}
					
					// get the selected size for the ordered menu item
					$sze = "SELECT MenuItemSize.sizeInfo FROM MenuItemSize INNER JOIN OrderItems ON MenuItemSize.sizeID = OrderItems.sizeID WHERE orderID = '$FinalOrderID' AND OrderItems.itemID = '$itemID'";
					
					$szeresult = mysqli_query($conn, $sze);
					
					if (mysqli_num_rows($szeresult) > 0)
					{
						while($row = mysqli_fetch_assoc($szeresult))
						{
							// display the size of the ordered menu item
							echo "<td>";
							echo $row["sizeInfo"];
							echo "</td>";
						}
					}
					
					// get the price of the ordered menu item
					$prc = "SELECT MenuItem.price FROM MenuItem INNER JOIN OrderItems ON OrderItems.itemID = MenuItem.itemID WHERE orderID = '$FinalOrderID' AND OrderItems.itemID = '$itemID'";
					
					$prcresult = mysqli_query($conn, $prc);
					
					if (mysqli_num_rows($prcresult) > 0)
					{
						while($row = mysqli_fetch_assoc($prcresult))
						{
							// display the price of the menu item concatenated with the £ currency symbol
							echo "<td>";
							echo "£";
							echo $row["price"];
							echo "</td>";
						}
					}
					
					// get the quantity of the menu item that was ordered
					$qty = "SELECT itemQuantity FROM OrderItems WHERE orderID = '$FinalOrderID' AND itemID = '$itemID'";
					
					$qtyresult = mysqli_query($conn, $qty);
					
					if (mysqli_num_rows($qtyresult) > 0)
					{
						while($row = mysqli_fetch_assoc($qtyresult))
						{
							// display the quantity of the menu item that was ordered
							echo "<td>";
							echo $row["itemQuantity"];
							echo "</td>";
						}
					}					
				}
				echo "</tr>";
			}

			?>
    		
			</tbody>
			
			</table>
  		
 		    <form id="additional-area">
  		     		
		  	<div class="form-group">
   		    	<label for="orderTotal">Order Total</label>
  				<input type="string" class="form-control" id="total"
  				
  				<?php
					   
				$servername = "localhost";
				$username = "root";
				$password = "root";
				$dbname = "CouCou";
						   
				$conn = new mysqli($servername, $username, $password, $dbname);
					   
				// get the text of the selected past order button
				$theOrderID = $_POST['orderIDButton'];
					   
				// extract the order id from the text of the selected past order button 
				$string = substr($theOrderID,6,2);
					   
				// remove the colon from the order id which separates the order id from the date	   
				$FinalOrderID = trim($string,":");
					   
			    // get the total of all menu item's from the selected past order using it's order id
			    // sum the price of all the menu item's belonging to this order to achieve the total price of the order 
			    $sql = "SELECT SUM(MenuItem.price) FROM MenuItem INNER JOIN OrderItems ON MenuItem.itemID = OrderItems.orderID WHERE orderID = '$FinalOrderID'";
					   
			    $result = mysqli_query($conn, $sql);
						
    			if (mysqli_num_rows($result) > 0)
				{
					while($row = mysqli_fetch_assoc($result))
					{
						// display the total price of the order formatted with the £ currency symbol
						echo "value=\"";
						echo "£";
						echo $row["SUM(MenuItem.price)"];
						echo "\"";
						echo ">";
					}
				}														
				?>
				
			</div>
   			<div class="form-group">
  					<label for="additionalRequirements">Additional Requirements</label>
  					<textarea class="form-control" rows="5" id="additionalRequirements" name="additionalRequirements"></textarea>
			</div>
			</form>
  		  </div>	
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
	  
	  <script>
		   
		   // Send AJAX request to server to check if additional requirements exist for the order
		   // if the response is none then set the additional requirements text area to "none"
		   // otherwise display the response text in the additional requirements text area
		  
		   $(document).ready(function(){
			   
			   var req = new XMLHttpRequest();
			   
			   req.open("GET","get-additional-requirements.php",true);
			   
			   req.send();
			   
			   req.onreadystatechange = function()
			   {
				   if (req.readyState == 4 && req.status == 200)
				   {
					   // get the response from the server
					   var text = req.responseText;
					   
					   // trim the response just in case server outputted whitespace 
					   var theResponse = text.trim()
					   
					   // if the response was none then there were no additional requirements for this selected past order
					   if (theResponse == "None")
					   {
						  // display "none" in additional requirements text area
						  document.getElementById("additionalRequirements").value = "None";  
					   }
					   else
					   {
						   // otherwise there were additional requirements for the selected past order
						   // fill the additional requirements text area with the additional requirements of the order
						   document.getElementById("additionalRequirements").value = text;
					   }
				   } 
			   } 
		   });   
	  </script>
  </body>
</html>
</html>
<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customer Orders</title>
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
  </head>
  <body onload = "getOrders()">
	<script src="js/jquery-1.11.3.min.js"></script>
	<img src="images/Logo.jpg" alt="CouCou Logo" class="img-rounded img-responsive" id="logo">
	
	<div class="header">
		<p id="welcomeText">Manage Customer Orders</p>
	</div>
	
	<div id="loggedIn">
	 
	 <?php
		
		$servername = "localhost";
 		$username = "root";
 		$password = "root";
 		$dbname = "CouCou";
	  
 		$conn = new mysqli($servername, $username, $password, $dbname);
		
		// get staff member's username from the session
		$username = $_SESSION["username"];
		
		// get staff member's first name and surname using the staff member's username
		$sql = "SELECT firstName, lastName from Staff WHERE username = '$username'";
		$result = mysqli_query($conn, $sql);
		
		if (mysqli_num_rows($result) > 0)
		{
			while($row = mysqli_fetch_assoc($result))
			{
				// display the staff member's first name and surname
				echo "<p>";
				echo "Logged In: ";
				echo $row["firstName"];
				echo " ";
				echo $row["lastName"];
				echo "</p>";
			}
		}
	 ?>
		 
	</div>
	
	<div id="date">
		<p id="theDate"></p>
	</div>
	
	<div id="time">
		<p id="theTime"></p>
	</div>
	
	<a href="welcome.php"><img src="images/back.png" height="50" width="50" alt="Back Button" class="img-rounded img-responsive back-button"></a>
		
	<div class="order-area">
	
	<table id="orderTable" class="table table-striped">
    	<thead>
      		<tr>
      			<th>Order Number</th>
       			<th>First Name</th>
        		<th>Surname</th>
       			<th>Phone Number</th>
       			<th>Order Time</th>
       			<th>Order Type</th>
       			<th>Order Status</th>
      		</tr>
    	</thead>
    	<tbody>
    		
    	</tbody>
	</table>
			
	</div>
	
	<h3 id="orderDetails">Order Details</h3>
	
	<div class="order-details-area">

	<table id="orderDetailsTable" class="table table-striped">
    	<thead>
      		<tr>
       			<th>Item</th>
        		<th>Quantity</th>
       			<th>Extra</th>
      		</tr>
    	</thead>
    	<tbody>
    	 		
    	</tbody>
	</table>
		
	<div id="requirements">
		<h4>Additional Requirements</h4>
		<input type="text" class="form-control" id="requirementData"></input>	
	</div>
			
	</div>
	
	<script src="js/bootstrap.js"></script>
	
	<script>
		
		// display the current time which dynamically updates
		function startTime() {
			var today = new Date();
    		document.getElementById('theTime').innerHTML = today.toLocaleTimeString();
			var t = setTimeout(startTime, 500);
		}
		
		// display today's date
		var d = new Date();
		document.getElementById("theDate").innerHTML = d.toDateString();
		
		// retrieve all customer orders from the database
		function getOrders()
		{
		
		  startTime();
			
		  var xmlHTTPRequest = new XMLHttpRequest();
		 		  
		  xmlHTTPRequest.onreadystatechange = function()
		  {
			  if (xmlHTTPRequest.readyState == 4 && xmlHTTPRequest.status == 200)
			  {
				  // get the retrieved order data as a complete string separated by the | symbol
				  var orderData = xmlHTTPRequest.responseText;
				  
				  // extract each order data component
				  var theData = orderData.split("|");
				  
				  // get the table which will be populated with the order data
				  var table = document.getElementById("orderTable").getElementsByTagName('tbody')[0];
				  
				  // the row number which increments after inserting each order row into the table
				  var rowNum = 0;
				  
				  // iterate through the order table
				  // update the table with the order data
				  for (var i = 0; i < theData.length-1; i++)
				  {
					  // insert a new row into the table representing an order
					  var row = table.insertRow(rowNum);
					  
					  // display order id
					  row.insertCell(0).innerHTML = theData[i];
					  i++;
					  
					  // display first name of customer
					  row.insertCell(1).innerHTML = theData[i];
					  i++;
					  
					  // display surname of customer
					  row.insertCell(2).innerHTML = theData[i];
					  i++;
					  
					  // display phone number of customer
					  row.insertCell(3).innerHTML = theData[i];
					  i++;
					  
					  // display order time
					  row.insertCell(4).innerHTML = theData[i];
					  i++;
					  
					  // display whether the order is for collection or delivery
					  row.insertCell(5).innerHTML = theData[i];
					  i++;
					  
					  // display the current status of the order
					  row.insertCell(6).innerHTML = theData[i];
					  
					  // create update status button for the row in the table
                      row.insertCell(7).innerHTML = "<button type=\"button\" onclick=\"updateStatus(this)\"  class=\"btn btn-lg btn-default interfaceButton\">Update Status</button>";
					  
					  // create view order details button for the row in the table 
					  row.insertCell(8).innerHTML = "<button type=\"button\" id=\"a\" onclick=\"getOrderDetails(this)\" class=\"btn btn-lg btn-default interfaceButton\">View Order Details</button>";
					  
					  // increment the row number to allow the next order, if available to be inserted
					  rowNum++;  
				  }
				  
				  // view order details of first order
				  // simulates click of view order details for 1st row
				  document.getElementById("a").click(1);
			  }
		  }
		  
		  // send AJAX request to server in order to get all customer orders from the database
		  xmlHTTPRequest.open("GET","get-orders.php",true);
		  xmlHTTPRequest.send();
		}
		
	
	// updates the table with all updated order statuses
	// update the table with all order status fields from the retrieved orders 
	function displayUpdatedStatus(num)
	{
		 var orderRequest = new XMLHttpRequest();
		 		  
		  orderRequest.onreadystatechange = function()
		  {
			  if (orderRequest.readyState == 4 && orderRequest.status == 200)
			  {
				  // get the retrieved order data as a complete string separated by the | symbol
				  var orderData = orderRequest.responseText;
				  
				  // extract each order data component
				  var orderData = orderData.split("|");
				  
				  // display updated order status
				  document.getElementById("orderTable").getElementsByTagName('tbody')[0].rows[num-1].cells[6].innerHTML = orderData[6]; 
			  }
		  }
		  
		  // send AJAX request to server to retrieve all orders again
		  orderRequest.open("GET","get-orders.php",true);
		  orderRequest.send();
	}
			  
	// updates the selected order's status	
	function updateStatus(i)
    { 
		  // get index of selected order from table
		  var index = i.parentNode.parentNode.rowIndex;
				  
		  var request = new XMLHttpRequest();
		
		  // get cell displaying the current order status		
		  var orderStatus =  document.getElementById("orderTable").getElementsByTagName("tbody")[0].rows[index-1].cells[6].innerHTML;
	
		  // get first name of selected row
		  var fname = document.getElementById("orderTable").getElementsByTagName("tbody")[0].rows[index-1].cells[1].innerHTML;
		
		  // get order time of selected row
		  var time = document.getElementById("orderTable").getElementsByTagName("tbody")[0].rows[index-1].cells[4].innerHTML;
						 		  
		  request.onreadystatechange = function()
		  {
			  if (request.readyState == 4 && request.status == 200)
			  {
				  // update the table with all updated order statuses
				  displayUpdatedStatus(index);
			  }
		  }
		 
		 // send AJAX request to server to update the status of the selected order
		 // send the order's current status, the customer's first name and the order time as parameters to the request
		 request.open("POST","update-status.php",true);
		 request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		 request.send("status="+orderStatus+"&theFName="+fname+"&theTime="+time);
	}
		
		
    // view order details of selected order
	function getOrderDetails(i)
	{
        // get row of selected order
		var index = i.parentNode.parentNode.rowIndex;
				
		var orderDetailsRequest = new XMLHttpRequest();
		
		orderDetailsRequest.onreadystatechange = function()
		{
			  if (orderDetailsRequest.readyState == 4 && orderDetailsRequest.status == 200)
			  {
				  // get the table body of the order details table
				  var t = document.getElementById("orderDetailsTable").getElementsByTagName("tbody")[0];
				  
				  // create a new table body for the order details table
				  var a = document.createElement('tbody');
		
				  // get the order details table
				  var ab = document.getElementById("orderDetailsTable");
		
				  // remove current body of order details table
		          ab.removeChild(t);
		
				  // insert new body at order details table
		          ab.appendChild(a);
				  
				  // retrieve order details for the selected order as a complete string separated by the | symbol
				  var orderDetailsData = orderDetailsRequest.responseText;
				  
				  // extract each order detail data component
				  var orderDetailsData = orderDetailsData.split("|");
				  
				  // the row number which increments after inserting each order detail into the table
				  var rowNum = 0;
				  
				  // iterate through table populating it with order data
				  for (var i = 0; i < orderDetailsData.length-2; i++)
				  {
					 // get the order details table
					 var table = document.getElementById("orderDetailsTable").getElementsByTagName("tbody")[0];
					 
					 // insert a new row representing a menu item, it's quantity and whether or not an extra's were added to the menu item
					 var row = table.insertRow(rowNum);
					  
					 // display the menu item name
					 row.insertCell(0).innerHTML = orderDetailsData[i];
					 i++;
					  
					 // display the quantity ordered of that menu item
					 row.insertCell(1).innerHTML = orderDetailsData[i];
					 i++;
					  
					 // display any extra's selected for the menu item
					 row.insertCell(2).innerHTML = orderDetailsData[i];
					 
					 // increment the row number to prepare inserting a new menu item that was ordered, if any
					 rowNum++;  
				  }
				  
				  // update the additional requirements box with the additional requirements of the order
				  document.getElementById("requirementData").value = orderDetailsData[orderDetailsData.length-2];
				  
				  // set the header to the order details of the selected order
				  document.getElementById("orderDetails").innerHTML = "Order "+index+" Details";
			  }
		}
		 
		 // send AJAX request to server to obtain the order details of the selected order
		 // retrieve all menu items, their quantity ordered and whether or not any extras were added to each menu item that was ordered
		 // send the selected order's order id as the parameter to the request
		 orderDetailsRequest.open("POST","get-order-details.php",true);
		 orderDetailsRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		 orderDetailsRequest.send("orderID="+index);
	}
		
	var timer = setInterval(updateOrders,10000);
		
	// check for new orders asynchronously
	// get all order details again
	// updates table by replacing table body with orders
	function updateOrders()
	{		
		  var xmlHTTPRequest = new XMLHttpRequest();
		 		  
		  xmlHTTPRequest.onreadystatechange = function()
		  {
			  if (xmlHTTPRequest.readyState == 4 && xmlHTTPRequest.status == 200)
			  {
				  // get the retrieved order data as a complete string separated by the | symbol
				  var orderData = xmlHTTPRequest.responseText;
				  
				  // extract each order data component
				  var theData = orderData.split("|");
				  
				  // get the order table
				  var table = document.getElementById("orderTable");
				  
				  // get the order table's body
				  var currentBody = document.getElementById("orderTable").getElementsByTagName("tbody")[0];
				  
				  // create new table body
				  var newBody = document.createElement('tbody');
				  
				  // replace table body of order table with this new table body
				  table.replaceChild(newBody,currentBody);
				  
				  // update new table body with all order data
				  var newDataBody = document.getElementById("orderTable").getElementsByTagName("tbody")[0];
				  
				  // the row number which increments after inserting each order row into the table
				  var rowNum = 0;
				  
				  // iterate through table populating it with order data
				  for (var i = 0; i < theData.length-1; i++)
				  {
					  // insert a new row into the table representing an order
					  var row = newDataBody.insertRow(rowNum);
					  
					  // display order id
					  row.insertCell(0).innerHTML = theData[i];
					  i++;
					  
					  // display first name of customer
					  row.insertCell(1).innerHTML = theData[i];
					  i++;
					  
					  // display surname of customer
					  row.insertCell(2).innerHTML = theData[i];
					  i++;
					  
					  // display phone number of customer
					  row.insertCell(3).innerHTML = theData[i];
					  i++;
					  
					  // display order time
					  row.insertCell(4).innerHTML = theData[i];
					  i++;
					  
					  // display whether the order is for collection or delivery
					  row.insertCell(5).innerHTML = theData[i];
					  i++;
					  
					  // display the current status of the order
					  row.insertCell(6).innerHTML = theData[i];
					  
					  // create update status button for the row in the table
                      row.insertCell(7).innerHTML = "<button type=\"button\" onclick=\"updateStatus(this)\"  class=\"btn btn-lg btn-default interfaceButton\">Update Status</button>";
					  
					  // create view order details button for the row in the table
					  row.insertCell(8).innerHTML = "<button type=\"button\" id=\"a\" onclick=\"getOrderDetails(this)\" class=\"btn btn-lg btn-default interfaceButton\">View Order Details</button>";
					  
					  // increment the row number to allow the next order, if available to be inserted
					  rowNum++;  
				  }
			  }
		  }
		  
		  // send AJAX request to server to retrieve all orders again
		  xmlHTTPRequest.open("GET","get-orders.php",true);
		  xmlHTTPRequest.send();
	}	
</script>
  </body>
</html>
<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "CouCou";
	  
$conn = new mysqli($servername, $username, $password, $dbname);

// ensure the orders to be obtained are not yet delivered
$orderStatus = "Delivered";

// retrieve all customer orders where their order status is not delivered yet
$sql = "SELECT Orders.orderID, Customer.firstName, Customer.lastName, Customer.phoneNumber,orderTime,orderType,orderStatus FROM Orders INNER JOIN Customer ON Orders.customerID = Customer.customerID WHERE orderStatus !='$orderStatus' GROUP BY orderID";
			
$result = mysqli_query($conn, $sql);

// output order data separated by | symbol back to client		
if (mysqli_num_rows($result) > 0)
{
	while($row = mysqli_fetch_assoc($result))
	{
		// display order id
		echo $row["orderID"];
		echo "|";
		
		// display first name of customer
		echo $row["firstName"];
		echo "|";
		
		// display surname of customer
		echo $row["lastName"];
		echo "|";
		
		// display phone number of customer
		echo $row["phoneNumber"];
		echo "|";
		
		// display order time
		echo $row["orderTime"];
		echo "|";
		
		// display whether the order is for collection or delivery
		echo $row["orderType"];
		echo "|";
		
		// display the current status of the order
	    echo $row["orderStatus"];
		echo "|";
	}
}
?>
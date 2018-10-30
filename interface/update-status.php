<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "CouCou";
	  
$conn = new mysqli($servername, $username, $password, $dbname);

// get first name of customer who ordered the selected order
$fname = $_POST['theFName'];

// get order time of selected order to update the status for
$time = $_POST['theTime'];

// 1) get the order status
// 2) determine the current order status
// 3) update the order status to the next status e.g. from "Ordering" to "Preparing"
// 4) update the order status where the first name and order time of the order match the first name and order time of the selected order
// 5) send the updated order status back to the client

if ($_POST['status'] == "Ordered")
{
	$updatedStatus = "Preparing";
	
	$sql = "UPDATE Orders SET orderStatus = '$updatedStatus' WHERE customerID = (SELECT customerID FROM Customer WHERE firstName='$fname') AND orderTime= '$time'";
	
	if (mysqli_query($conn, $sql))
	{
		echo "Preparing";
	}
}

if ($_POST['status'] == "Preparing")
{
	$updatedStatus = "Cooking";
	
	$sql = "UPDATE Orders SET orderStatus = '$updatedStatus' WHERE customerID = (SELECT customerID FROM Customer WHERE firstName='$fname') AND orderTime= '$time'";
	
	if (mysqli_query($conn, $sql))
	{	
		echo "Cooking";
	}
}

if ($_POST['status'] == "Cooking")
{
	$updatedStatus = "Out for Delivery";
	
	$sql = "UPDATE Orders SET orderStatus = '$updatedStatus' WHERE customerID = (SELECT customerID FROM Customer WHERE firstName='$fname') AND orderTime= '$time'";
	
	if (mysqli_query($conn, $sql))
	{
		
		echo "Out for Delivery";
	}
}

if ($_POST['status'] == "Out for Delivery")
{
	$updatedStatus = "Delivered";
	
	$sql = "UPDATE Orders SET orderStatus = '$updatedStatus' WHERE customerID = (SELECT customerID FROM Customer WHERE firstName='$fname') AND orderTime= '$time'";
	
	if (mysqli_query($conn, $sql))
	{
		
	}
}
?>
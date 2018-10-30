<?php
session_start();
?>

<?php

 // This script is used to determine if the logged in customer has a current existing order for today
 // The response will determine whether the live track order button should be disabled or not

 $servername = "localhost";
 $username = "root";
 $password = "root";
 $dbname = "CouCou";
	  
 $conn = new mysqli($servername, $username, $password, $dbname);

 // get session email
 $email = $_SESSION["emailAddress"];
 $customerID = "";

 // obtain the customer id from the logged in user's email address
 $sql = "SELECT customerID FROM Customer WHERE email='$email'";
 $result = mysqli_query($conn, $sql);

 if (mysqli_num_rows($result) > 0)
 {
	 while($row = mysqli_fetch_assoc($result))
	 {
		 // get the customer id
		 $customerID = $row["customerID"];
	 }
 }

 // Check if an order date exists for the logged in customer and is equal to today's date
 // if no order is available for today, send a 'no' response to the client
 $qry = "SELECT orderDate FROM Orders WHERE customerID = '$customerID'";
 $res = mysqli_query($conn, $qry);

 if (mysqli_num_rows($res) > 0)
 {
	while($row = mysqli_fetch_assoc($res))
	{
		if ($row["orderDate"] == date("Y-m-d"))
		{
			
		}
	}
}
else
{
	echo "no";
}	 
?>
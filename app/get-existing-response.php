<?php
session_start();
?>

<?php

 // This script is used to determine if the customer has an order that has not been reviewed yet
 // This script is used to determine whether or not the Review History & Responses button should be displayed

 $servername = "localhost";
 $username = "root";
 $password = "root";
 $dbname = "CouCou";
	  
 $conn = new mysqli($servername, $username, $password, $dbname);

 // get session email
 $email = $_SESSION["emailAddress"];
 $customerID = "";

 // get the customer id of the logged in user based on their email address
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

 // check if an order id exists for the customer which has not been rated yet
 // if no order exists that has not been reviewed then send a 'no' response to the client
 $qry = "SELECT orderID FROM Review WHERE customerID = '$customerID' AND rating IS NOT NULL";
 $res = mysqli_query($conn, $qry);

 if (mysqli_num_rows($res) > 0)
 {

 }
 else
 {
	echo "no";
 }	 
?>
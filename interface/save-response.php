<?php

session_start();

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "CouCou";
	  
$conn = new mysqli($servername, $username, $password, $dbname);

// get selected review id
$reviewID = $_POST['reviewID'];

// get staff's response
$reviewDesc = $_POST['reviewDesc'];

// get staff's username
$staffUsername = $_SESSION["username"];

// retrieve staff id of staff member who responded to the review
$qry = "SELECT staffID FROM Staff WHERE username = '$staffUsername'";
$result = mysqli_query($conn, $qry);

 if (mysqli_num_rows($result) > 0)
 {
	 while($row = mysqli_fetch_assoc($result))
	 {
		 // get the staff id
		 // the staff id is used to update the review table
		 $staffID = $row["staffID"];
		 
		 // update the review response for the selected review using the id of the review and the staff member's id
		 $sql = "UPDATE Review SET staffResponse = '$reviewDesc', staffID = '$staffID' WHERE reviewID = '$reviewID'";
		 
		 if (mysqli_query($conn, $sql))
		 {
			 
		 }
	 } 
 }
?>
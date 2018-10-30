<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "CouCou";
	  
$conn = new mysqli($servername, $username, $password, $dbname);

// get review id of review to delete
$reviewID = $_POST['reviewID'];

// delete selected review using the review id
$sql = "DELETE FROM Review WHERE reviewID = '$reviewID'";

if (mysqli_query($conn, $sql))
{
	
}
?>
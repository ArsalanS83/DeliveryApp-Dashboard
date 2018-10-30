<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "CouCou";
						   
$conn = new mysqli($servername, $username, $password, $dbname);
						
// obtain the order ID from the button that was selected
$theOrderID = $_POST['orderIDButton'];

// convert order id into a string
$string = substr($theOrderID,6,2);

// obtain integer representing order id
$FinalOrderID = trim($string,":");

// check if additional requirements exist for the selected order id
// if they exist send a response to the client with the additional requirements as a string
// otherwise send a 'none' response to the client indicating there are no additional requirements for the chosen order

$sql = "SELECT additionalRequirements FROM Order WHERE orderID = '$FinalOrderID'";
$result = mysqli_query($conn, $sql);
						
if (mysqli_num_rows($result) > 0)
{
	while($row = mysqli_fetch_assoc($result))
	{
		$response = $row["additionalRequirements"];
		echo $response;
	}
}
else
{
	echo "None";
}					
?>
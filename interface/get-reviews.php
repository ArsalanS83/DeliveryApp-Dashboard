<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "CouCou";
	  
$conn = new mysqli($servername, $username, $password, $dbname);

// retrieve all review data where staff have not responded yet
$sql = "SELECT reviewID, Customer.firstName, Customer.lastName, rating, MenuItem.itemName, description FROM Review INNER JOIN Customer ON Customer.customerID = Review.customerID INNER JOIN MenuItem ON Review.itemID = MenuItem.itemID WHERE staffResponse IS NULL";
			
$result = mysqli_query($conn, $sql);

// output review data separated by a | symbol		
if (mysqli_num_rows($result) > 0)
{
	while($row = mysqli_fetch_assoc($result))
	{
		// display the review id
		echo $row["reviewID"];
		echo "|";
		
		// display the first name of the customer who submitted the review
		echo $row["firstName"];
		echo "|";
		
		// display the last name of the customer who submitted the review
		echo $row["lastName"];
		echo "|";
		
		// display the rating for the menu item
		echo $row["rating"];
		echo "|";
		
		// display the menu item name
		echo $row["itemName"];
		echo "|";
		
		// display the review description submitted by the customer
		echo $row["description"];
		echo "|";
	}
}
?>
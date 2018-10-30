<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "CouCou";
	  
$conn = new mysqli($servername, $username, $password, $dbname);

// get order id of selected order
$orderID = $_POST['orderID'];

$abc = "SELECT extraID FROM OrderItems WHERE orderiD = '$orderID'";

$ans = mysqli_query($conn, $abc);

if (mysqli_num_rows($ans) > 0)
{
	while($row = mysqli_fetch_assoc($ans))
	{
		if (is_null($row["extraID"]))
	    {
	    	$cde = "SELECT MenuItem.itemName,OrderItems.itemQuantity FROM MenuItem JOIN OrderItems ON MenuItem.itemID = OrderItems.itemID WHERE OrderItems.orderID = '$orderID'";

	    	$theRes = mysqli_query($conn, $cde);

	    	if (mysqli_num_rows($theRes) > 0)
	        {
	        	while($row = mysqli_fetch_assoc($theRes))
	        	{
	        		// display the menu item name
					echo $row["itemName"];
					echo "|";
		
					// display the quantity of the menu item
					echo $row["itemQuantity"];
					echo "|";

					// display no extra selected
					echo "No Extra Selected";
					echo "|";
	        	}
	        }
	    }
	    else
	    {

			// retrieve all menu items, quantities ordered and extras ordered using the obtained order id
			$sql = "SELECT MenuItem.itemName, OrderItems.itemQuantity, Ingredient.ingredientName FROM MenuItem JOIN OrderItems ON MenuItem.itemID = OrderItems.itemID JOIN Ingredient ON OrderItems.extraID = Ingredient.ingredientID WHERE OrderItems.orderID = '$orderID'";
			
			$result = mysqli_query($conn, $sql);
			
			if (mysqli_num_rows($result) > 0)
			{
				while($row = mysqli_fetch_assoc($result))
				{
					// display the menu item name
					echo $row["itemName"];
					echo "|";
		
					// display the quantity of the menu item
					echo $row["itemQuantity"];
					echo "|";
		
					// display any extra's selected for the menu item
					echo $row["ingredientName"];
					echo "|";		
				}
			}

	    }
	}
}

// retrieve additional requirements for selected order
$qry = "SELECT additionalRequirements FROM Orders WHERE orderID = '$orderID'";

$res= mysqli_query($conn, $qry);

if (mysqli_num_rows($res) > 0)
{
	while($row = mysqli_fetch_assoc($res))
	{
		// display the additional requirements for the selected order
		echo $row["additionalRequirements"];
		echo "|";
	}
}
?>
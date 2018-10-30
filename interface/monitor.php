<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Monitor Customer Reviews</title>
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
	<link rel="stylesheet" href="css/jquery.rateyo.css"/>
  </head>
  <body onload="getReviews()">
	<script src="js/jquery-1.11.3.min.js"></script>
	<script src="js/jquery.rateyo.js"></script>
	<img src="images/Logo.jpg" alt="CouCou Logo" class="img-rounded img-responsive" id="logo">
	
	<div class="header">
		<p id="welcomeText">Monitor Customer Reviews</p>
	</div>
	
	<div id="loggedIn">
			 
	 <?php
		
		$servername = "localhost";
 		$username = "root";
 		$password = "root";
 		$dbname = "CouCou";
	  
 		$conn = new mysqli($servername, $username, $password, $dbname);
		
		// get staff username from the session
		$username = $_SESSION["username"];
		
		// get logged in staff member's first name and surname based on logged in staff member's username
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

	<div class="review-area">
	
	<table id="reviewTable" class="table table-striped">
    	<thead>
      		<tr>
      			<th>Review Number</th>
       			<th>First Name</th>
        		<th>Surname</th>
       			<th id="rating">Rating</th>
       			<th>Menu Item</th>
       			<th>Review Description</th>
      		</tr>
    	</thead>
    	<tbody>
    		
    	</tbody>
	</table>
		
	</div>
	
	<div class="response-area">
		<h2 id="responseNumber">No Reviews To Respond To</h2>
		<textarea style="visibility:hidden;" class="form-control" id="response"></textarea>
		<button style="visibility:hidden;" type="submit" class="btn btn-lg btn-default button" id="saveResponse" onclick="submitResponse()">Save Response</button>	
	</div>
	
	<script src="js/bootstrap.js"></script>
	
	<script>
		
		// display the current time which dynamically updates
		function startTime() {
			var today = new Date();
    		document.getElementById('theTime').innerHTML = today.toLocaleTimeString();
			var t = setTimeout(startTime, 500);
		}

		startTime();
		
		// display today's date
		var d = new Date();
		document.getElementById("theDate").innerHTML = d.toDateString();
		
		// retrieve all reviews from the database
		// update table with the review data
		function getReviews() {
			
			var xmlHTTPRequest = new XMLHttpRequest();
			
			xmlHTTPRequest.onreadystatechange = function()
			{
				if (xmlHTTPRequest.readyState == 4 && xmlHTTPRequest.status == 200)
				{
					// retrieved review data as a complete string separated by the | symbol
					var reviewData = xmlHTTPRequest.responseText;
				  
					// extract each review data component
				    var theData = reviewData.split("|");
					
					// get access to the review table
					var table = document.getElementById("reviewTable").getElementsByTagName('tbody')[0];
					
					// row number of table to display the reviews in
					var rowNum = 0;
					
					// review number used to assign each row with a review number
					var reviewNum = 1;
					
					// populate review table with review data
					for (var i = 0; i < theData.length-1; i++)
					{
						// insert new row into the table
						var row = table.insertRow(rowNum);
					  
						// display review number
					    row.insertCell(0).innerHTML = reviewNum;
						reviewNum++;
					    i++;
						
						// display the first name of the customer who submitted the review
					    row.insertCell(1).innerHTML = theData[i];
					    i++;
						
						// display the last name of the customer who submitted the review
					    row.insertCell(2).innerHTML = theData[i];
					    i++;
						
						// display star rating of menu item
					    row.insertCell(3).innerHTML = "<div id=" + rowNum + ">";
						
						// generate star rating graphic using the row number as the id value
						// this is so multiple star rating graphics can be shown per row in the table
						// this is because id values have to be unique
						$("#"+rowNum).rateYo({
							rating: theData[i],
							readOnly: true
						});

					    i++;
						
						// display the menu item name
					    row.insertCell(4).innerHTML = theData[i];
					    i++;
						
						// display the review description submitted by the customer
					    row.insertCell(5).innerHTML = theData[i];
					  
						// create select review button for the row in the table
                        row.insertCell(6).innerHTML = "<button type=\"button\" id=\"selectReview\" onclick=\"start(this)\"  class=\"btn btn-lg btn-default interfaceButton\">Select Review</button>";
					  
						// create delete review buttons for the row in the table
					    row.insertCell(7).innerHTML = "<button type=\"button\" id=\"deleteReview\"  onclick=\"deleteReview(this)\"  class=\"btn btn-lg btn-default interfaceButton\">Delete Review</button>";
					  
						// increment the row number to allow the next review, if available to be inserted into the table
					    rowNum++;  
				  }
					
					// by default select 1st review to respond to
					// simulates clicking 1st review to respond to
					document.getElementById("selectReview").click(1);	
				}
			}
			
			// send AJAX request to server to get all customer reviews from the database
			xmlHTTPRequest.open("GET","get-reviews.php",true);
			xmlHTTPRequest.send();
		}
		
		// initialises review response area
		// displays review response header to match the selected review's review number
		// displays response text area and save response button
		function start(i)
		{
			// get row number of selected review
			var index = i.parentNode.parentNode.rowIndex;
			
			// display review number that is being responded
			document.getElementById("responseNumber").innerHTML = "Review " + index + ": Response";
			
			// make the response text area and save response button visible
			document.getElementById("response").style.visibility = "visible";
			document.getElementById("saveResponse").style.visibility = "visible";
		}
		
		// saves staff review response to database
		function submitResponse()
		{
			// get the selected review id from the "review 'number' response" header 
			var reviewID = document.getElementById("responseNumber").innerHTML;
			
			// extract the review id by obtaining the substring of the header text
			var theID = reviewID.substring(7,8);
			
			// get the staff's response
			var reviewDesc = document.getElementById("response").value;
			
			// if no response was entered - alert staff member
			if (reviewDesc == "")
			{
				alert("Error: No Response Entered!");
			}
			else
			{
				var responseRequest = new XMLHttpRequest();
				
				responseRequest.onreadystatechange = function()
				{
					if (responseRequest.readyState == 4 && responseRequest.status == 200)
					{
						// delete the review from the database
						// alert staff member that response was saved
						// reset selected review to first review
						// clear response text area
						alert("Response Saved!");
					 	document.getElementById("orderTable").deleteRow(theID);
					 	var reviewNum = document.getElementById("reviewTable").rows[1].cells[0].innerHTML;
					 	document.getElementById("responseNumber").innerHTML = "Review " + reviewNum + ": Response";
					 	document.getElementById("response").value="";
					}
				}

				// send AJAX request to the server to save the staff's review response into the database
				// send the review id and the staff's review response as parameters to the request
				responseRequest.open("POST","save-response.php",true);
				responseRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				responseRequest.send("reviewID="+theID+"&reviewDesc="+reviewDesc);
			}
		}
			
		// deletes selected review from the table and database
		function deleteReview(i)
		{
			// get row number of selected review to delete
			var index = i.parentNode.parentNode.rowIndex;
			
			// get the review id using the row number
			var reviewID = document.getElementById("reviewTable").rows[index].cells[0].innerHTML;
			
			var deleteRequest = new XMLHttpRequest();
			
			deleteRequest.onreadystatechange = function()
			{
				if (deleteRequest.readyState == 4 && deleteRequest.status == 200)
				{
					// delete the selected review from the table 
					document.getElementById("reviewTable").deleteRow(index);
					
					// if there are no reviews left in the table 
					// reload the page 
					if (document.getElementById("reviewTable").getElementsByTagName('tbody')[0].rows.length == 0)
					{
						location.reload();
					}
					
					// set selected review to the first review in the table
					// update response text area
					var reviewNum = document.getElementById("reviewTable").rows[1].cells[0].innerHTML;
					document.getElementById("responseNumber").innerHTML = "Review " + reviewNum + ": Response";
					document.getElementById("response").value="";
				}
			}
		
		 // send AJAX request to the server to delete the selected review from the database
		 // send the review id as the parameter to the request
		 deleteRequest.open("POST","delete-review.php",true);
		 deleteRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		 deleteRequest.send("reviewID="+reviewID);			
		}
	</script>
  </body>
</html>
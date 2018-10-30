<?php
session_start();
?>

<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Welcome</title>
		<link href="css/bootstrap.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="css/animsition.min.css">
		<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
	</head>

	<body>
		<script src="js/jquery-1.11.3.min.js"></script>
		
		<div class="animsition">
			<div class="appHeader">
			<?php
			 
			  $servername = "localhost";
			  $username = "root";
			  $password = "root";
			  $dbname = "CouCou"; 
			  
			  $conn = new mysqli($servername, $username, $password, $dbname);
			  
			  // get the session email 
			  $email = $_SESSION["emailAddress"];
			  
			  // get the first name from the database using the email address of the logged in customer
			  $sql = "SELECT firstName FROM Customer WHERE email= '$email'";
			  $result = mysqli_query($conn, $sql);
				
			  // display a welcome message containing the customer's first name
			  if (mysqli_num_rows($result) > 0) {
				  
				  while($row = $result->fetch_assoc()) {
					  echo "<p id=\"headerText\">". Welcome. " ".$row["firstName"]. "!";
				  } 
			  }
				
				mysqli_close($conn);
			?>
			</div>
			
		<div id="container"></div>	
			
		<div class="welcome-area"> 
			<a href="menu.html" class="btn btn-lg btn-default button welcomeButtons">Order Now</a> 
            <a href="live-track.php" id="trackOrder" class="btn btn-lg btn-default button welcomeButtons">Track Order</a> 
            <a href="write-review.php" id="reviewOrder" class="btn btn-lg btn-default button welcomeButtons">Write Review</a> 
            <a href="review-history-responses.php" id="responses" class="btn btn-lg btn-default button welcomeButtons">Review History and Responses</a> 
            <a href="my-account.html" class="btn btn-lg btn-default button welcomeButtons">My Account</a> 
            <a href="sign-out.php" class="btn btn-lg btn-default button welcomeButtons">Sign Out</a> 
        </div> 

	<script src="js/bootstrap.js"></script>
	<script src="js/animsition.min.js"></script>
	<script>
	  $(document).ready(function() {
		  $(".animsition").animsition({
			  inClass: 'fade-in',
			  outClass: 'fade-out',
			  inDuration: 900,
			  outDuration: 800,
			  linkElement: '.animsition-link',
			  loading: true,
			  loadingParentElement: 'body', 
			  loadingClass: 'animsition-loading',
			  loadingInner: '',
			  timeout: false,
			  timeoutCountdown: 5000,
			  onLoadEvent: true,
			  browser: [ 'animation-duration', '-webkit-animation-duration'],
			  overlay : false,
			  overlayClass : 'animsition-overlay-slide',
			  overlayParentElement : 'body',
			  transition: function(url){ window.location.href = url; }
		  });
	  });
	 </script>
	 <script src="js/progressbar.js"></script> 

	 <script> 
       var bar = new ProgressBar.Circle(container, { 
            color: '#ecf0f1', 
            strokeWidth: 4, 
            trailWidth: 2, 
            easing: 'easeInOut', 
            duration: 1500, 
            text: { 
                 autoStyleContainer: false 
            }, 
            from: { color: '#e74c3c', width: 4 }, 
            to: { color: '#e74c3c', width: 4 }, 
            step: function(state, circle) { 
                 circle.path.setAttribute('stroke', state.color); 
                 circle.path.setAttribute('stroke-width', state.width); 
                 var value = Math.round(circle.value() * 10); 
                 if (value === 0) { 
                      circle.setText(value+' Points'); 
                 } 
                 else 
                 { 
                      circle.setText(value+' Points'); 
                 }
				 
				 if (value == 1)
				 {
					 circle.setText(value+' Point');
				 }
            } 
       }); 
        bar.text.style.fontFamily = 'Source Sans Pro', 'sans-serif'; 
        bar.text.style.fontSize = '2rem';
		 
	<?php 
		  
		  // Get the loyalty points of the logged in user from the database
		 
		  $servername = "localhost"; 
		  $username = "root"; 
		  $password = "root"; 
		  $dbname = "CouCou"; 
		  
		  $conn = new mysqli($servername, $username, $password, $dbname); 
		  
		  // get the session email
		  $email = $_SESSION["emailAddress"];
		 
		  // get the loyalty points of the logged in user using their email address
		  $sql = "SELECT loyaltyPoints FROM Customer WHERE email= '$email'";
		  $result = mysqli_query($conn, $sql);
		  
		  // display the loyalty points of the customer
		  // pass in the value of the points to the JavaScript plugin used to graphically display the user's loyalty points
		  if (mysqli_num_rows($result) > 0) {
			  while($row = $result->fetch_assoc()) {
				  $points = $row["loyaltyPoints"];
				  $points = $points/10;
				  echo "bar.animate(". $points. ");";
			  }
		  }
		 mysqli_close($conn); 
        ?> 
       </script> 
	 
	 
	   <!-- The following scripits are used to check the database to determine whether or not the live track order, write review and view review history and responses buttons should be disabled or enabled -->
	  
	   <script>
		   
		  // This script is used to determine if the logged in customer has a current existing order for today
 		  // The response will determine whether the live track order button should be disabled or not
		   
		  $(document).ready(function(){
			  	   
			   var xmlHTTPRequest = new XMLHttpRequest();
			  
			   // send AJAX request to server to check if the customer has an existing order
			   xmlHTTPRequest.open("GET","get-existing-order.php",true);
			   
			   xmlHTTPRequest.send();
			   
			   xmlHTTPRequest.onreadystatechange = function()
			   {
				   if (xmlHTTPRequest.readyState == 4 && xmlHTTPRequest.status == 200)
				   {
					   // retrieve the response from the server
					   var orderText = xmlHTTPRequest.responseText;
					   
					   // trim any whitespace from the server's response
					   var theResponse = orderText.trim()
					   			   
					   // if the response was "no", disable the live track order button
					   if (theResponse === "no")
					   {
						   $('#trackOrder').addClass('disabled');
						   $('#trackOrder').on('click', function(e) { e.preventDefault(); });
					   }
				   } 
			   }   
		 });
			      
	   </script>
	   
	   <script>
		   
		   // This script is used to determine if the customer has an order that has not been reviewed yet
  		   // This script is used to determine whether or not the Write Review button should be disabled or not
		   
		   $(document).ready(function(){
			   
			   var request = new XMLHttpRequest();
			   
			   // send AJAX request to server to check if the customer has an order that has not been reviewed yet
			   request.open("GET","get-existing-review.php",true);
			   
			   request.send();
			   
			   request.onreadystatechange = function()
			   {
				   if (request.readyState == 4 && request.status == 200)
				   {
					   // retrieve the response from the server
					   var reviewText = request.responseText;
					   
					   // trim any whitespace from the server's response
					   var theResponse = reviewText.trim()
					   				   
					   // if the response was "no", disable the write review button
					   if (theResponse === "no")
					   {
						   $('#reviewOrder').addClass('disabled');
						   $('#reviewOrder').on('click', function(e) { e.preventDefault(); });
					   }
				   } 
			   }
		   });   
	   </script>
	   
	   <script>
		   
		    // This script is used to determine if the customer has an order that has not been reviewed yet
 			// This script is used to determine whether or not the Review History & Responses button should be disabled or not
		   
		    $(document).ready(function(){
			   
			   var req = new XMLHttpRequest();
			   
			   // send AJAX request to server to check if the customer has an order that has not been reviewed yet 
			   req.open("GET","get-existing-response.php",true);
			   
			   req.send();
			   
			   req.onreadystatechange = function()
			   {
				   if (req.readyState == 4 && req.status == 200)
				   {
					   // retrieve the response from the server
					   var reviewText = req.responseText;
					   
					   // trim any whitespace from the server's response
					   var theResponse = reviewText.trim()
					   				   
					   // if the response was "no", disable the review history and responses button
					   if (theResponse === "no")
					   {
						   $('#responses').addClass('disabled');
						   $('#responses').on('click', function(e) { e.preventDefault(); });
					   }
				   } 
			   }
		   });   
	   </script>
	</body>
</html>
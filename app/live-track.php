<?php
session_start();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Live Track Order</title>
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="css/animsition.min.css">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
  </head>
  <body>
	<script src="js/jquery-1.11.3.min.js"></script>
	
	<div class="animsition">
	
		<div class="appHeader">
			<p id="headerText">Live Track Order</p>
		</div>
	
		<div class="back-button">
			<a href="welcome.php"><img src="images/back.png" height="50" width="50" alt="Back Button" class="img-rounded img-responsive"></a>
		</div>
		
		<div class="area">
			<p id="notify">Order Status Updates Automatically</p>

			<div id="progress"></div>

			<p id="message"></p>
			
			<img id="trackingImage" width="200" height="200" class="img-rounded img-responsive">
		</div>
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
		  
		  // progressbar.js@1.0.0 version is used
		  // Docs: http://progressbarjs.readthedocs.org/en/1.0.0/

		  var bar = new ProgressBar.Line(progress, {
  		  strokeWidth: 10,
  		  easing: 'easeInOut',
  		  duration: 500,
  		  color: '#e74c3c',
  		  trailColor: '#ecf0f1',
  		  trailWidth: 10,
  		  svgStyle: {width: '100%', height: '100%'}
		  });
		  
		  setInterval(function(){
			    
		  // determine value of a num variable from an AJAX request to the server to get the order status number
		  // if status is ordered then num = 0.2
		  // if status is preparing then num = 0.4
		  // if status is cooking then num  = 0.6
		  // if status is out for delivery then num = 0.8
		  // if status is delivered then num = 1.0
		  // update the progress bar length, display the relevant message and display the relevant image 
		  
		  var xmlHTTPRequest = new XMLHttpRequest();
		  
		  xmlHTTPRequest.onreadystatechange = function()
		  {
			  if (xmlHTTPRequest.readyState == 4 && xmlHTTPRequest.status == 200)
			  {
				  // get the num response representing the order status from the server
				  var num = xmlHTTPRequest.responseText;
				  
				  // Set the length of the progress bar based on the num response
				  bar.animate(num);   
				  
				  if (num == 0.2)
				  {
					  document.getElementById("message").innerHTML = "Order Recieved!";
  					  document.getElementById('trackingImage').src='images/tick.png';
		          }

		  		  if (num == 0.4)
		  		  {
					  document.getElementById("message").innerHTML = "Preparing Your Order!";
  					  document.getElementById('trackingImage').src='images/preparing.jpg';
		  	      }
		  
		  		  if (num == 0.6)
		  		  {
					  document.getElementById("message").innerHTML = "Your Food Is Cooking!";
  					  document.getElementById('trackingImage').src='images/cooking.jpg';
		  		  }
		  
		  		  if (num == 0.8)
		  		  {
					  document.getElementById("message").innerHTML = "Out for Delivery!";
  					  document.getElementById('trackingImage').src='images/delivery.png';
		  		  }
		  
		  		  if (num == 1.0)
		  		  {
					  document.getElementById("message").innerHTML = "Order Delivered! Tuck In!";
  					  document.getElementById('trackingImage').src='images/delivered.png';
		  		  }  
			  }
			  else
			  {

			  }
		  }
		  
		  xmlHTTPRequest.open("GET","get-order-status.php",true);
		  xmlHTTPRequest.send();
  
		  }, 500);
	  </script> 
  </body>
</html>
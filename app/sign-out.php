<?php
session_start();
?>

<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Signed Out</title>
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="css/animsition.min.css">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
</head>

<body>
	<script src="js/jquery-1.11.3.min.js"></script>
	
	<?php
	  
		  // remove all session variables
		  session_unset(); 

		  // destroy the session 
		  session_destroy(); 
		  
		  // Display sign out confirmation message and image
		  // redirect to the user to the home page after 2 seconds
		  echo "<div class=\"animsition\">";
		  echo "<div class=\"appHeader\">";
		  echo "<p id=\"headerText\">Signed Out!</p>";
		  echo "</div>";
		  
		  echo "<div class=\"signup-handler-area\">";
		  echo "<img id=\"handler-image\" src=\"images/tick.png\" width=\"150\" height=\"150\">";
		  echo "</div>";
		  echo "<p id=\"responseText\">Redirecting to Login Page in 2 Seconds...";
		  
		  echo "<script>setTimeout(function(){window.location.href='login.html'},2000);</script>";
	?>
	
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
</body>
</html>
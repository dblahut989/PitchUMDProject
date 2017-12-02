<?php

	$email = "";
	$loggedIn = false;
	$correctInfo = false;

	session_start();

	if (isset($_SESSION['loggedIn'])){
		$loggedIn = true;
	# if the user has not successfully logged in we need to check their credentials
	} elseif(isset($_POST['loginButton'])){
		$email = $_POST['email'];
		if ($_POST['email'] == "test@example.com" && $_POST['password'] == "terps"){
			$correctInfo = true;
		}
	}

	if ($loggedIn || $correctInfo){

		$_SESSION['loggedIn'] = "yes";
		$_SESSION['email'] = $email;
		header("Location: Main.php");

	} 

	$body = <<<BODY
		<!doctype html>
	    <html>
	        <head> 
	            <meta charset="utf-8" />
	            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	            <title>Login Page</title>	
	            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

	        </head>

	        <body>
	        	<section id="cover">
				    <div id="cover-caption">
				        <div id="container" class="container">
				            <div class="row">
				                <div class="col-sm-10 offset-sm-1 text-center"><br>
				                    <h1 class="display-3">Welcome to Pitch UMD!</h1>
				                    <div class="info-form">
				                        <form action="{$_SERVER["PHP_SELF"]}" method="post">
											<br><img id="pics" src="McKeldin.jpg" ALT=\"some text\" WIDTH=400 HEIGHT=250><br><br>
											<strong>Email:&nbsp &nbsp &nbsp &nbsp </strong><input type="email" name="email" value="$email"><br><br>
											<strong>Password: </strong><input type="password" name="password" /><br><br>
											<input type="submit" name="loginButton" value="LOGIN"/>&nbsp &nbsp
											<button type="submit" formaction="CreateAccount.php">Create Account</button>

BODY;

	if (isset($_POST["loginButton"])){
		$body .= "<br><br> <strong>Invalid Infomation provided</strong>";
		$body .= "<br><button type=\"submit\" formaction=\"ForgotPassword.php\">Forgot Password?</button>";
	}

	$body .= "</form></div></div></div></div></div></body></html>";

	$_SESSION['email'] = $email;

	echo $body;

?>


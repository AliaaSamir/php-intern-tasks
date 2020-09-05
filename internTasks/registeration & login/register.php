<?php
//check for errors
$errors_arr = array();
if(isset($_GET['error_fields'])){
	$errors_arr = explode(",", $_GET['error_fields']);
}

?>

<html>
	<head>
		<title>Register</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body>
		<form method="post" action="process.php">
			<div class="container">

			<h1>Register</h1>
		    	<p>Please fill in this form to create an account.</p>
		    <hr>
			<label for="name"><b>Name</b></label>
			<br />
			<input type="text" name="name" id="name" required/><?php if( in_array("name", $errors_arr)) echo "* please enter your name"; ?>
			<br />

			<label for="email"><b>Email</b></label>
			<br />
			<input type="email" name="email" id="email" required/><?php if( in_array("email", $errors_arr)) echo "* please enter a valid email"; ?>
			<br />

			<label for="password"><b>Password</b></label>
			<br />
			<input type="password" name="password" id="password" required/><?php if( in_array("password", $errors_arr)) echo "* please enter password not less than 6 characters"; ?>
			<br />


			<label for="phone_number" ><b>Phone Number</b></label>
			<br />	
			<input type="number" name="phone_number" id="phone_number" required /><?php if( in_array("phone_number", $errors_arr)) echo "* please enter your Phone Number "; ?>
			<br />

			<label for="address"><b>Address</b></label>
			<br />
			<input type="text" name="address" id="address" required/><?php if( in_array("address", $errors_arr)) echo "* please enter your address"; ?>
			<br />

			<input type="submit" name="submit" value="Submit" class="button" />
			<br />
			</div>

			<div class="container signin">
			    <p>Already have an account? <a href="login.php">Login</a>.</p>
			</div>
		</form>
	</body>
</html>
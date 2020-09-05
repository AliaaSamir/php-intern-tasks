<?php
	require 'src\User.php';
	//start session
	session_start();

	if($_SERVER['REQUEST_METHOD'] == 'POST'){

		$user = new User();
		$result = $user->getUser($_POST['email']);
		
		//var_dump( $result);

		if( $result &&  password_verify($_POST['password'], $result['user_pass'])){
			//var_dump( $result);
			//echo password_verify($_POST['password'], $result['user_pass']);
		
			$_SESSION['id'] = $result['user_id'];
			$_SESSION['name'] = $result['user_name'];
			header("Location: home.php");
			exit;
		}else{
			//echo $_POST['email'];
			$error_msg = "Invalid  email or password Try Again.";
		}
	
	}
?>

<html>
	<head>
		<title>Login</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body>
		
		<form method="post">
		<div class="container">
			<h1>Login</h1>
		    	<p><?php if(isset($error_msg)) echo $error_msg; else echo "Enter your Email and Password."; ?></p>
		    <hr>

			<label for="email"><b>Email</b></label>
			<br />
			<input type="email" name="email" id="email" value="<?= (isset($_POST['email'])? $_POST['email'] : ''); ?>" required>
			<br />

			<label for="password"><b>Password</b></label>
			<br />
			<input type="password" name="password" id="password" required>
			<br />
			<input type="submit" name="submit" value="Login" class="button" required>
			<br />
		</div>
		<div class="container signin">
			    <p>Haven't an account? <a href="register.php">Register</a>.</p>
		</div>
		</form>
	</body>
</html>
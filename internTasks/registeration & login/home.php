<?php
/*	session_start();
	if(isset($_SESSION['id'])){
		echo '<h1> Welcome '.$_SESSION['name'].' <a href="logout.php">Logout </a> <h1>';
	}else{
		header("Location: login.php");
		exit;
	}
*/


?>


<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css\style.css">

</head>
<body>
	<h1>Welcome 
	<?php
		session_start();
		if(isset($_SESSION['id'])){ 
			echo '<em>'.  $_SESSION['name'] .'</em>' ?> </h1>
			<hr>
			<h3>Do you want to </h3>
			<form method="post">
				<input  type="submit"  class="button"  name="logout"  value="Logout" />
			</form>
		<?php
		}else{
			?>
		</h1>
		<hr>
		<h3>Do you want to </h3>	
		<form method="post">
		<input  type="submit"  class="button" name="login"  value="Login" />
	
		<input  type="submit"  class="button" name="register"  value="Register" />
		</form>
		<?php
		}


		function logoutfun()
		{
			header("Location: logout.php");
			exit;		
		}

		function loginfun()
		{
			header("Location: login.php");
			exit;
		}

		function registerfun()
		{
			header("Location: register.php");
			exit;
		}


		if(array_key_exists('logout',$_POST)){
			logoutfun();
		}
		elseif (array_key_exists('login',$_POST)) {
			loginfun();
		}elseif (array_key_exists('register',$_POST)) {
			registerfun();
		}

	?>
</body>
</html>

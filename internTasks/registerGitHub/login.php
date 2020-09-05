<?php
	require 'src\User.php';
	require 'OAuthGitHub.php';
	//require 'githubConfig.php';
	//start session
	session_start();

	$github_config = array(
		'client_id' => 'a5f5b109b9f05b558baf',
		'client_secret' => 'dd1ad112696a6c91e39d301a57346977c6a2e14e',
		'redirect_uri'  => 'http://localhost/intern%20tasks/registergithub/login.php' );
		 $oauthGithub = new OAuthGitHub($github_config);

	if( isset($_SESSION['username'])){
		$error_msg = $_SESSION['username'].", You already have an account, try to Login";
	}

	if ($_SERVER['REQUEST_METHOD'] == 'GET'){

		if(isset($_GET['code']) && !empty($_GET['code']) ){

			$response = $oauthGithub->getAccessToken($_GET['code']);
			if(isset($response->access_token) ){
				$_SESSION['access_token'] = $response->access_token;
				$_SESSION['token_type'] = $response->token_type;
				//echo $response->access_token;
				header("Location: save_data.php");
			}else{
				$error_msg = "An Error ocurred, Try Again";
			}
		}
	}

	if($_SERVER['REQUEST_METHOD'] == 'POST'){

		$user = new User();
		$result = $user->getUser($_POST['username']);
		
		//var_dump( $result);

		if( $result &&  password_verify($_POST['password'], $result['password'])){
			//var_dump( $result);
			//echo password_verify($_POST['password'], $result['user_pass']);
		
			$_SESSION['id'] = $result['id'];
			$_SESSION['username'] = $result['username'];
			header("Location: home.php");
			exit;
		}else{
			//echo $_POST['username'];
			$error_msg = "Invalid  username or password Try Again.";
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
		    	<h3><?php if(isset($error_msg)) echo $error_msg; else echo "Enter your Username and Password."; ?></h3>
		    <hr>

			<label for="username"><b>Username</b></label>
			<br />
			<input type="username" name="username" id="username" value="<?= (isset($_SESSION['username'])? $_SESSION['username'] : ''); ?>" />
			<br />

			<label for="password"><b>Password</b></label>
			<br />
			<input type="password" name="password" id="password" required/>
			<br />
			<input type="submit" name="submit" value="Login" class="button" />
			<br />
		</div>
		<div class="container signin">
			    <p>Haven't an account? <a href="<?php  echo $oauthGithub->requestUserIdentity(); ?>" >Register using GitHub</a>.</p>
		</div>
		</form>
	</body>
</html>
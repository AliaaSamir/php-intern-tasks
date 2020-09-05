<?php

	require 'OAuthGitHub.php';
	require 'src\User.php';

	session_start();

	//echo "Hello! redirected Here! <br>";

	$github_config = array(
			'client_id' => 'a5f5b109b9f05b558baf',
			'client_secret' => 'dd1ad112696a6c91e39d301a57346977c6a2e14e',
			'redirect_uri'  => 'http://localhost/intern%20tasks/registergithub/login.php' );

	$oauthGithub = new OAuthGitHub($github_config);
	$user = new User();
	$user_data = array();

	//if ($_SERVER['REQUEST_METHOD'] == 'GET'){

	if(isset($_SESSION['access_token']) ){
		$user_github_data =$oauthGithub->requestApiData($_SESSION['access_token'], $_SESSION['token_type']);
		$_SESSION['username'] = $user_github_data->login;

		if($user->getUser($user_github_data->login)){	
			header("Location: login.php");
			exit;
		}
		$user_data['username'] = $user_github_data->login;
		$user_data['avatar_url'] = $user_github_data->avatar_url;
		$user_data['github_url'] = $user_github_data->url;

		if(isset($user_github_data->email)) $user_data['email'] = $user_github_data->email;
	}
	//}
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		if(( isset($_POST['password']) && (strlen($_POST['password']) > 5) &&
			isset($_POST['psw-repeat'])) ){
			
			if( $_POST['password'] === $_POST['psw-repeat']){
				
				$password = password_hash( $_POST['password'], PASSWORD_DEFAULT);
				$user_data['password'] = $password;


				//echo $user_data['username'].'<br>'.$user_data['avatar_url'].'<br>'.$user_data['github_url'].'<br>'.$user_data['password'].'<br>';

				$user_id = $user->addUser($user_data);
				if( $user_id !== null){
					$_SESSION['id'] = $user_id;
					header("Location: login.php");
					exit;
				}
			}else{
				$error_msg = "Make sure you entered right password.";
			}
		}else{
			//echo $_POST['email'];
			$error_msg = "Invalid  username or password Try Again.";
		}
	
	}



?>

<!DOCTYPE html>
<html>
<head>
	<title>Create password</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<form method="post">
	<div class="container">
		<h1>Password</h1>
		<p><?php if(isset($error_msg)) echo $error_msg; else echo "Please create your password."; ?></p>
		<hr> 

		<label for="username"><b>username</b></label>
		<input type="text"  name="username" id="username" value="<?= (isset($_SESSION['username'])? $_SESSION['username'] : ''); ?>" readonly>
		<br>
		<label for="password"><b>Password</b></label>
		<input type="password" placeholder="Enter Password" name="password" id="password" required>
		<br>
		<label for="psw-repeat"><b>Confirm Password</b></label>
		<input type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat" required>
		<br>
		<button type="submit" class="button">Submit</button>
	</div>

	</form>

</body>
</html>
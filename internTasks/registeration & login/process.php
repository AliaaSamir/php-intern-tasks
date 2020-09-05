<?php
	session_start();
	require 'src\User.php';

	//validation
	$error_fields = array();
	if(! ( isset($_POST['name']) && !empty($_POST['name']) ) ){
		$error_fields[] = "name";
	}
	if(! ( isset($_POST['email']) && filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL) ) ){
		$error_fields[] = "email";
	}
	if(! ( isset($_POST['password']) && (strlen($_POST['password']) > 5) ) ){
		$error_fields[] = "password";
	}

	if(! (isset($_POST['phone_number']) && !empty($_POST['phone_number']) ) ){
		$error_fields[] = "phone_number";
	}

	if(! ( isset($_POST['address']) && !empty($_POST['address']) ) ){
		$error_fields[] = "address";
	}

	if($error_fields){
		header("Location: register.php?error_fields=".implode(",", $error_fields));
		exit;
	}


	$password = password_hash( $_POST['password'], PASSWORD_DEFAULT);


	$user_data = array(  "user_name"  => $_POST['name'], 
				    "user_email" => $_POST['email'],
					"user_pass"  => $password,
					"user_phone" => $_POST['phone_number'],
					"user_address" => $_POST['address']);


	$user = new User();
	$result = $user->getUser($user_data['user_email']);
	if($result){
		$error_fields[] = "email";
		header("Location: register.php?error_fields=".implode(",", $error_fields));
		exit;
	}else{
		$user_id = $user->addUser($user_data);

		if( $user_id !== null){
			$_SESSION['id'] = $user_id;
			$_SESSION['name'] = $user_data['user_name'];
			/*echo'
			   <script>
			   window.onload = function() {
			      alert("Thank you, you have successfully registered");
			      location.href = "index.php";  
			   }
			   </script>
			';*/
			echo "Thank you, you have registered successfully ";
			echo "<script>setTimeout(\"location.href = 'home.php';\",1500);</script>";
			exit;
		}
	}
	

?>




<?php


class OAuthGitHub{
	/*
	 * Configuration and setup GitHub API
	 */
	public $authorizeURL = "https://github.com/login/oauth/authorize";   
	public $tokenURL     = "https://github.com/login/oauth/access_token";
	public $apiURLBase   = "https://api.github.com/";
	public $clientID     ;
	public $clientSecret ;
	public $redirectURL  ;



	function __construct(array $config = []){
	        $this->clientID = isset($config['client_id']) ? $config['client_id'] : '';
	        if(!$this->clientID){
				die('Required "client_id" key not supplied in config');
	        }
	        
	        $this->clientSecret = isset($config['client_secret']) ? $config['client_secret'] : '';
	        if(!$this->clientSecret){
				die('Required "client_secret" key not supplied in config');
	        }
	        
	        $this->redirectUri = isset($config['redirect_uri']) ? $config['redirect_uri'] : '';
	}


	/*
	 * Request User Identity from GitHub to register with it
	 */
	function requestUserIdentity(){
		$data = array(
			'client_id' => $this->clientID,
			'redirect_uri' => $this->redirectURL,
			'scope' => "user"
		);
		$url = sprintf("%s?%s", $this->authorizeURL, http_build_query($data));
	    return $url;
	}


	/*
	 * Get Access token for loged in User
	 */
	function getAccessToken($code){

		$curl = curl_init();

		$data = array(
			'client_id' => $this->clientID,
			'client_secret' => $this->clientSecret,
			'code' => $code,
			'redirect_uri' => $this->redirectURL
		);
		curl_setopt($curl, CURLOPT_URL, $this->tokenURL);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
		          'Content-Type: application/json',
		          'Accept: application/json'
		       ));
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);
		curl_close($curl);
		// Process your response here
		$arrayResponse = json_decode($response);
		//var_dump($arrayResponse);
		
		return $arrayResponse;
	}


	/*
	 * Get user data from GitHub API 
	 */
	function requestApiData($access_token, $token_type){

		$curl = curl_init();

		curl_setopt($curl, CURLOPT_URL, $this->apiURLBase.'user');
		//echo "<br>".$this->apiURLBase.'user'."<br>";
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Authorization: '.$token_type.' '. $access_token,	
			'Content-Type: application/json',
			'User-Agent: register GitHub OAuth'
		          //'Accept: application/vnd.github.v3+json'
		       ));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);
		curl_close($curl);

		$arrayResponse = json_decode($response);
		//var_dump($arrayResponse);
		return $arrayResponse;
	}


}
?>
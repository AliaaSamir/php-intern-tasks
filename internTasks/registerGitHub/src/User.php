<?php 
require 'MySqlAdapter.php';
require 'database_config.php';

class User extends MySqlAdapter{
	//set table name 
	private $_table = 'github_users';

	public function __construct(){
		//add from databse config file
		global $config;

		parent::__construct($config);
	}

	// associative array of data 
	public function addUser(array $user_data){
		//echo "Hello from our function";
		return ( $this->insert($this->_table, $user_data) );
	}


	public function getUser($username){

		///and `user_pass` = '".$user_pass."' 
		$this->select($this->_table, "`username` = '".$username."'  LIMIT 1 ");
		return $this->fetch();
	}


}
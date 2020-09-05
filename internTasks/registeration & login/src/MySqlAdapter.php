<?php
//ORM Class
class MySqlAdapter{
	
	protected $_config = array();
	protected $_link;
	protected $_result;

	/*
	** Constructor	
	*/
	public function __construct(array $config){
		if(count($config) != 4){
			throw new InvalidArgumentException('Invalid number of connection parameters. ');
		}
		$this->_config = $config;	
	}

	/*
	** Connect to MySQL
	*/
	public function connect(){
		//connect once
		if( $this->_link === null ){
			list($host, $user, $password, $database) = $this->_config;
			if(! ($this->_link = @mysqli_connect($host, $user, $password, $database) ) ){
				throw new RuntimeException("Error connecting to server: ". mysqli_connect_error() );
			}
			unset($host, $user, $password, $database);
		}
		return $this->_link;
	}

	/*
	** Execute Query
	*/
	public function query($query){
		if (!is_string($query) || empty($query)) {
			throw new InvalidArgumentException("Invalid Query");
		}
		// lazy connect to mysql
		$this->connect();
		if( ! $this->_result = mysqli_query($this->_link, $query) ){
			throw new RuntimeException("Error executing the specified query : ".$query.mysqli_error($this->_link) );
		}
		return $this->_result;
	}

	/*
	** Perform a SELECT statment
	*/
	public function select($table, $where = '', $fields = '*', $order = '', $limit = null, $offset = null){
		$query = 'SELECT ' . $fields . ' FROM ' . $table
				. (($where) ? ' WHERE ' . $where : '' )
				. (($limit) ? ' LIMTT ' . $limit : '' )
				. (($offset && $limit) ? ' OFFSET ' . $offset : '' )
				. (($order) ? ' ORDER BY ' . $order : '' );
		$this->query($query);
		return $this->countRows();
	}

	/*
	** Perform an INSERT statment
	* table name , data as associative array
	*/
	public function insert($table, array $data){
		$fields = implode(',', array_keys($data));
		$values = implode(',', array_map( array($this, 'quoteValue'), array_values($data) ) );
		$query = 'INSERT INTO ' . $table . ' (' . $fields . ') VALUES (' . $values . ')'; 
		$this->query($query);
		return $this->getInsertID();
	}

	/*
	** Perform an UPDATE statment
	*/
	public function update($table, array $data, $where = ''){
		$set = array();
		foreach ($data as $field => $value) {
			$set[] = $field . "=" . $this->quoteValue($value);
		}
		$set = implode(',', $set);
		$query = 'UPDATE ' . $table . ' SET ' . $set
				. (($where) ? ' WHERE ' . $where : '' );
		$this->query($query);
		return $this->getAffectedRows();
	}

	/*
	** Perform a DELETE statment
	*/
	public function delete($table, $where = ''){
		$query = 'DELETE FROM ' . $table
				. (($where) ? ' WHERE ' . $where : '' );
		$this->query($query);
		return $this->getAffectedRows();
	}


	/*
	** Escape Specified values
	*/
	public function quoteValue($value){
		$this->connect();
		if($value === null){
			$value = 'NULL';
		}
		elseif (! is_numeric($value)) {
			$value = "'" . mysqli_real_escape_string($this->_link, $value) . "'";
		}
		return $value;
	}

	/*
	** fetch a single row from the current result as an associative array 
	*/
	public function fetch(){
		if($this->_result !== null){
			if( ($row = mysqli_fetch_array($this->_result, MYSQLI_ASSOC) ) === false){
				$this->freeResults();
			}
			return $row;
		}
		return false;
	}

	/*
	** fetch all row from the current result as an associative array 
	*/
	public function fetchAll(){
		if($this->_result !== null){
			if( ($all = mysqli_fetch_all($this->_result, MYSQLI_ASSOC) )=== false){
				$this->freeResults();
			}
			return $all;
		}
		return false;
	}

	/*
	** Get the insertion ID
	*/
	public function getInsertID(){
		return $this->_link !== null ? mysqli_insert_id($this->_link) : null;
	}
	
	/*
	** Get the number of rows returned by the current result set
	*/
	public function countRows(){
		return ($this->_result !== null) ? mysqli_num_rows($this->_result) : 0;
	}

	/*
	** Get number of affected rows
	*/
	public function getAffectedRows(){
		return $this->_link !== null ? mysqli_affected_rows($this->_link) : 0;
	}

	/*
	** Free up current result 
	*/
	public function freeResults(){
		if( $this->_result === null){
			return false;
		}
		mysqli_free_result($this->_result);
		return true;
	}

	/*
	** disconnect explicitly 
	*/
	public function disconnect(){
		if( $this->_link === null){
			return false;
		}
		mysqli_close($this->_link);
		$this->_link = null;
		return true;
	}

	/*
	** Close automatically the database connection when the instance of the class is destroyed
	*/
	public function __destruct(){
		$this->disconnect();
	}





}
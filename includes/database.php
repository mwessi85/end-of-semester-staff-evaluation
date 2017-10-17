<?php
	class MySQLDatabase{
		protected $_connection;
		public $last_query;
		function __construct(){
			$this->open_connection();
		}
		public function open_connection(){
			$dsn = "mysql:host=".DB_SERVER.";dbname=".DB_NAME;
			$this->_connection = new PDO($dsn,DB_USER,DB_PASS);
			//$this->_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		public function query_prepare($sql){
			return $this->_connection->prepare($sql);
		}
		public function query($sql){
			$this->last_query = $sql;
			$query = $this->_connection->prepare($sql);
			try{
				$query->execute();
			}
			catch(PDOException $e){
				die($e->getMessage());	
			}
			return $query;
		}
		public function lastInsertId(){
			$_connection = $this->_connection;
			return $_connection->lastInsertId();	
		}
		public function escape($value){
			$value = $this->_connection->quote($value);
			return $value;	
		}
	}
	$database = new MySQLDatabase();
	//echo "<pre>".print_r($database, true)."</pre>";
	//exit;
?>

<?php
	require_once(LIB_PATH."database_object.php");
	class Program extends DatabaseObject{
		protected static $_table_name = "programs";
		public $id; 
		public $name;
		public $code;	
	}

?>

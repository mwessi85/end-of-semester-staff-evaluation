<?php
	require_once(LIB_PATH."database_object.php");
	class Department extends DatabaseObject{
		protected static $_table_name = "departments";
		public $id; 
		public $name;	
		public $head;
		public $head_message;
		public $about;
		public $type;	
	}

?>

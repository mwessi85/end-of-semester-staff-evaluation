<?php
	require_once(LIB_PATH."database_object.php");
	class Sub_department extends DatabaseObject{
		protected static $_table_name = "sub_departments";
		public $id; 
		public $name;	
		public $department;
		public $head;
		public $about;	
	}

?>

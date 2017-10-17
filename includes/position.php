<?php
	require_once(LIB_PATH."database_object.php");
	class Position extends DatabaseObject{
		protected static $_table_name = "positions";
		public $id; 
		public $title;	
		public $category;	
	}

?>

<?php
	require_once(LIB_PATH."database_object.php");
	class Title extends DatabaseObject{
		protected static $_table_name = "titles";
		public $id; 
		public $title;	
	}

?>

<?php
	require_once(LIB_PATH."database_object.php");
	class Question extends DatabaseObject{
		protected static $_table_name = "questions";
		public $id; 
		public $question;	
		public $category;
		public $status;
	}

?>

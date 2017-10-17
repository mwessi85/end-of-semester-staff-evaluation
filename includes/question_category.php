<?php
	require_once(LIB_PATH."database_object.php");
	class Question_category extends DatabaseObject{
		protected static $_table_name = "question_categorys";
		public $id; 
		public $name;	
	}

?>

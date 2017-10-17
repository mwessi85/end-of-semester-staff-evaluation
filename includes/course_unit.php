<?php
	require_once(LIB_PATH."database_object.php");
	class Course_unit extends DatabaseObject{
		protected static $_table_name = "course_units";
		public $id; 
		public $name;
		public $code;
		public $credit_unit;
		public $semester;
		public $year;
		
		public function duplicate($code, $name){
			global $database;
			$sql = "SELECT * FROM ".static::$_table_name." WHERE code = '".$code."' AND name = '".$name."'";
			//echo $sql;
			$result = $database->query($sql);
			$results = $result->fetchColumn();
			//echo "<pre>".print_r($results, true)."</pre>";
			if(!empty($results)){
				return "duplicate";	
			}	
			return false;
		}
	}

?>

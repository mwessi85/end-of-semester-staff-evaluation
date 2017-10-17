<?php
	require_once(LIB_PATH."database_object.php");
	class Course extends DatabaseObject{
		protected static $_table_name = "courses";
		public $id; 
		public $name;	
		public $sub_department;
		public $department;
		public $code;
		public $category;
		public $duration;	
		public $accry;
		protected static $categories = array("PhD"=>"Doctorate","PGC"=>"Post Graduate Certificate","MAS"=>"Master","BAC"=>"Bachelor","PGD"=>"Post Graduate Diploma","DIP"=>"Diploma","CERT"=>"Certificate");
		public static function category_array(){
			//echo "<pre>".print_r(self::$categories, true)."</pre>";
			return self::$categories;
		}
		
	}

?>

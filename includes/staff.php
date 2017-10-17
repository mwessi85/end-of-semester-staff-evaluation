<?php
	require_once(LIB_PATH."database_object.php");
	class Staff extends DatabaseObject{
		protected static $_table_name = "staffs";
		public $id; 
		public $user_id;
		public $title;
		public $position;
		//public $staff_id;
		public $staff_no;
		public $department;
		public $bio;
		public $errors = array(); 		
}
?>

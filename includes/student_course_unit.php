<?php
	require_once(LIB_PATH."database_object.php");
	class Student_course_unit extends DatabaseObject{
		protected static $_table_name = "student_course_units";
		public $id; 
		public $user_id;
		public $course_course_unit;
		
	}

?>

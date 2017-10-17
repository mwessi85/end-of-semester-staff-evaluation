<?php
	require_once(LIB_PATH."database_object.php");
	class Student extends DatabaseObject{
		protected static $_table_name = "students";
		public $id; 
		public $user_id;
		public $student_no;
		public $course;
		public $program;
		public $year;
		public $course_unit_no;
		public $course_unit_complete;
		public $errors = array(); 	
		
		public static function student_course(){
			if(isset($this->course)){
				return $this->course;
			}else{
				return false;	
			}
		}
		public function student_program(){
			if(isset($this->program)){
				$program_object = Program::find_by_id($this->program);
				return $program_object->name;
			}else{
				return false;	
			}
		}
		public static function find_all_by_course_id($id=0){
			global $database;
			$sql = "SELECT s.id student_id, s.user_id student_user_id, s.student_no student_no, s.course student_course, s.year, year, s.course_unit_no, s.course_unit_complete course_unit_complete, course_unit_no, u.id user_id, u.first_name, u.last_name, u.other_name 
			FROM students s INNER JOIN users u ON s.user_id=u.id AND s.course =".$id;
			$object_array = static::find_by_sql($sql);
			return !empty($object_array) ? $object_array : false;	
		}
		public static function find_all_by_course_id_filter_year($id=0, $year){
			global $database;
			$sql = "SELECT s.id student_id, s.user_id student_user_id, s.student_no student_no, s.course student_course, s.year, year, s.course_unit_no, s.course_unit_complete course_unit_complete, course_unit_no, u.id user_id, u.first_name, u.last_name, u.other_name 
			FROM students s INNER JOIN users u ON s.user_id=u.id AND s.course =".$id." AND s.year = ".$year;
			$object_array = static::find_by_sql($sql);
			return !empty($object_array) ? $object_array : false;	
		}
}
?>

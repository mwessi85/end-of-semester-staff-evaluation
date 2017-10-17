<?php
	require_once(LIB_PATH."database_object.php");
	class Course_course_unit extends DatabaseObject{
		protected static $_table_name = "course_course_units";
		public $id; 
		public $course;
		public $course_unit;
		public $lecturer;
		public $year;
		public $semester;
		public $status;	
		
		public static function find_all_course_course_units($condition=""){
			global $database;
			$sql = "
			SELECT c.id course_id, c.name course, c.code course_code, cu.name, cu.code course_unit_code, ccu.status, ccu.id course_course_unit_id, ccu.course, ccu.course_unit, ccu.lecturer lecturer, ccu.year year, ccu.semester semester  FROM course_course_units ccu INNER JOIN courses c ON (c.id=ccu.course) INNER JOIN course_units cu ON (cu.id = ccu.course_unit)".$condition;
			$query = static::query_object($sql);
			//echo $query->rowCount();	
			return $query;	
		}
		public static function find_all_course_course_units_count($condition=""){
			global $database;
			$sql = "SELECT count(id) count, course FROM course_course_units";
			$query = static::query_object($sql);
			//echo $query->rowCount();	
			//return $query;	
			return $query->rowCount();
		}
		
		/*public static function find_all_course_course_units_by_course($condition=""){
			global $database;
			global $course_id;
			$sql = "
			SELECT c.id course_id, c.name course, c.code course_code, cu.name, cu.code course_unit_code, ccu.status, ccu.id course_course_unit_id, ccu.course, ccu.course_unit, ccu.lecturer lecturer, ccu.year year, ccu.semester semester FROM course_course_units ccu INNER JOIN courses c ON (c.id=ccu.course) INNER JOIN course_units cu ON (cu.id = ccu.course_unit) AND c.id =".$course_id.$condition;
			$query = static::query_object($sql);
			return $query;	
		}*/
		
		public static function find_all_course_course_units_by_course($condition=""){
			global $database;
			global $course_id;
			//echo "":
			$sql = "
			SELECT c.id course_id, c.name course, c.code course_code, cu.name, cu.code course_unit_code, ccu.status, ccu.id course_course_unit_id, ccu.course, ccu.course_unit, ccu.lecturer lecturer, ccu.year year, ccu.semester semester FROM course_course_units ccu INNER JOIN courses c ON (c.id=ccu.course) INNER JOIN course_units cu ON (cu.id = ccu.course_unit) AND c.id = ".$course_id.$condition;
			$query = static::query_object($sql);
			//echo $query->rowCount();	
			//echo $sql;
			//exit;
			return $query;	
		}
		public static function find_all_course_course_units_by_student($condition=""){
			global $database;
			global $course_id;
			//echo "":
			$sql = "
			SELECT c.id course_id, c.name course, c.code course_code, cu.name, cu.code course_unit_code, ccu.status, ccu.id course_course_unit_id, ccu.course, ccu.course_unit, ccu.lecturer lecturer, ccu.year year, ccu.semester semester FROM course_course_units ccu INNER JOIN courses c ON (c.id=ccu.course) INNER JOIN course_units cu ON (cu.id = ccu.course_unit)".$condition;
			//echo $sql;
			$query = static::query_object($sql);
			//echo $query->rowCount();	
			return $query;	
		}
		
		/*public static function find_all_course_course_units_by_student($condition=""){
			global $database;
			global $course_id;
			$sql = "
			SELECT c.id course_id, c.name course, c.code course_code, cu.name, cu.code course_unit_code, ccu.status, ccu.id course_course_unit_id, ccu.course, ccu.course_unit, ccu.lecturer lecturer, ccu.year year, ccu.semester semester, scu.user_id student_user_id, scu.course_course_unit FROM course_course_units ccu INNER JOIN courses c ON (c.id=ccu.course) INNER JOIN course_units cu ON (cu.id = ccu.course_unit) AND c.id =".$course_id.$condition;
			$query = static::query_object($sql);
			//echo $query->rowCount();	
			return $query;	
		}*/
		
		
		public static function find_all_course_course_units_count_by_course($condition=""){
			global $database;
			global $course_id;
			$sql = "SELECT count(id) count, course FROM course_course_units WHERE course =".$course_id;;
			$query = static::query_object($sql);
			//echo $query->rowCount();	
			//return $query;	
			return $query->rowCount();
		}
	}

?>

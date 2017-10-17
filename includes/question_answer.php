<?php
	require_once(LIB_PATH."database_object.php");
	class Question_answer extends DatabaseObject{
		protected static $_table_name = "question_answers";
		public $id; 
		public $question_category;
		public $question_category_id;
		public $question;
		public $question_id;
		public $answer;
		public $answer_id;
		public $academic_unit;
		public $academic_unit_id;
		public $department;
		public $department_id;
		public $course_course_unit_id;
		public $course;
		public $course_id;
		public $program;
		public $program_id;
		public $year_of_study;
		public $course_unit;
		public $course_unit_id;
		public $year;
		public $semester;
		public $lecturer;
		public $lecturer_id;
		public $respondent;
		public $respondent_id;
		public $branch;
		public $date;	
		
		
		
		public static function find_if_complete($year, $semester, $course_unit, $respondent, $lecturer_id){
			global $database;
			global $session;
			$sql = "SELECT count(id) FROM question_answers WHERE year = '".$year."' AND semester = '".$semester."' AND course_unit_id = '".$course_unit."' AND lecturer_id = '".$lecturer_id."' AND respondent_id = ".$respondent;
			//echo $sql."<br>";
			//exit;
			$query = static::query_object($sql);
			$row = $query->fetch(PDO::FETCH_COLUMN);
			return $row[0];	
		}
		
		public static function update_complete($respondent){
			global $database;
			global $session;
			$sql = "UPDATE students SET course_unit_complete = (course_unit_complete+1) WHERE user_id = ".$respondent;
			//echo $sql."<br>";
			//exit;
			$query = static::query_object($sql);
			return $query->rowCount();
		}
		
		
		public static function find_all_download($condition=""){
			global $database;
			$sql = "SELECT * FROM question_answers".$condition;
			$query = static::query_object($sql);
			//echo $query->rowCount();	
			return $query;	
		}
		public static function find_all_download_count($condition=""){
			global $database;
			$sql = "SELECT count(id) count FROM question_answers";
			$query = static::query_object($sql);	
			return $query->rowCount();
		}
	}

?>

<?php 
if(Input::get('delete')){
	$student_user_id = urldecode(base64_decode(Input::get('student_user_id')));
	$course_course_unit_id = urldecode(base64_decode(Input::get('course_course_unit_id')));
	$query = "DELETE FROM student_course_units WHERE user_id = ".$student_user_id." AND course_course_unit = ".$course_course_unit_id;
	$result = $database->query($query);
	$query = "DELETE FROM question_answers WHERE respondent_id = ".$student_user_id." AND course_course_unit_id = ".$course_course_unit_id;
	$result = $database->query($query);
	redirect_to("index.php?c=student&p=student&user_id=".urlencode(base64_encode($student_user_id)));
}
if(Input::get('student_course_unit_id')){
	$student_course_unit_id = urldecode(base64_decode(Input::get('student_course_unit_id')));
	$student_course_course_unit = "";
	//echo $student_course_unit_id;
}
	
if(Input::get('submit')){
	$inputs = array("user_id","student_course_course_unit", "student_course_course_unit_search","retake");
	foreach ($inputs as $input){
		$$input = Input::get($input);
	}
	//echo Input::get('user_id');
	if(empty($student_course_unit_id)){
		$student_course_unit = new Student_course_unit();
	}
	
	$student_course_unit->user_id = urldecode(base64_decode($user_id));
	
	$student_course_unit->course_course_unit = $student_course_course_unit;
	if(empty($student_course_unit->course_course_unit)){
		$session->message("error: The course unit you entered does not exist, please type the course unit name & select it from the auto-suggest options that appear as you type");
		redirect_to("index.php?c=student&p=student&user_id=".urlencode(base64_encode($student_course_unit->user_id)));
	}
	//echo $student_course_course_unit;
	//exit;
	$sql = "SELECT * FROM student_course_units WHERE user_id = '".$student_course_unit->user_id."' AND course_course_unit = ".$student_course_unit->course_course_unit;
			//echo $sql."<br>";
			$query = Student_course_unit::query_object($sql);
			$row = $query->fetch(PDO::FETCH_COLUMN);
			if(!empty($row)){
				$session->message("error: The course unit already exists - $student_course_course_unit_search");
				redirect_to("index.php?c=student&p=student&user_id=".urlencode(base64_encode($student_course_unit->user_id)));
			}
	if(!empty($student_course_unit->course_course_unit) && !empty($student_course_unit->user_id)){
		$action = $student_course_unit->save();
		if(is_numeric($action)){
			$session->message("success: Course unit was added successfully");
			$student_course_unit->id = $action;
		}else{
			$session->message("success:Course unit edit was successfull");
		}
		redirect_to("index.php?c=student&p=student&user_id=".urlencode(base64_encode($student_course_unit->user_id)));
	}
}

?>
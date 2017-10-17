
<?php 
$course_disabled = "";
$course_unit_disabled = "";
//echo "Mike";
//exit;
if(Input::get('course_course_unit_id')){
		$course_course_unit_id = urldecode(base64_decode(Input::get('course_course_unit_id')));
		
		if($course_course_unit_id > 0){
			$course_course_unit = Course_course_unit::find_by_id($course_course_unit_id);
			$fields = array("course", "course_unit", "lecturer", "year", "semester", "status");
			foreach ($fields as $field){
				$$field = $course_course_unit->$field;
			}
			if(!empty($course_course_unit->lecturer)){
				$user_id = $course_course_unit->lecturer;
				$user = User::find_by_id($user_id);
				$user_search = $user->full_name();
			}else{
				$user_search = "";
				$user_id = 0;	
			}
			
			$course_id = $course_course_unit_course = $course_course_unit->course;
			if(!empty($course_course_unit_course)){
				$course_object = Course::find_by_id($course_course_unit_course);
				$course_search = $course_object->name;
			}
			$course_unit_id = $course_course_unit_course_unit = $course_course_unit->course_unit;
			if(!empty($course_course_unit_course_unit)){
				$course_unit_object = Course_unit::find_by_id($course_course_unit_course_unit);
				$course_unit_search = $course_unit_object->name;
			}
		}
		if(Input::get('delete')){
			$result = Question_answer::delete_all_where("course_course_unit_id", $course_course_unit_id);
			$result = Student_course_unit::delete_all_where("course_course_unit", $course_course_unit_id);
			$result = Course_course_unit::delete_all_where("id", $course_course_unit_id);
			
			//$query = "DELETE FROM course_course_units WHERE id = ".$course_course_unit_id;
			//$result = $database->query($query);
			//$query = "DELETE FROM question_answers WHERE course_course_unit_id = ".$course_course_unit_id;
			//$result = $database->query($query);
			redirect_to("index.php?c=course&p=course&course_id=".urlencode(base64_encode($course_id)));
		}
	}else{
		$course_course_unit_id = 0;
		$inputs = array("course", "course_unit", "course_search", "course_unit_search", "user_id", "user_search", "year", "semester", "status");
		foreach ($inputs as $input){
			$$input = Input::get($input);
		}
		$year = YEAR;
		$semester = SEMESTER;
		$status = STATUS;
		//echo $status;
		//exit;
		
		if(Input::get('course_id')){
			$course_object = Course::find_by_id(urldecode(base64_decode(Input::get('course_id'))));
			if(!empty($course_object->program)){
				$program_object = Program::find_by_id($course_object->program);
				$program_search = $program_object->code." (".$program_object->name.")";
				$course_search = $course_object->name.": ".$program_search ;
			}else{
				$course_search = $course_object->name;
			}
			$course = $course_object->id;
			//echo $course_search;
			
			$course_disabled = "disabled='disabled'";
		}
		/*if(Input::get('course_unit_id')){
			$course_unit_object = Course_unit::find_by_id(urldecode(base64_decode(Input::get('course_unit_id'))));
			$course_unit_search = $course_unit_object->name;
			$course_unit = $course_unit_object->id;
			$course_unit_disabled = "disabled='disabled'";
		}*/
	}
	
if(Input::get('submit')){
	if(Input::get('submit') == "Enter"){
		$inputs = array("course", "course_unit", "course_search", "course_unit_search", "user", "user_search", "year", "semester", "status");
		foreach ($inputs as $input){
			$$input = Input::get($input);
		}
		//echo $course_course_unit_id;
		if($course_course_unit_id==0){
			$course_course_unit = new Course_course_unit();
		}
		$course_course_unit->course = $course;
		$course_course_unit->course_unit = $course_unit;
		$course_course_unit->lecturer = $user;
		$course_course_unit->year = $year;
		$course_course_unit->semester = $semester;
		$course_course_unit->status = $status;
		
		if(!empty($course_course_unit->course) && !empty($course_course_unit->course_unit) && !empty($course_course_unit->lecturer)){
			
		//echo "<pre>".print_r($course_course_unit, true)."</pre>";
		//exit;
			$action = $course_course_unit->save();
			if(is_numeric($action)){
				$session->message("success: Course's course unit was added successfully");
				$course_course_unit->id = $action;
			}else{
				if($action != 'duplicate'){
					$session->message("error:Course's course unit edit was successfull");	
				}else{
					$lecturer_object = User::find_by_id($course_course_unit->lecturer);
					$lecturer_name = $lecturer_object->full_name();
					$course_unit_object = Course_unit::find_by_id($course_course_unit->course_unit);
					$course_unit_name = $course_unit_object->name;
					$query = "UPDATE question_answers SET lecturer_id = ".$course_course_unit->lecturer.", lecturer = '".$lecturer_name."' WHERE course_course_unit_id = ".$course_course_unit_id;
					//echo $query;
					//exit;
					$result = $database->query($query);
					$session->message("error:Course unit '".$course_unit_name."' is already assinged to '".$lecturer_object->full_name_title()."'");
				}
			}
			redirect_to("index.php?c=course&p=course&course_id=".urlencode(base64_encode($course_course_unit->course)));
		}
	}
}else{
		
}

?>
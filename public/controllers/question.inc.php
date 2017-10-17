<?php include("course_course_unit.inc.php");
if(Input::get('course_course_unit_id')){
	if($staff = Staff::find_by_user_id($user->id)){;
		$title_object = Title::find_by_id($staff->title);
		if($title_object){
			$staff_title = $title_object->title.". ";
		}else{
			$staff_title = "";	
		}
		$lecturer_name = $staff_title.$user->full_name();
	}
	
	if(!empty($course_object->sub_department)){
		$sub_department_object = Sub_department::find_by_id($course_object->sub_department);
		$sub_department = $sub_department_object->name;	
	}else{
		$sub_department = "";
		if(!empty($course_object->department)){
			$department_object = Department::find_by_id($course_object->department);
			$sub_department = $department_object->name;	
		}
	}
	
	if(!empty($course_object->department)){
		$department_object = Department::find_by_id($course_object->department);
		$department = $department_object->name;	
	}else{
		$sub_department_object = Sub_department::find_by_id($course_object->sub_department);
		$department_object = Department::find_by_id($sub_department_object->department);
		$department = $department_object->name;		
	}
	$today = date("d-M-Y");
}
?>
<?php 

if(Input::get('question_id')){
		$question_id = urldecode(base64_decode(Input::get('question_id')));
		if($question_id > 0){
			$question_object = Question::find_by_id($question_id);
			$fields = array("question", "category", "status");
			foreach ($fields as $field){
				$$field = $question_object->$field;
			}
			$question_category = $question_object->category;
			if(!empty($question_category)){
				$question_category_object = Question_category::find_by_id($question_category);
				$question_category_search = $question_category_object->name;
			}
		}
	}else{
		$question_id = 0;
		$inputs = array("question", "question_category", "status", "question_category_search");
		foreach ($inputs as $input){
			$$input = Input::get($input);
		}
		$status = STATUS;
	}
if(Input::get('submit')){
	//$name = strtolower(Input::get('name'));
	$inputs = array("question", "question_category", "status");
	foreach ($inputs as $input){
		$$input = Input::get($input);
	}
	$question_input = $question;
	if($question_id==0){
		$question_object = new Question();
	}

	$question_object->question = ucfirst($question_input);
	$question_object->category = $question_category;
	$question_object->status = $status;
	
	if(!empty($question_object->question) && !empty($question_object->category)){
		$action = $question_object->save();
		if(is_numeric($action)){
			$session->message("success: Question was added successfully");
			$question_object->id = $action;
		}else{
			$session->message("success: Question edit was successfull");
		}
		//redirect_to("index.php?c=question&p=question&question_id=".urlencode(base64_encode($question->id)));
		redirect_to("index.php?c=question&p=questions");
	}
}else{
		
}
?>
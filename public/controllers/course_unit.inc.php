<?php 
$department_disabled = "";
if(Input::get('course_unit_id')){
	$course_unit_id = urldecode(base64_decode(Input::get('course_unit_id')));
	if($course_unit_id > 0){
		$course_unit = Course_unit::find_by_id($course_unit_id);
		$fields = array("name", "code", "credit_unit", "semester", "year");
		foreach ($fields as $field){
			$$field = $course_unit->$field;
		}
	}
}else{
	$course_unit_id = 0;
	$inputs = array("name", "code", "credit_unit", "semester", "year");
	foreach ($inputs as $input){
		$$input = Input::get($input);
	}
}
	
if(Input::get('submit')){
	$inputs = array("name", "code", "credit_unit", "semester", "year");
	foreach ($inputs as $input){
		$$input = Input::get($input);
	}
	
	if($course_unit_id==0){
		$course_unit = new Course_unit();
		$course_unit->name = titleCase($name);
	}
	$course_unit->name = titleCase($name);
	$course_unit->code = $code;
	$course_unit->credit_unit = $credit_unit;
	$course_unit->semester = $semester;
	$course_unit->year = $year;
	//echo "Year: ".$course_unit->year ."<br>";
	//echo "Sem: ".$course_unit->semester;
	//exit;
	if(empty($course_unit->id)){
		$duplicate = $course_unit->duplicate($course_unit->code, $course_unit->name);
		//echo $duplicate;
		//echo "Mike";
		if($duplicate == "duplicate"){
			$session->message("error:Course unit '(".$course_unit->code.") ".$course_unit->name."' already exists");
			redirect_to("index.php?p=course_units");
		}
	}
	//exit;
	if(!empty($course_unit->name) && $course_unit->code){
		$action = $course_unit->save();
		if(is_numeric($action)){
			$session->message("success: Course unit was added successfully");
			$course_unit->id = $action;
		}else{
			$session->message("success:Course unit edit was successfull");
		}
		redirect_to("index.php?c=course_unit&p=course_unit&course_unit_id=".urlencode(base64_encode($course_unit->id)));
	}
}else{
		
}
?>
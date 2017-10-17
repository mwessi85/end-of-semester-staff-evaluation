<?php 
if(Input::get('course_course_unit_id') && Input::get('year_of_study')){
	if(Input::get('course_course_unit_id') && Input::get('year_of_study')){
		excel_staff(urldecode(base64_decode(Input::get('course_course_unit_id'))), Input::get('year_of_study'));
	}
}
$disabled = "";
$sub_department_disabled = "";
$department_disabled = "";
if(Input::get('course_id')){
		$course_id = urldecode(base64_decode(Input::get('course_id')));
		if($course_id > 0){
			$course = Course::find_by_id($course_id);
			$fields = array("name", "sub_department", "department","code", "category", "duration");
			foreach ($fields as $field){
				$$field = $course->$field;
			}
			$course_sub_department = $course->sub_department;
			if(!empty($course_sub_department)){
				$sub_department_object = Sub_department::find_by_id($course_sub_department);
				$sub_department_search = $sub_department_object->name;
				
			}else{
				$course_sub_department = 0;
				$sub_department_search = "";	
				if(!Input::get('full_edit')){
					$sub_department_disabled = "disabled='disabled'";
				}
			}
			$course_department = $course->department;
			if(!empty($course_department)){
				$department_object = Department::find_by_id($course_department);
				$department_search = $department_object->name;
				
			}else{
				if(!Input::get('full_edit')){
					$department_disabled = "disabled='disabled'";
				}
				$course_department = 0;
				$department_search = "";
			}
			if(empty($course_department) && empty($course_department)){
				$sub_department_disabled = "";
				$department_disabled = "";
				
			}
		}
	}else{
		$course_id = 0;
		$course_department = 0;
		$course_sub_department = 0;
		$sub_department_search = "";
		$department_search = "";
		$course_unit_no = 0;
		
		$inputs = array("name", "sub_department", "department", "sub_department_search", "department_search", "code", "category", "duration");
		foreach ($inputs as $input){
			$$input = Input::get($input);
		}
		if(Input::get('sub_department_id')){
			$sub_department_object = Sub_department::find_by_id(urldecode(base64_decode(Input::get('sub_department_id'))));
			$sub_department_search = $sub_department_object->name;
			$sub_department = $sub_department_object->id;
			$disabled = "disabled='disabled'";
		}
		if(Input::get('department_id')){
			$department_object = Department::find_by_id(urldecode(base64_decode(Input::get('department_id'))));
			$department_search = $department_object->name;
			$department = $department_object->id;
			$disabled = "disabled='disabled'";
		}
	}
	
if(Input::get('submit')){
	$inputs = array("name", "sub_department", "department", "sub_department_search", "department_search", "code", "category", "duration");
	foreach ($inputs as $input){
		$$input = Input::get($input);
	}
	if($course_id==0){
		$course = new Course();
	}
	$course->name = titleCase($name);
	$course->sub_department = $sub_department;
	if(empty($sub_department)){
		$sub_department = 0;
	}
	if(empty($department)){
		$department = 0;
	}
	$course->department = $department;
	$course->code = $code;
	$course->category = $category;
	$course->duration = $duration;
	
	//$course->course_unit_no = $course_unit_no;
	if(!empty($course->name)){
		$action = $course->save();
		if(is_numeric($action)){
			$session->message("success: Course was added successfully");
			$course->id = $action;
		}else{
			$session->message("success:Course edit was successfull");
		}
		redirect_to("index.php?c=course&p=course&course_id=".urlencode(base64_encode($course->id)));
	}
}else{
		
}
?>
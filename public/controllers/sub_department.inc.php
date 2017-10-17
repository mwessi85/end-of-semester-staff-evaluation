<?php 
$disabled = "";
if(Input::get('sub_department_id')){
		$sub_department_id = urldecode(base64_decode(Input::get('sub_department_id')));
		if($sub_department_id > 0){
			$sub_department = Sub_department::find_by_id($sub_department_id);
			$fields = array("name", "department", "head", "about");
			foreach ($fields as $field){
				$$field = $sub_department->$field;
			}
			$sub_department_head = $sub_department->head;
			if(!empty($sub_department->head)){
				$user = User::find_by_id($sub_department->head);
				$user_search = $user->full_name();
			}else{
				$user_search = "";	
			}
			if(!empty($sub_department->department)){
				$department_object = Department::find_by_id($sub_department->department);
				$department_search = $department_object->name;
			}
		}
	}else{
		
		$sub_department_id = 0;
		$inputs = array("name", "user_id", "department", "user_search", "department_search", "about");
		foreach ($inputs as $input){
			$$input = Input::get($input);
		}
		if(Input::get('department_id')){
			$department_object = Department::find_by_id(urldecode(base64_decode(Input::get('department_id'))));
			$department_search = $department_object->name;
			$department = $department_object->id;
			$disabled = "disabled='disabled'";
		}
	}
if(Input::get('submit')){
	$inputs = array("name", "user", "department", "user_search", "department_search", "about");
	foreach ($inputs as $input){
		$$input = Input::get($input);
	}
	if($sub_department_id==0){
		$sub_department = new Sub_department();
	}
	$sub_department->name = titleCase($name);
	$sub_department->department = $department;
	$sub_department->head = $user;
	$sub_department->about = $about;
	if(!empty($sub_department->name) && !empty($sub_department->department)){
		$action = $sub_department->save();
		if(is_numeric($action)){
			$session->message("success: Sub-department was added successfully");
			$sub_department->id = $action;
		}else{
			$session->message("success: Sub-department edit was successfull");
		}
		redirect_to("index.php?c=sub_department&p=sub_department&sub_department_id=".urlencode(base64_encode($sub_department->id)));
	}
}else{
		
}
?>
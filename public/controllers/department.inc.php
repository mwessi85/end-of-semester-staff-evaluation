<?php 
if(Input::get('department_id')){
		$department_id = urldecode(base64_decode(Input::get('department_id')));
		if($department_id > 0){
			$department = Department::find_by_id($department_id);
			$fields = array("name", "head", "type", "head_message", "about");
			foreach ($fields as $field){
				$$field = $department->$field;
			}
			$department_head = $department->head;
			if(!empty($department->head)){
				$user = User::find_by_id($department->head);
				$user_search = $user->full_name();
			}else{
				$user_search = "";
			}
		}
	}else{
		$department_id = 0;
		$inputs = array("name", "user_id", "type", "head_message", "about", "user_search");
		foreach ($inputs as $input){
			$$input = Input::get($input);
		}
		$type = DEPARTMENT_TYPE;
	}
if(Input::get('submit')){
	//$name = strtolower(Input::get('name'));
	$inputs = array("name", "user", "type", "head_message", "about");
	foreach ($inputs as $input){
		$$input = Input::get($input);
	}
	if($department_id==0){
		$department = new Department();
	}

	$department->name = titleCase($name);
	$department->type = ucfirst($type);
	$department->id = $department_id;
	$department->head = $user;
	$department->head_message = $head_message;
	$department->about = $about;
	
	//echo $department->head_message."<br>";
	//echo $department->about;
	//exit;
	
	if(!empty($department->name)){
		
		$action = $department->save();
		if(is_numeric($action)){
			$session->message("success: Department was added successfully");
			$department->id = $action;
		}else{
			$session->message("success: Department edit was successfull");
		}
		redirect_to("index.php?c=department&p=department&department_id=".urlencode(base64_encode($department->id)));
	}
}else{
		
}
?>
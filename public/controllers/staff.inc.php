<?php 
	if(Input::get('user_id')){
		$user_id = urldecode(base64_decode(Input::get('user_id')));
		
		if($staff = Staff::find_by_user_id($user_id)){
			$staff_id = $staff->id;	
		}else{
			$_GET['add'] = true;
		}
	}else{
		
		exit;
		$session->message("error: No user was specified");
		redirect_to("index.php?p=user");	
	}
	
	if(Input::get('staff_id')){
		$staff_id = urldecode(base64_decode(Input::get('staff_id')));
		if($staff_id > 0){
			$staff = Staff::find_by_id($staff_id);
			$fields = array("user_id", "title", "position", "staff_no", "department", "bio");
			foreach ($fields as $field){
				$$field = $staff->$field;
			}
			
			$department_object = Department::find_by_id($department);
			if($department_object){
				$department_search = $department_object->name;
			}else{
				$department_search = "";
			}
			
			$title_object = Title::find_by_id($title);
			if($title_object){
				$title_search = $title_object->title;
			}else{
				$title_search = "";	
			}
			$position_object = Position::find_by_id($position);
			if($position_object){
				$position_search = $position_object->title;
			}else{
				$position_search = "";	
			}
		}
	}else{
		$staff_id = 0;
		$user_id = urldecode(base64_decode(Input::get('user_id')));
		if($staff = Staff::find_by_user_id($user_id)){
			$staff_id = $staff->id;	
		}else{
			$_GET['add'] = true;
		}
		
		$inputs = array("staff_no", "title", "title_search", "position", "position_search", "department", "department_search", "bio");
		foreach ($inputs as $input){
			$$input = Input::get($input);
		}	
		
	}	
	
	if(Input::get('submit_staff')){
		
		if(!(Input::get('user_id'))){
			$message = "error: Noooo user specified";
			redirect_to("index.php?p=user");	
		}
		
		$inputs = array("staff_no", "title", "position", "department", "bio");
		foreach ($inputs as $input){
			$$input = Input::get($input);
		}
		if(Input::get('title_search') == ""){
			$title = 0;	
		}
		$staff_no = strtoupper($staff_no);
		if($staff_id==0){
			$staff = new Staff();
		}
		$attributes  = array("user_id", "title", "position", "staff_no", "department", "bio");
		foreach ($attributes as $attribute){
			$staff->$attribute = $$attribute;
		}
		
		if($staff->user_id && $staff->department){
			$action = $staff->save();
			if(is_numeric($action)){
				$session->message("success: Staff added successfully");
			}else{
				$session->message("success: Staff edit successfull");
			}
			
			redirect_to("index.php?p=staff&user_id=".urlencode(base64_encode($staff->user_id)));
		}
	}
	$photo = Photograph::find_by_user_id($user_id);	
?>
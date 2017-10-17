<?php 
if(Input::get('user_id')){
	$user_id = urldecode(base64_decode(Input::get('user_id')));
	//echo $user_id;
	//exit;
	if(!empty($user_id) && (($session->session_no == Session::session_no($user_id)) || ($session->session_no == Session::session_no(1)))){
		if($user_id > 0){
			$user = User::find_by_id($user_id);
			$fields = array("username", "password", "first_name", "last_name", "other_name", "email", "user_type", "status");
			foreach ($fields as $field){
				$$field = $user->$field;
			}
		}
	}elseif(!empty($user_id)){
		$session->message("error: You are not allowed to perform this action");
		redirect_to("index.php?p=main");
	}
}else{
	$user_id = 0;
	$inputs = array("first_name", "last_name", "other_name", "email", "user_type", "status");
	foreach ($inputs as $input){
		$$input = Input::get($input);
	}
}

if(Input::get('submit')){
	$inputs = array("first_name", "last_name", "other_name", "user_type", "status");
	foreach ($inputs as $input){
		$$input = strtolower(Input::get($input));
	}
	if($user_id==0){
		$user = new User();
		$user->status = 'active';
	}
	if(empty($user->username)){
		$username = explode('@', Input::get('email'));
		$user->username = strtolower($username[0]);
	}	
	if(empty($user->password)){
		$user->password = sha1(trim(strtolower($username[0])));	
	}
	$attributes = array("first_name", "last_name", "other_name", "user_type", "status");
	foreach ($attributes as $attribute){
		$user->$attribute = $$attribute;
	}
	if(empty($user_type)){
		$session->message("error: You must select a user type!");
		redirect_to("index.php?c=users&p=users&add=true");	
	}
	if($user_type == "student"){
		$email = $user->verify_umu_email_student(Input::get('email'), $user_id)	;
	}else{
		$email = $user->verify_umu_email_staff(Input::get('email'), $user_id);	
	}
	//echo $user_type;
	//exit;
	if(!empty($email) && !empty($first_name)  && !empty($last_name)){
		$action = $user->save();
		if(is_numeric($action)){
			//$session->message("success: User added successfully");	
			$user_id = $user->id = $action;
			if($user->user_type == "student"){
				$found_user = User::find_by_id($user->id);
				if(!empty($found_user->id)){
					$session->login($found_user);
					log_action("Login", $found_user->username." Logged in.");
					$session->message("success: Welcome ".$found_user->full_name().", your registration was successfull, now fill in your student information");
					//echo $found_user->full_name()."<br>";
					//echo $found_user->id."<br>";
					//exit;
					
					redirect_to("index.php?c=student&p=student&user_id=".urlencode(base64_encode($found_user->id)));
					//index.php?c=student&p=student&user_id=MTcw
				}else{
					$session->message("error: User registration failed");
					redirect_to("index.php?logut=true");		
				}
				
			}else{
				$session->message("success: User added successfully");
			}
			redirect_to("index.php?c=staff&p=staff&user_id=".urlencode(base64_encode($user_id)));	
		}else{
			$session->message("success: User detail edit successfull");
		}
		redirect_to("index.php?c=staff&p=staff&user_id=".urlencode(base64_encode($user->id)));	
	}
}
?>
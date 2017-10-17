<?php 
if(Input::get('user_id')){	
	$user_id = urldecode(base64_decode(Input::get('user_id')));
}else{
	$session->message("No user was specified!!!");
	redirect_to("users.php");	
}

if(Input::get('phone_id')){
	$phone_id = urldecode(base64_decode(Input::get('phone_id')));
	if($phone_id > 0){
		$phone = Phone::find_by_id($phone_id);
		$fields = array("user_id", "number", "country_code");
		foreach ($fields as $field){
			$$field = $phone->$field;
		}
	}
}else{
	$phone_id = 0;
	
	$inputs = array( "number", "country_code");
	foreach ($inputs as $input){
		$$input = Input::get($input);
	}
	$country_code = 256;
	if(true){
	
	}else{
		$session->message("error: You are not allowed to perform this action");
		redirect_to("index.php?p=main");
	}
}
if(Input::get('submit_phone')){
	if(!(Input::get('user_id'))){
		$message = "No user specified";
		redirect_to("users.php");	
	}
	
	$number = trim(Input::get('number'));
	$country_code = Input::get('country_code');
	if($phone_id==0){
		$phone = new Phone();
		$phone_id="";
	}

	$phone->user_id = $user_id;
	$phone->number = $number;
	$phone->country_code = $country_code;
	
	
	if(!($phone->verify_phone($phone->user_id))){
		redirect_to("index.php?c=phone&p=staff&user_id=".urlencode(base64_encode($phone->user_id)));
	}
	if(strlen($number) < 10){
		$session->message("error: Phone '".$number."' should be 10 digits like 0782123456");
		redirect_to("index.php?c=staff&p=staff&user_id=".urlencode(base64_encode($user_id)));
	}
	if($phone->user_id && (strlen($number) > 9) && $phone->country_code){
		$action = $phone->save();
		if(is_numeric($action)){
			$session->message("success: Phone added successfully");	
		}else{
			$session->message("success: Edit successfull");
		}
		redirect_to("index.php?c=staff&p=staff&user_id=".urlencode(base64_encode($user_id)));
	}else{
	$session->message("error: Phone addition failed");	
		redirect_to("index.php?c=staff&p=staff&user_id=".urlencode(base64_encode($user_id)));
	}
}	
?>
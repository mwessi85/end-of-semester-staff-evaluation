<?php 
if(Input::get('user_id')){	
	$user_id = urldecode(base64_decode(Input::get('user_id')));
	//echo $user_id;
	//echo "Yes";
	//exit;
}else{
	$session->message("No user was specified!!!");
	//echo " No";
	//redirect_to("users.php");	
}
//echo $user_id;
if(isset($user_id)){
	
	if($session->session_no == Session::session_no($user_id) || $session->session_no == Session::session_no(1)){
		if($user_id > 0){
			$user = User::find_by_id($user_id);
			
		}
	}else{
		$session->message("error: You are not allowed to perform this action");
		redirect_to("index.php?p=main");
	}	
}else{
	echo "<p>No id</p>";
	exit;
	$session->message("error: No user was specified");
	//redirect_to("index.php?p=users");
}
//echo "<pre>".print_r($user, true)."</pre>";
//			exit;

if(Input::get('submit')){
	$inputs = array("password", "new_password_1", "new_password_2");
	foreach ($inputs as $input){
		$$input =  Input::get($input);
	}
	
	if($user->change_pass($password, $new_password_1, $new_password_2)){
		$session->message("success: Password edit successful");
		if($user->user_type == "student"){
			redirect_to("index.php?p=student&user_id=".urlencode(base64_encode($user->id)));
		}
		redirect_to("index.php?p=staff&user_id=".urlencode(base64_encode($user->id)));	
	}else{
		$session->message("error: Password edit failed");
		if($user->user_type == "student"){
			redirect_to("index.php?p=student&user_id=".urlencode(base64_encode($user->id)));
		}
		redirect_to("index.php?p=staff&user_id=".urlencode(base64_encode($user->id)));
	}
}

?>
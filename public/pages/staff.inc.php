<?php  
if(Input::get('add') || (Input::get('edit'))){
	//echo $user_id;
	if(Input::get('user_id')){
	$user = User::find_by_id($user_id);
		echo "<h1>Staff: ".$user->full_name()."</h1>";
	}
	if(Input::get('edit')){
		user_admin_action($user_id);
	}
	require_once("forms/staff.php"); 
}else{
	require_once("displays/staff.php");
}
?></div>
<?php 
$restricted = true;
check_restriction();
?>

<h1>Phones</h1>  


<?php 
if(Input::get('add') || (Input::get('edit'))){
	if(Input::get('edit')){
		Phone::return_user_id($phone_id);
		user_admin_action($user_id);
	}
	require_once("forms/phone.php"); 
}else{
	require_once("displays/phone.php");	
}
?>
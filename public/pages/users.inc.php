<?php 
//$restricted = true;
//check_restriction();
?>

<!--<h1>System Users</h1>  -->


<?php 
//exit;
if(Input::get('add') || (Input::get('edit'))){
	if(Input::get('edit')){
		user_admin_action($user_id);
	}
	require_once("forms/users.php"); 
}else{
	require_once("displays/users.php");	
	//echo "<a href='index.php?c=users&p=users&add=true'>Add User</a>";
}
?>
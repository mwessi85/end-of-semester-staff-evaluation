<h1>Postions</h1>

<?php 
if(Input::get('add') || (Input::get('edit'))){
	if(Input::get('edit')){
		if(isset($session)){
			admin_only($session->user_id);
		}
	}
	require_once("forms/position.php");
}else{
	require_once("displays/position.php");	
}
?>
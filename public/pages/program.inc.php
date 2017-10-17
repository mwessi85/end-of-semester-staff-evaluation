<h1>Programs</h1>

<?php 
if(Input::get('add') || (Input::get('edit'))){
	if(Input::get('edit')){
		if(isset($session)){
			admin_only($session->user_id);
		}
	}
	require_once("forms/program.php");
}else{
	require_once("displays/program.php");	
}
?>
<h1>Titles</h1>

<?php 
if(Input::get('add') || (Input::get('edit'))){
	if(Input::get('edit')){
		if(isset($session)){
			admin_only($session->user_id);
		}
	}
	require_once("forms/title.php");
}else{
	require_once("displays/title.php");	
}
?>
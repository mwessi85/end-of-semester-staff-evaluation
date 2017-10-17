<h1>Question category</h1>

<?php 
if(Input::get('add') || (Input::get('edit'))){
	if(Input::get('edit')){
		if(isset($session)){
			admin_only($session->user_id);
		}
	}
	require_once("forms/question_category.php");
}else{
	require_once("displays/question_category.php");	
}
?>
<?php 
if(Input::get('add') || (Input::get('edit'))){
	if(Input::get('edit')){
		if(isset($session)){
			admin_only($session->user_id);
		}
	}
	require_once("forms/question_answer.php");
}else{
	$total_count = Question_answer::count_all();
	$per_page = 30;
	$pagination = new Pagination($page, $per_page, $total_count);
	$departments = Question_answer::find_all(" WHERE year='".YEAR."' LIMIT ".$per_page." OFFSET ".$pagination->offset());
	require_once("displays/question_answers.php");	
}
?>
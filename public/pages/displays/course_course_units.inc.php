<?php 
if(Input::get('add') || (Input::get('edit'))){
	if(Input::get('edit')){
		if(isset($session)){
			admin_only($session->user_id);
		}
	}
	require_once("forms/course_course_unit.php");
}else{
	$course_course_units = Course_course_unit::find_all();
	require_once("displays/course_course_units.php");	
}
?>
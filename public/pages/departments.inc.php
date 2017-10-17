<?php 
if(Input::get('add') || (Input::get('edit'))){
	if(Input::get('edit')){
		if(isset($session)){
			admin_only($session->user_id);
		}
	}
	require_once("forms/department.php");
}else{
	
	$total_count = Department::count_all();
	$per_page = 30;
	$pagination = new Pagination($page, $per_page, $total_count);
	if(isset($_POST['name'])){
	$condition = "AND name LIKE '%".$_POST['name']."%'";
	}else{
		$condition = "";	
	}
	$departments = Department::find_all(" WHERE type='Academic' ".$condition."LIMIT ".$per_page." OFFSET ".$pagination->offset());
	require_once("displays/departments.php");	
	
}
?>
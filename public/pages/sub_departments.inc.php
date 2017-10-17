<?php 
if(Input::get('add') || (Input::get('edit'))){
	if(Input::get('edit')){
		if(isset($session)){
			admin_only($session->user_id);
		}
	}
	require_once("forms/sub_department.php");
}else{
	$total_count = Sub_department::count_all();
	$per_page = 30;
	$pagination = new Pagination($page, $per_page, $total_count);
	if(isset($_POST['name'])){
	$condition = " WHERE name LIKE '%".$_POST['name']."%'";
	}else{
		$condition = "";	
	}
	$sub_departments = Sub_department::find_all($condition." LIMIT ".$per_page." OFFSET ".$pagination->offset());?>
    <form method="post" action="index.php?p=sub_departments" autocomplete="off">
    <fieldset>
        <legend>Search Department</legend>
    <p>
        <label for="make">Name: </label>
        <input type="search" name="name" id="name" placeholder="Enter name or part of name and click search" autofocus="autofocus">
        
        <input type="submit" name="search" value="Search">
    </p>
    </fieldset>
</form>
    <?php
	require_once("displays/sub_departments.php");
	
	
	
	//$sub_departments = Sub_department::find_all();
	//require_once("displays/sub_departments.php");	
}
?>
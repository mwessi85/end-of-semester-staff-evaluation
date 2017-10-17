<?php 
if(Input::get('add') || (Input::get('edit'))){
	if(Input::get('edit')){
		if(isset($session)){
			admin_only($session->user_id);
		}
	}
	require_once("forms/course_unit.php");
}else{
	$total_count = Course_unit::count_all();
	$per_page = 50;
	$pagination = new Pagination($page, $per_page, $total_count);
	if(isset($_POST['name'])){
	$condition = " WHERE name LIKE '%".trim($_POST['name'])."%'";
	}else{
		$condition = "";	
	}
	$course_units = Course_unit::find_all($condition." ORDER BY `course_units`.`id` DESC LIMIT ".$per_page." OFFSET ".$pagination->offset());?>
    <form method="post" action="index.php?p=course_units">
    <fieldset>
        <legend>Search Course unit</legend>
    <p>
        <label for="course_unit_search">Course unit: </label>
        <input type="search" name="name" id="course_unit_search" placeholder="Enter name or part of name and click search" autofocus="autofocus">
        
        <input type="submit" name="search" value="Search">
    </p>
    </fieldset>
</form>
	<div><a href='index.php?c=course_unit&p=course_units&add=true'>Add Course Units</a></div>
	<?php
	//$course_units = Course_unit::find_all();
	require_once("displays/course_units.php");	
}
?>
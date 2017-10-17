<?php 
//Course::category_array();
//$categories = Course::categories();
//echo "<pre>".print_r($categories, true)."</pre>";
if(Input::get('add') || (Input::get('edit'))){
	if(Input::get('edit')){
		if(isset($session)){
			admin_only($session->user_id);
		}
	}
	require_once("forms/course.php");
}else{
	$total_count = Course::count_all();
	$per_page = 30;
	$pagination = new Pagination($page, $per_page, $total_count);
	if(isset($_POST['name'])){
		$condition = " WHERE name LIKE '%".$_POST['name']."%'";
	}else{
		$condition = "";	
	}
	$courses = Course::find_all($condition."  ORDER BY name LIMIT ".$per_page." OFFSET ".$pagination->offset());?>
    <form method="post" action="index.php?p=courses" autocomplete="off">
    <fieldset>
        <legend>Search Course</legend>
    <p>
        <label for="make">Name: </label>
        <input type="search" name="name" id="name" placeholder="Enter name or part of name and click search" autofocus="autofocus">
        
        <input type="submit" name="search" value="Search">
    </p>
    </fieldset>
</form>
	
	<?php 
	//$courses = Course::find_all();
	require_once("displays/courses.php");	
}
?>

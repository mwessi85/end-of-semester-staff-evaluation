<?php 
if(!isset($course_unit->id)){
	$session->message("error: course unit was not specified");
	redirect_to("index.php?c=course_unit&p=course_units");	
}
?>
<h1><?php echo (isset($course_unit->code)) ? strtoupper($course_unit->code).": " : "" ; ?><?php echo titleCase($course_unit->name); ?></h1>
<?php if($session->is_admin()) :?>
    <div><p><a href='index.php?c=course_unit&p=course_units&add=true'>Add Course Units</a></div>
<?php endif?>


<?php //require_once("displays/sub_department_profile.php"); ?>
<?php //require_once("displays/sub_department_staff.php"); ?>
<?php //require_once("displays/sub_department_publications.php"); ?>
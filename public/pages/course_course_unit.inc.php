<?php 
if(!isset($course->id)){
	$session->message("error: Course was not specified");
	redirect_to("index.php?c=course&p=courses");	
}
$sql = "SELECT c.id course_id, c.name course, c.code course_code, cu.name, cu.code course_unit_code, ccu.status, ccu.id course_course_unit_id, ccu.course, ccu.course_unit FROM course_course_units ccu INNER JOIN courses c ON (c.id=ccu.course) INNER JOIN course_units cu ON (cu.id = ccu.course_unit) AND c.id =".$course->id;

if(!empty($course->sub_department)){
	$sub_department = Sub_department::find_by_id($course->sub_department);
}
if(!empty($course->department)){
	$department = Department::find_by_id($course->department);
}
?>
<?php if(!empty($department)){?>
<h1><a href="index.php?c=department&p=department&department_id=<?php echo urlencode(base64_encode($department->id));?>"><?php echo titleCase($department->name); ?></a>&nbsp;>>&nbsp;<?php echo (isset($course->code)) ? strtoupper($course->code).": " : "" ; ?><?php echo titleCase($course->name); ?></h1>
<?php }elseif(!empty($sub_department)){?>
<h1><a href="index.php?c=sub_department&p=sub_department&sub_department_id=<?php echo urlencode(base64_encode($sub_department->id));?>"><?php echo titleCase($sub_department->name); ?></a>&nbsp;>>&nbsp;<?php echo (isset($course->code)) ? strtoupper($course->code).": " : "" ; ?><?php echo titleCase($course->name); ?></h1>
<?php }?>

<?php //require_once("displays/sub_department_profile.php"); ?>
<?php //require_once("displays/sub_department_staff.php"); ?>
<?php //require_once("displays/sub_department_publications.php"); ?>
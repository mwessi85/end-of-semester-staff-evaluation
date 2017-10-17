<?php 

if(!isset($department->id)){
	$session->message("error: Department was not specified");
	redirect_to("index.php?c=department&p=departments");	
}
?>

<h1><?php echo $department->name; ?></h1>

<?php //require_once("displays/department_profile.php"); ?>
<div style="width: 250px; float: left; margin-right: 5%; clear:both; border: 0px solid #666;">
<?php $sub_departments = Sub_department::find_all(" WHERE department='".$department->id."'");
$department_page = true;
if($sub_departments){
	require_once("displays/sub_departments.php");	
}
?>
</div>
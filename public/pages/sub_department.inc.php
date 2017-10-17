<?php 

if(!isset($sub_department->id)){
	$session->message("error: Sub-department was not specified");
	redirect_to("index.php?c=sub_department&p=sub_departments");	
}
$department = Department::find_by_id($sub_department->department);
?>

<h1><a href="index.php?c=department&p=department&department_id=<?php echo urlencode(base64_encode($department->id));?>"><?php echo titleCase($department->name); ?></a>&nbsp;>>&nbsp;<?php echo titleCase($sub_department->name); ?></h1>
<?php if($sub_department->about !=""){?>
<!--<p><?php echo $sub_department->about; ?></p>-->
<?php }?>

<?php //require_once("displays/sub_department_profile.php"); ?>
<?php //require_once("displays/sub_department_staff.php"); ?>
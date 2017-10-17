<div style="width: 830px; float: left; margin-right: 5%; clear:both; border: 0px solid #666;">

<table class="results">
<tr>
<th>Departments</th>
<th>&nbsp;</th>
<th>&nbsp;</th>
</tr>
<?php
$i = 1;
foreach($sub_departments as $sub_department) : ?>
<?php 
$department = Department::find_by_id($sub_department->department);
//echo "<pre>".print_r($department, true)."</pre>";
//exit;
$user = User::find_by_id($sub_department->head);
if(isset($user->id)){
	$staff = Staff::find_by_user_id($user->id);
	if($staff->id){
		$title = Title::find_by_id($staff->title);
		$position = Position::find_by_id($staff->position);
		$head_title = $title->title.". ".$user->full_name()." (".$position->title.")";
	}
}

 ?>
<tr>
<td><a href="index.php?c=sub_department&p=sub_department&sub_department_id=<?php echo urlencode(base64_encode($sub_department->id));?>" title="<?php echo isset($head_title) ? "Head: ".$head_title : "";?>"><?php echo titleCase($sub_department->name); ?></a></td>

<?php if($session->is_admin()) :?>
<td><a href="index.php?c=sub_department&p=sub_departments&edit=true&sub_department_id=<?php echo urlencode(base64_encode($sub_department->id))?>">Edit</a></td>
</td>
<td><a href="index.php?c=csv_download&p=sub_departments&download=true&sub_department_id=<?php echo urlencode(base64_encode($sub_department->id));?>">Download</a></td>
<?php endif ?>

<!--<td><a href="delete_department.php?id=<?php echo urlencode(base64_encode($sub_department->id));?>">Delete</a></td>-->
</tr>
<?php endforeach;?>
</table>
<?php //$sub_department = NULL;?>
<?php if($session->is_admin()) :
		if(isset($department_page)){
?>
    <div><p><a href='index.php?c=sub_department&p=sub_departments&add=true&department_id=<?php echo urlencode(base64_encode($sub_department->department)); ?>'>Add Sub Department</a></p></div>
	<?php 
		}else{?>
		<div><p><a href='index.php?c=sub_department&p=sub_departments&add=true'>Add Sub Department</a></p></div>		
	<?php 	}
	endif?>
</div>
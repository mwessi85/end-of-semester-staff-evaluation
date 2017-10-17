<div style="width: 830px; float: left; margin-right: 5%; clear:both; border: 0px solid #666;">
<table class="results">
<tr>
<th>Courses</th>
<th>&nbsp;</th>
<th>&nbsp;</th>
<th>&nbsp;</th>
<th>&nbsp;</th>
<!--<th>Faculty/Department</th>-->
</tr>
<?php
//echo "<pre>".print_r($courses, true)."</pre>";
$i = 1;
foreach($courses as $course) { ?>

<?php 

//echo "<pre>".print_r($course, true)."</pre>";
if(!empty($course->sub_department)){
	$sub_department = Sub_department::find_by_id($course->sub_department);
}
if(!empty($course->department)){
	$department = Department::find_by_id($course->department);
}
//if(!empty($department) || !empty($sub_department)){?>
<tr>
<td><a href="index.php?c=course&p=course&course_id=<?php echo urlencode(base64_encode($course->id));?>"><?php echo (isset($course->code)) ? strtoupper($course->code).": " : "" ; ?><?php echo titleCase($course->name); ?></a></td>
<?php 
/*if(!empty($course->department)){?>
<td>Faculty of <a href="index.php?c=department&p=department&department_id=<?php echo urlencode(base64_encode($department->id));?>"><?php echo titleCase($department->name); ?></a></td>
<?php
}else{?>
<td>Department of <a href="index.php?c=sub_department&p=sub_department&sub_department_id=<?php echo urlencode(base64_encode($sub_department->id));?>"><?php echo titleCase($sub_department->name); ?></a></td>
<?php }*/?>
<td>
</td>
<td>
<?php if($session->is_admin()) :?>
<a href="index.php?c=course&p=courses&edit=true&course_id=<?php echo urlencode(base64_encode($course->id))?>">Edit</a>
<?php endif ?>
</td>

<?php if($session->is_admin()) :?>
<td><a href="index.php?c=course&p=courses&edit=true&full_edit=true&course_id=<?php echo urlencode(base64_encode($course->id))?>">Full Edit</a></td>
<td><a href="index.php?c=csv_download&p=courses&download=true&course_id=<?php echo urlencode(base64_encode($course->id));?>">Download</a></td>
<?php endif ?>

</tr>


	
<?php
//}?>

<?php }?>
</table>
<div id="pagination" style="clear:both; text-align:center;">
<?php bottom_pagination("index.php?p=courses");?>
</div>
<?php if($session->is_admin()) :?>
    <div><p><a href='index.php?c=course&p=courses&add=true'>Add Courses</a></div>
	<?php endif?>
</div>
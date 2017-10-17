<?php if(isset($course_course_units)){ ?>
<div>
<table class="results">
<tr>
<th>Course Unit</th>
<th>Course</th>
<th>&nbsp;</th>
</tr>
<?php
$i = 1;
//echo "<pre>".print_r($course_course_units, true)."</pre>";
	//exit;
foreach($course_course_units as $course_course_unit) { ?>
<?php 
$course = Course::find_by_id($course_course_unit->course);
$course_unit = Course::find_by_id($course_course_unit->course_unit);
?>
<tr>
<td><a href="index.php?c=course_unit&p=course_unit&course_unit_id=<?php echo urlencode(base64_encode($course_unit->id));?>" title=""><?php echo titleCase($course_unit->name); ?></a></td>
<td><a href="index.php?c=course&p=course&course_id=<?php echo urlencode(base64_encode($course->id));?>" title=""><?php echo titleCase($course->name); ?></a></td>
<?php if($session->is_admin()){?>
<td><a href="index.php?c=course_course_unit&p=course_course_units&edit=true&course_course_unit_id=<?php echo urlencode(base64_encode($course_course_unit_id->id));?>">Edit</a></td>

<?php } ?>

<!--<td><a href="delete_department.php?id=<?php echo urlencode(base64_encode($department->id));?>">Delete</a></td>-->
</tr>
<?php }?>
</table>
<?php if($session->is_admin()){?>
    <div><p><a href='index.php?c=department&p=departments&add=true'>Add Department</a></div>
	<?php }?>
</div>
<?php  }?>

<?php 
if(isset($query)){
// echo (isset($department->id)) ? "&department=".$department->id : "";
?>
<div>
<table class="results">
<tr>
<th>Course Units</th>
<th>Year</th>
<th>Semester</th>
<th>Lecturer</th>
<th>&nbsp;</th>
<th>&nbsp;</th>
<th>&nbsp;</th>

</tr>
<?php
$i = 1;
//$rows = $query->fetchAll();
//echo "<pre>".print_r($rows, true)."</pre>";
//exit;
while($row = $query->fetch(PDO::FETCH_ASSOC)) {
	$user = User::find_by_id($row['lecturer']);	
?>
<tr>
<td>
<?php $course_complete = Question_answer::find_if_complete(YEAR, SEMESTER, $course->id, $row['course_unit'], $session->user_id, $row['lecturer']);
			if($course_complete>=1 || Staff::find_by_user_id($session->user_id)){ ?>
            
<?php echo strtoupper($row['course_unit_code']); ?>: &nbsp;<?php echo $row['name']; ?>
    <?php }else{?>
    <a href='index.php?c=question&p=questions&course_course_unit_id=<?php echo urlencode(base64_encode($row['course_course_unit_id'])); ?><?php echo (isset($department->id)) ? "&department=".$department->id : "";?>'>
<?php echo strtoupper($row['course_unit_code']); ?>: &nbsp;<?php echo $row['name']; ?></a>
    <?php }?>
    </td>
<td><?php echo $row['year']; ?></td>
<td><?php echo $row['semester']; ?></td>
<td><?php echo $user->full_name(); ?></td>

<?php if($session->is_admin()) :?>
<td><a href="index.php?c=course_course_unit&p=course_course_units&edit=true&course_course_unit_id=<?php echo urlencode(base64_encode($row['course_course_unit_id'])); ?>">Edit</a></td>
<td><a href="index.php?c=course_course_unit&p=course_course_units&delete=true&course_course_unit_id=<?php echo urlencode(base64_encode($row['course_course_unit_id']));?>" onclick="return areYouSure('Deleting this record might mess up your question/answer data. Check agin if you really want to do this')">Delete</a></td>
<td style="width:50px;">




<?php
if(Input::get('report')){
$sql = "SELECT DISTINCT(branch) branch FROM question_answers WHERE course_course_unit_id = ".$row['course_course_unit_id'];
//echo $sql;
$result = $database->query($sql);
if($result){
	//echo "<pre>".print_r($branch_rows, true)."</pre>";
	$branches = Branch::getBranches();
	$branch_rows = $result->fetchALL(PDO::FETCH_ASSOC);
	//echo "<pre>".print_r($branch_rows, true)."</pre>";
	if($branch_rows){
	
?>
<ul style=" list-style:none;">
<li><a onClick="return toggleMenu('menu<?php echo $i;?>')" style="color: red; text-decoration:none;"><strong>Report</strong></a></span></li>


<span class='menu' id='menu<?php echo $i;?>'>



<?php
	//echo "<pre>".print_r($branch_rows, true)."</pre>";
	foreach($branch_rows as $branch_row){
		//echo $branch_row;
		$branch = ucfirst($branches[$branch_row['branch']]);
		//echo $branch;
		?>
	<li><a href="index.php?p=report&course_course_unit_id=<?php echo urlencode(base64_encode($row['course_course_unit_id']));?>&branch=<?php echo urlencode(base64_encode($branch_row['branch']));?>"><?php echo $branch ;?></a></li>
<?php		
	}
	
	}?>
    
    
    
</span>
</ul>
<?php
	}
}
?>

</td>
<?php endif ?>

<!--<td><a href="delete_department.php?id=<?php echo urlencode(base64_encode($row['author']));?>">Delete</a></td>-->
</tr>
<?php 
$i++;
}?>
</table>
<?php if($session->is_admin()){?>
    <div><p><a href="index.php?c=course_course_unit&p=course_course_units&add=true&course_course_unit_id=<?php echo urlencode(base64_encode($row['course_course_unit_id'])); ?>&course_id=<?php echo urlencode(base64_encode($course->id)); ?>">Add course unit</a>
    
<?php if(isset($course_id)){?>
 | <a href="index.php?c=course&p=course&course_id=<?php echo urlencode(base64_encode($course->id));?>&report=true">Report</a>
<?php 
}
}?>
</div>
<?php }?>
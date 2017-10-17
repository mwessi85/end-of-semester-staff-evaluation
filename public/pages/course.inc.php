<?php 

if(!isset($course->id)){
	$session->message("error: Course was not specified");
	redirect_to("index.php?c=course&p=courses");	
}
if(!empty($course->sub_department)){
	$sub_department = Sub_department::find_by_id($course->sub_department);
}
if(!empty($course->department)){
	$department = Department::find_by_id($course->department);
}
?>
<?php /*if(!empty($department)){?>
<?php if($session->is_admin()){?><h1>
<a href="index.php?c=department&p=department&department_id=<?php echo urlencode(base64_encode($department->id));?>"><?php echo titleCase($department->name); ?></a>
<?php }else{?>
<?php echo titleCase($department->name); ?> 
<?php }?>&nbsp;>>&nbsp;<?php echo (isset($course->code)) ? strtoupper($course->code).": " : "" ; ?><?php echo titleCase($course->name); ?>
<?php if($session->is_admin()){?>
(<a href="index.php?c=course&p=courses&edit=true&course_id=<?php echo urlencode(base64_encode($course->id))?>">Edit</a>)
<?php } ?>
</h1>
<?php }elseif(!empty($sub_department)){?>
<h1><a href="index.php?c=sub_department&p=sub_department&sub_department_id=<?php echo urlencode(base64_encode($sub_department->id));?>"><?php echo titleCase($sub_department->name); ?></a>&nbsp;>>&nbsp;<?php echo (isset($course->code)) ? strtoupper($course->code).": " : "" ; ?><?php echo titleCase($course->name); ?> </h1>
<?php }*/?>
<h1><?php echo titleCase($course->name); ?> </h1>

<div style="width: 100%; float: left; margin-right: 5%; clear:both; border: 0px solid #666;">
<h2 style="padding-top:0.1px; padding-bottom:0.1px; margin-top:0.1px;">Course Units</h2>
<?php 
	
$per_page = 100;
$total_count = Course_course_unit::find_all_course_course_units_count($course->id);

$pagination = new Pagination($page, $per_page, $total_count);
if(isset($course_id)){
$query = Course_course_unit::find_all_course_course_units_by_course(" ORDER BY course_course_unit_id ASC, cu.name DESC LIMIT ".$per_page." OFFSET ".$pagination->offset());
	//echo "<pre>".print_r($query, true)."</pre>";
	$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
	require_once("displays/course_course_units.php");
}
?>
<div id="pagination" style="clear:both; text-align:center;">
<?php bottom_pagination("index.php?p=publications");?>
</div>
<?php
$students = Student::find_all_by_course_id($course->id);
//echo "<pre>".print_r($students, true)."</pre>";
?>
<?php if($students){?>
<h2 style="clear:both;">Students under course</h2>
<table class="results">
<tr>
<th>Name</th>
<th>Reg No.</th>
<th>Branch</th>
<th>username</th>
<th>Completion status</th>
</tr>
<?php
$i = 1;

	foreach($students as $student){
	
	?>
	<tr>
	<?php 
	//$course_student_id = $student->user_id;
	if($user = User::find_by_id($student->user_id)){
		$student->student_no = str_replace("/", "-", $student->student_no);
		$stud_no = explode('-', $student->student_no);
		$branch = substr($stud_no[2],0,1);
		//echo $branch;
		$branches = Branch::getBranches();
		$branch = ucfirst($branches[$branch]);
		//$course_unit_total = $student->course_unit_no;
		$course_unit_total = $student->course_unit_no;
		$count_display = "";
		
		$units = Student_course_unit::find_all_by_user_id($student->user_id);
		$unit_array = array();
		if($units){
		foreach($units as $unit){
			$unit_array[] = $unit->course_course_unit;
		}
		$unit_array_values = "'" . implode("', '", $unit_array) . "'";
		//echo "<pre>".print_r($unit_array, true)."</pre>";
		$query = Course_course_unit::find_all_course_course_units_by_student(" WHERE ccu.id IN (".$unit_array_values.") ORDER BY cu.name DESC");
		//$row = $query->fetchAll();
		//echo "<pre>".print_r($row, true)."</pre>";
		//exit;
		}
		
		if(isset($query)){
			$course_unit_count = 0;
			while($row = $query->fetch(PDO::FETCH_ASSOC)) {
				//echo $row['course_unit']." | ";
				$course_complete = Question_answer::find_if_complete(YEAR, SEMESTER, $row['course_unit'], $student->user_id, $row['lecturer']);	
				//echo "<pre>".print_r($row, true)."</pre>";
				if($course_complete){
					++$course_unit_count;
					
				}
				//echo "<p>".$course_complete."</p>";
				
			}
			//echo "<p><strong>".$course_unit_count."</strong></p>";
			if($course_unit_count >= $student->course_unit_no && $course_unit_count == $student->course_unit_no){
				$count_display = "<span class='success'>".$course_unit_count."/".$course_unit_total."</span>";	
			}elseif($course_unit_count > 0){
				$count_display = "<span class='warning'>".$course_unit_count."/".$course_unit_total."</span>";		
			}else{
				$count_display = "<span class='error'>".$course_unit_count."/".$course_unit_total."</span>";	
			}	
		}
		
		?>
		
		<?php if(Session::user_permission($user->id)){ ?>
        <td><a href="index.php?c=student&p=student&user_id=<?php echo urlencode(base64_encode($student->user_id));?>"><?php echo $user->full_name(); ?></a></td>
        <?php }else{ ?>
                <td><?php echo $user->full_name(); ?></td>
        <?php } ?>
    <?php } ?>

	<td><?php echo $student->student_no; ?></td>
    <!--<td><?php echo $student->year; ?></td>-->
		<td><?php echo $branch; ?></td>
    <td><?php echo $user->username; ?></td>
    <td><?php echo $count_display; ?></td>
    <td><a href='index.php?p=students_completion&update=1&respondent_id=<?php echo urlencode(base64_encode($user->id));?>'>Update</a></td>
	</tr>
	<?php }?>
    <?php if($session->is_admin()) :?>
<a href="index.php?c=csv_download&p=courses&download=true&students=true&course_id=<?php echo urlencode(base64_encode($course->id));?>">Download</a>
<?php endif ?>
</table>
<?php 
}?>
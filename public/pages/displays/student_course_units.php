<?php if($student_course_units){?>
<?php if(isset($_SESSION['st_user_id'])){?>
<div>
<h2 style="padding-top:0.1px; padding-bottom:0.1px; margin-top:0.1px;">Course Units</h2>
<table class="results">
<tr>
<th>Course Units</th>
<th>Year</th>
<th>Semester</th>
<th>Lecturer</th>
<th>Retake</th>
<th>&nbsp;</th>
</tr>
<?php
$i = 1;
//echo "<pre>".print_r($student_course_units, true)."</pre>";
foreach($student_course_units as $student_course_unit){
$course_course_unit = Course_course_unit::find_course_course_unit($student_course_unit->course_course_unit);
//echo "<pre>".print_r($course_course_unit, true)."</pre>";
$lecturer = User::find_by_id($course_course_unit['lecturer']);	
	?>

<tr>
<td>
<?php 
$course_complete = Question_answer::find_if_complete(YEAR, SEMESTER, $course_course_unit['course'], $course_course_unit['course_unit'], $session->user_id, $row['lecturer']);
			if($course_complete>=1 || Staff::find_by_user_id($session->user_id)){ ?>
            
<?php echo strtoupper($course_course_unit['course_unit_code']); ?>: &nbsp;<?php echo $course_course_unit['course_unit_name']; ?>
    <?php }else{?>
    <a href='index.php?c=question&p=questions&course_course_unit_id=<?php echo urlencode(base64_encode($course_course_unit['course_course_unit_id'])); ?>'>
<?php echo strtoupper($course_course_unit['course_unit_code']); ?>: &nbsp;<?php echo $course_course_unit['course_unit_name']; ?></a>
    <?php }?>
    </td>
<td><?php echo $course_course_unit['year']; ?></td>
<td><?php echo $course_course_unit['semester']; ?></td>
<td><?php echo $user->full_name(); ?></td>
<td><?php echo ($student_course_unit->retake == "yes") ? "<span class='required'>".ucfirst($student_course_unit->retake)."</span>" : ucfirst($student_course_unit->retake); ?></td>

<?php if($session->is_admin()) :?>
<td><a href="index.php?c=course_course_unit&p=course_course_units&delete=true&course_course_unit_id=<?php echo urlencode(base64_encode($course_course_unit['course_course_unit_id'])); ?>" onclick="return areYouSure('Deleting this record might mess up your question/answer data. Check again if you really want to do this')">Delete</a></td>
<?php endif ?>
</tr>
<?php };?>
</table>
</div>
<?php }?>
<?php }?>
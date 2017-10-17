<?php
$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 200000;
$total_count = Student::count_all();

$pagination = new Pagination($page, $per_page, $total_count);
$students = Student::find_all(" ORDER BY id DESC LIMIT ".$per_page." OFFSET ".$pagination->offset());
if(!empty($update) && !empty($respondent_id)){
	$students = Student::find_all(" WHERE user_id =  ".$respondent_id." ORDER BY id DESC LIMIT ".$per_page." OFFSET ".$pagination->offset());	
}
//echo $total_count;
//exit;
?>
<?php if($students){?>
<!--<h2 style="clear:both;">Students completion status (<?php echo sizeOf($students); ?>)</h2>-->
<h2 style="clear:both;">Students completion status (<?php echo $total_count; ?>)</h2>
<table class="results">
<tr>
<th>Name</th>
<th>Reg No.</th>
<th>Completion status.</th>
</tr>
<?php
$i = 1;
	//echo "<pre>".print_r($students, true)."</pre>";
	foreach($students as $student){?>
	<tr>
	<?php 
	//$course_student_id = $student->user_id;
	if($user = User::find_by_id($student->user_id)){
		
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
		$query = Course_course_unit::find_all_course_course_units_by_student(" WHERE ccu.id IN (".$unit_array_values.") ORDER BY cu.name DESC");
		}
		
		if(isset($query)){
			$course_unit_count = 0;
			while($row = $query->fetch(PDO::FETCH_ASSOC)) {
				//echo $row['course_unit']." | ";
				$course_complete = Question_answer::find_if_complete(YEAR, SEMESTER, $row['course_unit'], $student->user_id, $row['lecturer']);	
				//echo "<pre>".print_r($row, true)."</pre>";
				if(!empty($course_complete)){
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
			//$count_display = $count_display."<a href='index.php?c=student_completion_update'>Update</a>"	
			}
			
			if(!empty($respondent_id)){
				if($respondent_id == $student->user_id){
					if(!empty($update)){
						//echo "<p>".$count_display."</p>";
						$sql = "UPDATE students SET course_unit_complete = ".$course_unit_count." WHERE user_id = ".$respondent_id;
						//echo $sql;
						//exit;
						$result = $database->query($sql);
						$session->message("success: Competion status edited successfully");
						redirect_to("index.php?c=student&p=student&user_id=".urlencode(base64_encode($student->user_id)));	
					}
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
    
    <td><?php echo $count_display; ?></td>
    <td><a href='index.php?p=students_completion&update=1&respondent_id=<?php echo urlencode(base64_encode($student->user_id));?>'>Update</a></td>
	</tr>
	<?php }?>
    <?php if($session->is_admin()) :?>

<?php endif ?>
</table>
<?php 
}?>
<p></p>
<div id="pagination" style="clear:both; text-align:center;">
<?php bottom_pagination("index.php?p=students_completion");
echo "(".$total_count.")";
?>
</div>
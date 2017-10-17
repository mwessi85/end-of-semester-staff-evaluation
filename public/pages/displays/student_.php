<div style="border:0px solid #666; clear:both;">
<?php 
if(Input::get('user_id')){
	$user_id = urldecode(base64_decode(Input::get('user_id')));	
}
if($student = Student::find_by_user_id($user_id)){
	$course_object = Course::find_by_id($student->course);
	$student_user_id = $student->user_id;
	$program = "(".$student->student_program().")";
	if($course_object){
		$course_code = $course_object->code.": ";
		$student_course = $course_code.titleCase($course_object->name)." ".$program;
	}else{
		$student_course = "";	
	}
	//$staff_department = Department::find_by_id($staff->department);
	$user = User::find_by_id($user_id);
?>    
    <div style="margin-top:2em; border: 0px solid #666; clear:both; ">
       <!-- <div style="border: 0px solid #666; width: 250px; float: left">-->
        <div style="width: 200px; float: left; margin-right: 5%; clear:both;">
            <?php //require_once("photo.php"); ?>
            
        <?php if(isset($_SESSION['st_user_id'])){?>
			<?php 
            if($session->session_no == Session::session_no($user_id) || $session->session_no == Session::session_no(1)){
                //require_once("pages/forms/photo.php");
            }
            ?>
        <?php }?>
        </div>
    </div>
    
    <table>
	<tr>
	<tr>
    	<td class="label"></td>
        <td><strong><?php echo $user->full_name(); ?></strong></td>
    </tr>
    <tr>
        <td class="label">Course:</td>
        <?php  //if($session->session_no == Session::session_no($user_id) || $session->session_no == Session::session_no(1)){?>
		<?php  if($session->session_no == Session::session_no(1)){?>
        <td><a href="index.php?c=course&p=course&course_id=<?php echo urlencode(base64_encode($student->course));?>"><?php echo $student_course; ?></a></td>
        <?php }else{?>
		<td><?php echo $student_course; ?></td>
		<?php }?>
    </tr>
	
    <tr>
        <td class="label">Year of study:</td>
        <td> <?php echo $student->year; ?></td>
    </tr>
    
	<tr>
        <td class="label">Email:</td>
        <td> <?php echo $user->email; ?></td>
    </tr>
<?php if(isset($_SESSION['st_user_id'])){?>
	<?php  if($session->session_no == Session::session_no(1)){?>
        <tr>
            <td class="label"></td>
            <td><span class="required">Edit:</span>
            <a href="index.php?p=users&c=users&user_id=<?php echo urlencode(base64_encode($user->id));?>&edit=true">User Details</a> | 
            <a href="index.php?p=password&c=password&user_id=<?php echo urlencode(base64_encode($user->id));?>">Password</a></td>
        </tr>
    <?php }?>
<?php }?>
	<tr>
        <td class="label">Student No:</td>
        <td> <?php echo $student->student_no; ?></td>
    </tr>
    <tr>
        <td class="label">Total lecturers:</td>
        <td> <?php echo $student->course_unit_no; ?></td>
    </tr>
	
<?php if(isset($_SESSION['st_user_id'])){;?>
	<?php  //if($session->session_no == Session::session_no($user_id) || $session->session_no == Session::session_no(1)){?>
    <?php  if($session->session_no == Session::session_no(1)){?>
             <td class="label"></td>
             <td><span class="required">Edit:</span>
             <a href="index.php?p=student&c=student&student_id=<?php echo urlencode(base64_encode($student->id));?>&user_id=<?php echo urlencode(base64_encode($user->id));?>&edit=true">Student Details</a></td>
         </tr>
    <?php }?>
<?php }?>	

<?php if($phones = Phone::find_all_by_user_id($user_id)){?>
        <tr><td class="label">Tel:</td><td>
		<?php 
			$i = 0;
			foreach($phones as $phone) { 
			
						
		?>
			<?php if(isset($_SESSION['st_user_id'])){?>
				<?php  if($session->session_no == Session::session_no($user_id) || $session->session_no == Session::session_no(1)){?>
                <a href='index.php?c=phone&p=phone&user_id=<?php echo urlencode(base64_encode($user->id));?>&edit=true&phone_id=<?php echo  urlencode(base64_encode($phone->id));?>'>
				<?php 
					 if($i == 0){
					 	echo $phone->phone_number(); 
					 }else{
						echo ", ".$phone->phone_number();	 
					 }
					 
					 ?>
                </a>
                
            <?php }else{
				if($i == 0){
					 	echo $phone->phone_number(); 
					 }else{
						echo ", ".$phone->phone_number();	 
					 }
			}?>
            
            <?php }else{?>
            <?php 
					 if($i == 0){
					 	echo $phone->phone_number(); 
					 }else{
						echo ", ".$phone->phone_number();	 
					 }
					 
					 ?>
                	 
                <?php }
				
				$i++;
				?>
		<?php }
	}?> 
    <?php if(isset($_SESSION['st_user_id'])){?>
	<?php  if($session->session_no == Session::session_no($user_id) || $session->session_no == Session::session_no(1)){?>
	   <!--&nbsp;|&nbsp; <a href='index.php?c=phone&p=phone&user_id=<?php echo urlencode(base64_encode($user->id));?>&add=true'>Add Phone</a>-->
	<?php }?>   
    </td>
    </tr>
	<?php }?>
	</table>
    
    
    <?php ;
	$units = Student_course_unit::find_all_by_user_id($user_id);
	$unit_array = array();
	if($units){
	foreach($units as $unit){
		$unit_array[] = $unit->course_course_unit;
	}
	$unit_array_values = "'" . implode("', '", $unit_array) . "'";
	//echo "<pre>".print_r($unit_array, true)."</pre>";
	//global $course_id;
	$query = Course_course_unit::find_all_course_course_units_by_student(" WHERE ccu.id IN (".$unit_array_values.") ORDER BY cu.name DESC");
?>
    <table class="results">
        <tr>
        <th>Course Units</th>
        <th>Year</th>
        <th>Semester</th>
        <th>Lecturer</th>
        <th>&nbsp;</th>
        </tr>
        <?php
        $i = 1;
        //echo "<p>".print_r($query, true)."</p>";
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $user = User::find_by_id($row['lecturer']);	
            ?>
        
        <tr>
        <td>
        <?php 
		//echo SEMESTER;
		//$lecturer_id = $row['lecturer'];
		$course_complete = Question_answer::find_if_complete(YEAR, SEMESTER, $row['course_unit'], $session->user_id, $row['lecturer']);
					//echo $course_complete."**<br>"; 
		if($course_complete >= 1 || Staff::find_by_user_id($session->user_id)){ ?>           
        <?php echo $row['course_unit_code']; ?>: &nbsp;(<?php echo $row['name']; ?>)
            <?php }else{?>
            <a href='index.php?c=question&p=questions&course_course_unit_id=<?php echo urlencode(base64_encode($row['course_course_unit_id'])); ?><?php echo (isset($department->id)) ? "&department=".$department->id : "";?>'>
        <?php echo $row['course_unit_code']; ?>: &nbsp;(<?php echo $row['name']; ?>)</a>
            <?php }?>
            </td>
        <td><?php echo $row['year']; ?></td>
        <td><?php echo $row['semester']; ?></td>
        <td><?php echo $user->full_name(); ?></td>
        <?php if($course_complete < 1 ){?>
        <td><a href="index.php?c=student_course_unit&delete=true&student_user_id=<?php echo urlencode(base64_encode($student_user_id));?>&course_course_unit_id=<?php echo urlencode(base64_encode($row['course_course_unit_id'])); ?>">Delete</a></td>
        <?php }?>
        
        <?php if($session->is_admin()) :?>
        <td><a href="index.php?c=course_course_unit&p=course_course_units&edit=true&course_course_unit_id=<?php echo urlencode(base64_encode($row['course_course_unit_id'])); ?>">Edit</a></td>
        <?php endif ?>
        
        <!--<td><a href="delete_department.php?id=<?php echo urlencode(base64_encode($row['author']));?>">Delete</a></td>-->
        </tr>
        
        <?php }
		
	}?>
	</table>
    
    <?php 
	//echo "<p>".print_r($unit_array, true)."</p>";
	//echo count($unit_array);
	//exit;
	if(count($unit_array) < $student->course_unit_no){?>
    <h3>Add Course units</h3>
    <table class="form_table">
<form name="form1" autocomplete="off" 
action="index.php?c=student_course_unit&student_id=<?php echo urlencode(base64_encode($student_id));?>&user_id=<?php echo urlencode(base64_encode($user_id));?>" method="post">
</tr>
<tr>
    <td><label for="student_course_course_unit_search" class="label">Course Unit:</label></td>
    <td>
    <input type="hidden" name="student_course_course_unit" id="student_course_course_unit" value=""/>
    <input type="search" name="student_course_course_unit_search" id="student_course_course_unit_search" value="" required="required" placeholder="Type your course name and select your program from the suggestions given which corresponds with your lecturer" title = "Note: There could be a course unit tought by several different lecturers, please select, out of those, only the course unit that was tought by your lecturer"/>
    </td>
</tr>
<tr>
    <td></td>
    <td><input class="button submit" type="submit" name="submit" id="submit" value="Submit" />   </td>
    
</tr>
<tr>
    <td><a href="index.php?p=student&user_id=<?php echo urlencode(base64_encode($user_id));?>&edit=true"><!--Clear--></a></td>
    <td><a href="index.php?c=student&p=student&user_id=<?php echo urlencode(base64_encode($user_id));?>">Cancel</a></td>
    
</tr>

</form>
</table>
    
<?php 
	}
}
?>

<?php
$course_id = $student->course;
$students = Student::find_all_by_course_id($student->course);
//echo "<pre>".print_r($students, true)."</pre>";
?>
<?php if($students){?>
<h2 style="clear:both;">Students under course</h2>
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
		//echo "<pre>".print_r($unit_array, true)."</pre>";
		$query = Course_course_unit::find_all_course_course_units_by_student(" WHERE ccu.id IN (".$unit_array_values.") ORDER BY cu.name DESC");
		$row = $query->fetchAll();
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
				$count_display = "<span class='success'>Complete</span>";	
			}elseif($course_unit_count > 0){
				$count_display = "<span class='warning'>".$course_unit_count."/".$course_unit_total."</span>";		
			}else{
				$count_display = "<span>".$course_unit_count."/".$course_unit_total."</span>";	
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
	</tr>
	<?php }?>
    <?php if($session->is_admin()) :?>
<a href="index.php?c=csv_download&p=courses&download=true&students=true&course_id=<?php echo urlencode(base64_encode($course_id));?>">Download</a>
<?php endif ?>
</table>
<?php 
}?>

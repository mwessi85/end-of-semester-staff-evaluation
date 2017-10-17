<div style="border:0px solid #666; clear:both;">
<?php
if(empty($readonly)){
//$sql = "SELECT * FROM student_course_units WHERE user_id = '".$user_id."'";
//	$result = $database->query($sql);
//	$row = $result->fetchColumn();
	if(isset($warning_message) && $session->session_no != Session::session_no(1)){
		echo "<span class='warning'>".$warning_message."</span>";	
	}
}
?>
<?php 
if(Input::get('user_id')){
	$user_id = urldecode(base64_decode(Input::get('user_id')));	
}
if($student = Student::find_by_user_id($user_id)){
	$student_user_id = $student->user_id;
	$course_object = Course::find_by_id($student->course);
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
    <div style="margin-top:1em; border: 0px solid #666; clear:both; ">
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
	<!--<tr>
    	<td class="label"></td>
        <td><strong><?php echo $user->full_name(); ?></strong></td>
    </tr>-->
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
        <td class="label">Username:</td>
        <td> <?php echo $user->username; ?></td>
        <?php if(isset($_SESSION['st_user_id'])){?>
	<?php  if($session->session_no == Session::session_no(1)){?>
            <td><span class="required">Edit:</span>
            <a href="index.php?p=users&c=users&user_id=<?php echo urlencode(base64_encode($user->id));?>&edit=true">User Details</a> | 
            <a href="index.php?p=password&c=password&user_id=<?php echo urlencode(base64_encode($user->id));?>">Password</a></td>
    <?php }else{?>
            <td><span class="required">Edit:</span>
            <a href="index.php?p=password&c=password&user_id=<?php echo urlencode(base64_encode($user->id));?>">Password</a></td>
<?php 
	}}?>
        
    


	<tr>
        <td class="label">Student No:</td>
        <td> <?php echo str_replace ("/", "-", $student->student_no); ?></td>
    </tr>
    <tr>
        <td class="label">Branch:</td>
        <td> <?php echo (isset($branch)) ? $branch : ""; ?></td>
    </tr>
    <tr>
        <td class="label">Total lecturers:</td>
        <td> <?php echo $student->course_unit_no; ?></td>
        <?php if(isset($_SESSION['st_user_id'])){;?>
             <td><span class="required">Edit:</span>
             <a href="index.php?p=student&c=student&student_id=<?php echo urlencode(base64_encode($student->id));?>&user_id=<?php echo urlencode(base64_encode($user->id));?>&edit=true">Student Details</a></td>
<?php }?>	
    </tr>
	


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
	//if($units){
	if(is_array($units)){
		foreach($units as $unit){
			$unit_array[] = $unit->course_course_unit;
		}
	$unit_array_values = "'" . implode("', '", $unit_array) . "'";
	//echo "<pre>".print_r($unit_array, true)."</pre>";
	//global $course_id;
	$query = Course_course_unit::find_all_course_course_units_by_student(" WHERE ccu.id IN (".$unit_array_values.") ORDER BY cu.name DESC");
	}else{
		$query = "";
	}
	
	if(count($unit_array) < $student->course_unit_no){?>
    <!--<h3>Add Course units</h3>-->
    <table class="form_table">
    <script>
    $().ready(function() {
		$("#student_course_course_unit_search").autocomplete("get/student_course_unit.php?course_id=<?php echo $student->course;?>", {
			width: '55%',
			matchContains: true,
			//mustMatch: true,
			//minChars: 0,
			//multiple: true,
			//highlight: false,
			//multipleSeparator: ",",
			selectFirst: false
		});
		$("#student_course_course_unit_search").result(function(event, data, formatted) {
			$("#student_course_course_unit").val(data[1]);
		});
	});
    </script>
<form name="form1" autocomplete="off" 
action="index.php?c=student_course_unit&student_id=<?php echo urlencode(base64_encode($student_id));?>&user_id=<?php echo urlencode(base64_encode($user_id));?>" method="post">
</tr>
<tr>
    <td><label for="student_course_course_unit_search" class="label">Add Course units:</label></td>
    <td>
    <input type="hidden" name="student_course_course_unit" id="student_course_course_unit" value=""/>
    <input type="search" name="student_course_course_unit_search" id="student_course_course_unit_search" value="" required="required" placeholder="Type your course name and select your program from the suggestions given which corresponds with your lecturer" title = "Note: There could be a course unit tought by several different lecturers, please select, out of those, only the course unit that was tought by your lecturer" style="width: 700px;" autofocus="autofocus"/>&nbsp;Auto-suggest
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
?>

    <table class="results">
        <tr>
        <th colspan="2">Course Units</th>
        <th>Year</th>
        <th>Semester</th>
        <th>Lecturer</th>
        <th>&nbsp;</th>
        </tr>
        <?php
        $i = 1;
		if($query){
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $user = User::find_by_id($row['lecturer']);	
            ?>
        
        <tr>
        
        <?php 
		//echo SEMESTER;
		//$lecturer_id = $row['lecturer'];
		$course_complete = Question_answer::find_if_complete(YEAR, SEMESTER, $row['course_unit'], $session->user_id, $row['lecturer']);
					//echo $course_complete."**<br>"; 
					if($course_complete >= 1 || Staff::find_by_user_id($session->user_id)){ ?>
                    <td><?php echo strtoupper($row['course_unit_code']); ?>:</td>
					<td><?php echo $row['name']; ?></td>
            <?php }else{?>
            <td>
        <?php echo strtoupper($row['course_unit_code']); ?>:</td>
        <td><a href='index.php?c=question&p=questions&course_course_unit_id=<?php echo urlencode(base64_encode($row['course_course_unit_id'])); ?>
			<?php echo (isset($department->id)) ? "&department=".$department->id : "";?>'>
			<?php echo $row['name']; ?></a></td>
            <?php }?>
            
        <td><?php echo $row['year']; ?></td>
        <td><?php echo $row['semester']; ?></td>
        <td><?php echo $user->full_name(); ?></td>
        
        <?php if($session->is_admin()) {?>
        <td><a href="index.php?c=course_course_unit&p=course_course_units&edit=true&course_course_unit_id=<?php echo urlencode(base64_encode($row['course_course_unit_id'])); ?>">Edit</a></td>
        <?php } ?>
         <?php if($course_complete < 1 ){?>
        <td><a href="index.php?c=student_course_unit&delete=true&student_user_id=<?php echo urlencode(base64_encode($student_user_id));?>&course_course_unit_id=<?php echo urlencode(base64_encode($row['course_course_unit_id'])); ?>" onclick="return areYouSure('Deleting this record might mess up your question/answer data. Check again if you really want to do this')">Delete</a></td>
        <?php }?>
        
        <!--<td><a href="delete_department.php?id=<?php echo urlencode(base64_encode($row['author']));?>">Delete</a></td>-->
        </tr>
        
        <?php }
	}
		
?>
	</table>
    
    
    
    
    
    
    

<?php
}
?>

<?php
$course_id = $student->course;
$students = Student::find_all_by_course_id_filter_year($student->course, $student->year);
//echo "<pre>".print_r($students, true)."</pre>";
?>
<?php if($students){?>
<h2 style="clear:both;">Students under course</h2>
<table class="results">
<tr>
<th>Name</th>
<th>Reg No.</th>
<th>Branch</th>
<th>Username</th>
<th>Completion status</th>
<th>&nbsp;</th>
</tr>
<?php
$i = 1;
	//echo "<pre>".print_r($students, true)."</pre>";
	foreach($students as $student){
		$student->student_no = str_replace("/", "-", $student->student_no);
		$stud_no = explode('-', $student->student_no);
		$branch = substr($stud_no[2],0,1);
		//echo $branch;
		$branches = Branch::getBranches();
		$branch = ucfirst($branches[$branch]);
	?>
	<tr>
	<?php 
	//$course_student_id = $student->user_id;
	if($user = User::find_by_id($student->user_id)){
		
		//$course_unit_total = $student->course_unit_no;
		$course_unit_total = $student->course_unit_no;
		$course_unit_complete = $student->course_unit_complete;
		$count_display = "";
		
		/*
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
				echo $row['course_unit']." | ";
				$course_complete = Question_answer::find_if_complete(YEAR, SEMESTER, $row['course_unit'], $student->user_id, $row['lecturer']);	
				//echo "<pre>".print_r($row, true)."</pre>";
				if($course_complete){
					++$course_unit_count;
					
				}
				//echo "<p>".$course_complete."</p>";
				
			}
			//echo "<p><strong>".$course_unit_count."</strong></p>"; 
			*/
			if($course_unit_complete == $student->course_unit_no){
				$count_display = "<span class='success'>".$course_unit_complete."/".$course_unit_total."</span>";	
			}elseif($course_unit_complete >= 1){
				$count_display = "<span class='warning'>".$course_unit_complete."/".$course_unit_total."</span>";		
			}else{
				$count_display = "<span class='error'>0/".$course_unit_total."</span>";	
			}	
	//	}
		
		?>
		
		<?php if(Session::user_permission($user->id)){ ?>
        <td><a href="index.php?c=student&p=student&user_id=<?php echo urlencode(base64_encode($student->user_id));?>"><?php echo $user->full_name(); ?></a></td>
        <?php }else{ ?>
                <td><?php echo $user->full_name(); ?></td>
        <?php } ?>
    <?php } ?>

	<td><?php echo str_replace ("/", "-", $student->student_no); ?></td>
    <!--<td><?php echo $student->year; ?></td>-->
    <td><?php echo $branch; ?></td>
    <td><?php echo $user->username; ?></td>
    <td><?php echo $count_display; ?></td>
    <td><a href='index.php?p=students_completion&update=1&respondent_id=<?php echo urlencode(base64_encode($user->id));?>'>Update</a></td>
	</tr>
	<?php }?>
    <?php if($session->is_admin()) :?>
<a href="index.php?c=csv_download&p=courses&download=true&students=true&course_id=<?php echo urlencode(base64_encode($course_id));?>">Download</a>
<?php endif ?>
</table>
<?php 
}?>

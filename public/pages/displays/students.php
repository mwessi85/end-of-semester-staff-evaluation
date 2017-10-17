<?php
if(isset($session)){
	//echo "<pre>".print_r($session, true)."</pre>"; 
}
$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 30;
$total_count = User::count_all(" WHERE user_type = 'student'");
$pagination = new Pagination($page, $per_page, $total_count);
if(isset($_POST['name'])){
	$condition = " AND (first_name LIKE '%".$_POST['name']."%' OR last_name like  '%".$_POST['name']."%'  OR other_name like  '%".$_POST['name']."%') ";
}else{
	$condition = "";	
}
$sql = "SELECT * FROM users WHERE user_type = 'student'".$condition."ORDER BY id desc LIMIT ".$per_page." OFFSET ".$pagination->offset();
//echo $sql;

$users = User::find_by_sql($sql);
?>
<div>
    <form method="post" action="index.php?p=students" autocomplete="off">
        <fieldset>
            <legend>Search student</legend>
        <p>
            <label for="make">Name: </label>
            <input type="search" name="name" id="name" placeholder="Enter name or part of name and click search" autofocus="autofocus">
            
            <input type="submit" name="search" value="Search">
        </p>
        </fieldset>
	</form>
</div>
<div style="width: 830px; float: left; margin-right: 5%; clear:both; border: 0px solid #666;">
    <table class="results">
    <tr>
    <th>Name</th>
    <th>Student No.</th>
    <th>Branch</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
    </tr>
    <?php
    $i = 1;
	if($users){
    foreach($users as $user){
		$sudent_detail = Student::find_by_user_id($user->id);
		if($sudent_detail){
			if(!empty($sudent_detail->student_no)){
				//$student_no = $sudent_detail->student_no;
				$student_no = str_replace("/", "-", $sudent_detail->student_no);
				$stud_no = explode('-', $student_no);
				$branch = substr($stud_no[2],0,1);
				$branches = Branch::getBranches();
				$branch = ucfirst($branches[$branch]);			
			}
			if(!empty($sudent_detail->course)){
				$course_object = Course::find_by_id($sudent_detail->course);
				$program = "(".$sudent_detail->student_program().")";
				if($course_object){
					$course_code = $course_object->code.": ";
					$student_course = $course_code.titleCase($course_object->name)." ".$program;
				}		
			}
			
		}else{
			$student_course = "";
			$student_no = "Not set";
			$branch = "Not set";	
		}
		
	?>
    <tr>
    <!--<td><?php //echo $i++; ?></td>-->
    <?php 
	if(isset($session)){?>
    <?php  
		if($staff = Student::find_by_user_id($user->id)){?>
	<td><a href="index.php?c=student&p=student&user_id=<?php echo urlencode(base64_encode($user->id));?>" title="<?php echo $student_course;?>"><?php echo $user->full_name(); ?></a></td>		
	
	<?php }elseif(Session::user_permission($user->id)){?>
			<td><a href="index.php?c=student&p=student&user_id=<?php echo urlencode(base64_encode($user->id));?>" title="<?php echo $student_course;?>"><?php echo $user->full_name(); ?></a></td>
		<?php }
		else{?>
				<td><?php echo $user->full_name(); ?></td>
	<?php }?>
    <?php }else{?>
    <td><?php echo $user->full_name(); ?></td>
<?php }?>
    <td><?php echo $student_no; ?></td>
    <td><?php echo $branch; ?></td>
    <?php if(isset($session)){?>
		<?php 
        if(Session::user_permission($user->id)){?>
        <td><a href="index.php?p=users&c=users&user_id=<?php echo urlencode(base64_encode($user->id));?>&edit=true">Edit</a></td>
        <?php }?>
        <?php 
        if($session->session_no == Session::session_no(1)){?>
        <td><a href="index.php?p=student&c=student&user_id=<?php echo urlencode(base64_encode($user->id));?>&delete=true&c_delete=true" onclick="return areYouSure('Are you sure you want to delete the student: <?php echo $user->full_name()?>. You are going to competely delete this student. Note that this will delete all the students corresponding records in several other tables which might corrupt your data')">C-Delete</a></td>
        <td><a href='index.php?p=students_completion&update=1&respondent_id=<?php echo urlencode(base64_encode($user->id));?>'>Update</a></td>
        <?php }?>
		<?php 
        if($session->session_no == Session::session_no(1)){?>
        <td><a href="index.php?p=student&c=student&user_id=<?php echo urlencode(base64_encode($user->id));?>&delete=true" onclick="return areYouSure('Are you sure you want to delete the student: <?php echo $user->full_name()?>. Note that this will delete all the students corresponding records in several other tables which might corrupt your data')">Delete</a></td>
        <?php }?>
    <?php }?>
    </tr>
    <?php }
	}?>
    </table>
</div>
    <?php if(isset($session)){?>
		<?php if($session->session_no == Session::session_no(1)){?>
        <div><p><a href='index.php?c=users&p=users&add=true'>Add User</a></div>
        <?php }?>
    <?php }?>

<p></p>
<div id="pagination" style="clear:both; text-align:center;">
<?php bottom_pagination("index.php?p=students");
echo "(".$total_count.")";
?>
</div>
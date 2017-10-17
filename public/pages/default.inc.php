<h1>Home</h1>
<?php 
$per_page = 30;
$total_count = Question_answer::find_all_download_count();
$pagination = new Pagination($page, $per_page, $total_count);
$query = Question_answer::find_all_download(" ORDER BY id DESC LIMIT ".$per_page." OFFSET ".$pagination->offset());
?>

<!-- Departments summary -->
<div style="width: 100%; float: left; margin-right: 5%; clear:both; border: 0px solid #666;">

<?php if(isset($_SESSION['st_user_id'])){?>
	
	<?php if($session->session_no == Session::session_no(1)){?>
    <h3>Courses with evaluations</h3>
	<?php
			require_once("displays/active_courses.php");	?>
            <p><a href="index.php?p=students_completion">Student's Completion</a></p>
            <hr />
<?php	}?>
<?php }
echo "";
?>

<?php 
if(isset($query)){
?>
<span class='notification'><p>Welcome to the Course Evaluation portal. Please note that after you submit your evaluation forms, they are 100% anonymous. So feel free to evaluate your lecturer as they deserve and give suggestions and comments on the learning environment, library, lecturer, and university in general, without any fear. The information you give will enable the university make adjustments that will benefit you and those that will come after you. Your student details are needed only to ensure that you have evaluated all your lecturers, as this is a requirement for doing your end of semester exams. </p>
<p>Login and Click 'Evaluate Course' on the left panel to start the evauation process. If you find any difficulties, you can seek help from your class mates who have successfully completed the evaluation process or contact your administrator.</p>
</span>
<div>
<!--<table class="results">

<?php
$i = 1;
while($row = $query->fetch(PDO::FETCH_ASSOC)) {?>
<tr><td><?php //echo $row['id'];?></td></tr>	
<?php
};?>
</table>-->

</div>
<?php }?>
</div>



<?php 
if(Input::get('add') || (Input::get('edit'))){
	if(Input::get('edit')){
		if(isset($session)){
			admin_only($session->user_id);
		}
	}
	require_once("forms/question.php");
}else{

if(Input::get('course_course_unit_id')){
	?>
    <?php
		$logged_in_user = User::find_by_id($session->user_id);
		if($logged_in_user->user_type == "student"){
			if($student = Student::find_by_user_id($logged_in_user->id)){
				$program = "(".$student->student_program().")";
			}
		}
		else{
			$program = "";	
		}
		
        ?>
	<br />
    <form autocomplete="off" action="index.php?c=question_answer&course_course_unit_id=<?php echo urlencode(base64_encode($course_course_unit_id)); ?>" method="post">
    <table class="text">
    <tr>
    	<td class="label">Program:</td><td colspan="4"><?php echo $course_search." ".$program;?>
        
        </td>
    </tr>
    <tr>
    	<td class="label">Course Unit:</td><td><span class="red_outline"><?php echo $course_unit_search;?></span></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td class="label">Lecturer's/Facilitator's Name:</td><td><span class="red_outline"><?php echo $lecturer_name;?></span></td>
    </tr>
    
    <tr>
    	<td class="label">Faculty/Institute/School:</td><td><?php echo $department;?></td><td>&nbsp;</td><td class="label">Academic year-Semester:</td><td><?php echo $year."/".++$year." - Sem ".$semester;?></td>
    </tr>
    <tr>
    	<td class="label">Department:</td><td><?php echo $sub_department;?></td><td>&nbsp;</td><td class="label">Date:</td><td><?php echo $today;?></td>
    </tr>
    </table>
    <br />
    <strong>Please grade ranging from 1 to 5</strong>: 1=Unsatisfactory, 2=Below average, 3=Average/Good, 4=Very Good, 5=Excellent, N/A=Not applicable  
    <br />
	<?php }
	$question_categorys = Question_category::find_all(" ORDER BY id ASC");
	$i = 1;
	?>
	<table class="results">
    <tr>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
    </tr>
	<?php	
	foreach ($question_categorys as $question_category){
		$questions = Question::find_all(" WHERE category=".$question_category->id);?>
		<tr>
        <td><strong><?php echo titleCase($question_category->name);?></strong></td>
        <td>1</td>
        <td>2</td>
        <td>3</td>
        <td>4</td>
        <td>5</td>
        <td>NA</td>
        </tr>
        <?php 
		foreach ($questions as $question){?>
		<tr>
        <td><?php echo $i.". ".strtolower($question->question);?></td>
        <td><input type="radio" name="<?php echo $question->id; ?>" value="1" required/></td>
        <td><input type="radio" name="<?php echo $question->id; ?>" value="2"/></td>
        <td><input type="radio" name="<?php echo $question->id; ?>" value="3"/></td>
        <td><input type="radio" name="<?php echo $question->id; ?>" value="4"/></td>
        <td><input type="radio" name="<?php echo $question->id; ?>" value="5"/></td>
        <td><input type="radio" name="<?php echo $question->id; ?>" value="6"/></td>
        <?php if($session->is_admin()) :?>
        <td><a href="index.php?c=question&p=questions&edit=true&question_id=<?php echo urlencode(base64_encode($question->id));?>">
        Edit</a></td>
<?php endif ?>
        </tr>
		<?php $i++;}?>
<?php }?>
		<tr>
        <td colspan="7"></td>
        </tr>
        <tr>
        <td colspan="7"><strong>Suggest ways in which the course/module or facility could be improved for better teaching and learning</strong><br/>
        <textarea name="suggestion" id="suggestion" style="width:100%"></textarea></td>
        </tr>
        <tr>
        <td colspan="7"><strong>Comment on the lecturer, or any other comments</strong><br/>
        <textarea name="comment" id="comment" style="width:100%"></textarea></td>
        </tr>
        <tr>
        <td colspan="7"><input type="submit" name="submit" value="Submit" /></td>
        </tr>
	</table>
    </form>
    <?php if($session->is_admin()) :?>
    <div style="clear:both"><p><a href='index.php?c=question&p=questions&add=true'>Add question</a></div>
	<?php endif?>	
<?php }?>
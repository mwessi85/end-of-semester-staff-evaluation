<div>
<table class="form_table">
<form name="form1" autocomplete="off" 
action="index.php?c=student&student_id=<?php echo urlencode(base64_encode($student_id));?>&user_id=<?php echo urlencode(base64_encode($user_id));?>" method="post">
<!--<input type="hidden" name="student_id" id="student_id" value="<?php echo urlencode(base64_encode($student_id));?>" />
<input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id;?>" />-->
<span class='notification'>For Auto-suggest fields, type part of the name and select from the list</span>
<tr>
    <td><label for="student" class="label">Username:</label></td>
    <td>
    <input type="text" name="student" id="student" value="<?php echo $user->username;?>" required="required" disabled="disabled"/>
    </td>
</tr>
<tr>
    <td><label for="student" class="label">Student:</label></td>
    <td>
    <input type="text" name="student" id="student" value="<?php echo $user->full_name();?>" required="required" disabled="disabled"/>
    </td>
</tr>
<tr>
    <td><label for="student_no" class="label">Student No.</label></td>
    <!--<td><input type="search" name="student_no" id="student_no" value="<?php echo $student_no;?>" required="required" maxlength="15"/></td>-->
    <!--<td><input type="search" name="student_no" id="student_no" value="<?php echo $student_no;?>" required="required" 
    maxlength="15" pattern="[A-Z a-z 0-9 / -]{1,20}" title = "The student number should be in the format: 2016/B061/10011" placeholder="e.g 2016/B061/10011"
     <?php echo (empty($student_no) || $session->is_admin()) ? "" : $readonly?>
     /></td>-->
     
     <td><input type="search" name="student_no" id="student_no" value="<?php echo $student_no;?>" required="required" 
    maxlength="15" pattern="^20\d{2}[-]{1}[A-Z a-z]{1}\d{3}[-]{1}\d{5}$" title = "The student number should be in the format: 2016-B061-10011" placeholder="e.g 2016-B061-10011"
     <?php echo (empty($student_no) || $session->is_admin()) ? "" : $readonly?> autofocus="autofocus"/></td>
     
    <!-- <td><input type="search" name="student_no" id="student_no" value="<?php echo $student_no;?>" required="required" 
    maxlength="15" pattern="^20\d{2}[/ -]{1}[A-Z a-z]{1}\d{3}[/ -]{1}\d{5}$" title = "The student number should be in the format: 2016-B061-10011" placeholder="e.g 2016-B061-10011"
     <?php echo (empty($student_no) || $session->is_admin()) ? "" : $readonly?> autofocus="autofocus"/></td>-->
     
     
     
</tr>
<tr>
    <td><label for="course_search" class="label">Course:</label></td>
    <td>
    <input type="hidden" name="course" id="course" value="<?php echo $course;?>" />
    <input type="search" name="course_search" id="course_search" value="<?php echo $course_search;?>" required="required" placeholder="e.g Bachelor of Arts in Agriculture" title = "Type your course name and choose it from the autosuggest list" <?php echo (empty($student_no) || $session->is_admin()) ? "" : $readonly?>/>&nbsp;<span class='notification_inline'>Auto-suggest</span>
    </td>
</tr>
<tr>
    <td><label for="program_search" class="label">Study mode:</label></td>
    <td>
    <input type="hidden" name="program" id="program" value="<?php echo $program;?>" required="required" />
    <input type="search" name="program_search" id="program_search" value="<?php echo $program_search;?>" required="required" placeholder="Full time or evening or Part time or Distance learning" title="Type your program and choose it from the autosuggest list" <?php echo (empty($student_no) || $session->is_admin()) ? "" : $readonly?>/>&nbsp;<span class='notification_inline'>Auto-suggest</span>
    </td>
    </tr>
<tr>
 <td><label for="year" class="label">Year of study:</label></td>
    <td>
    <select name="year"  title="Select your year of study, either, 1st, 2nd, 3rd or 4th year"/>>
    <option value="" <?php echo ($year == "") ? "selected='selected'" : ""; ?> disabled="disabled">Choose year of study</option>
    <?php 	
	for($i = 1; $i<5; $i++){ ?>
    <option value="<?php echo $i;?>" <?php echo ($year == $i) ? "selected='selected'" : ""; ?>><?php echo "Year ".$i; ?></option>
    <?php } ?>
    </select>
    </td>
</tr>
<tr>
    <td><label for="course_unit_no" class="label">No. of lecturers to evaluate:</label></td>
    <td>
    <input type="number" name="course_unit_no" id="course_unit_no" max="20" min="1" value="<?php echo $course_unit_no;?>" required="required" title="Enter the number of lecturers you are evaluating this semester. If you have two lecturers for the same course unit, enter them both" placeholder="e.g 7" style=" width: 50px;"/>&nbsp;<span class='notification_inline'>If a course unit was taught by more than one lecturer, you should count both lecturers!</span>
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
</div>

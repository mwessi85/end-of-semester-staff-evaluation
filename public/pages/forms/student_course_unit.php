<table class="form_table">
<form name="form1" autocomplete="off" 
action="index.php?c=student_course_unit&student_id=<?php echo urlencode(base64_encode($student_id));?>&user_id=<?php echo urlencode(base64_encode($user_id));?>" method="post">
</tr>
<tr>
    <td><label for="student_course_course_unit_search" class="label">Course Unit:</label></td>
    <td>
    <input type="hidden" name="student_course_course_unit" id="student_course_course_unit" value="<?php echo $student_course_course_unit;?>" />
    <input type="search" name="student_course_course_unit_search" id="student_course_course_unit_search" value="<?php echo $student_course_course_unit_search;?><?php echo (isset($course)) ? ":".$course : "" ?>" required="required" placeholder="Type your course name and select your program from the suggestions given" title = "please take note of the program when selecting your course, if you are a part time student, make sure you select your course name with the part time program and not full time"/>
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
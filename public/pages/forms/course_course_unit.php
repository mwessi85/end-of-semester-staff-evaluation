<div>
    <table class="form_table">
	<form autocomplete="off" action="index.php?c=course_course_unit&course_course_unit_id=<?php echo urlencode(base64_encode($course_course_unit_id)); ?>" method="post">
	<tr>
    <td><label for="course" class="label">Course:</label></td>
    <td>
    <input type="hidden" name="course" id="course" value="<?php echo $course;?>" required="required" />
    <input style='width: 500px;' type="search" name="course_search" id="course_search" value="<?php echo $course_search;?>" 
	<?php echo $course_disabled;?> />
    </td>
    </tr>
    <tr>
    <td><label for="course_unit" class="label">Course Unit:</label></td>
    <td>
    <input type="hidden" name="course_unit" id="course_unit" value="<?php echo $course_unit;?>" required="required" />
    <input style='width: 500px;' type="search" name="course_unit_search" id="course_unit_search" value="<?php echo $course_unit_search;?>" 
	<?php echo $course_unit_disabled;?> />
    </td>
    </tr>
     <tr>
	<td><label for="year" class="label">Year:</label></td>
    <td><input type="number" name="year" id="year" value="<?php echo $year; ?>" style="width:50px;"/>/<?php echo (isset($year)) ? ++$year : ""; ?>
    </td>
	</tr>
    <tr>
    <td><label for="semester" class="label">Semester:</label></td>
    <td>
    <select name="semester">
    <option value="" <?php echo ($semester == "") ? "selected='selected'" : ""; ?> disabled="disabled">Choose semester</option>
    <option value="1" <?php echo ($semester == 1) ? "selected='selected'" : ""; ?>>I</option>
    <option value="2" <?php echo ($semester == 2) ? "selected='selected'" : ""; ?>>II</option>
    </select>
    </td>
    </tr>
    <tr>
    <td><label for="user_search" class="label">Lecturer:</label></td>
    <td><input type="search" name="user_search" id="user_search" placeholder="<?php echo $user_search; ?>" required="required" value="<?php echo $user_search; ?>"/></td>
	<input type="hidden" name="user" id="user" value="<?php echo $user_id; ?>" />
    </tr>
    <tr>
    <td><label for="status" class="label">Status:</label></td>
    <td><input type="radio" name="status" value="active" 
        <?php 
        if($status == "active"){
                echo " checked ";
        }
        ?> required /> Active
        </td>
         <td><input type="radio" name="status" value="inactive" 
        <?php 
        if($status == "inactive"){
                echo " checked ";
        }
        ?>/> Inactive
        </td>
    </tr>
    <tr>
    <td></td>
    <td><input class="button submit" type="submit" name="submit" id="submit" value="Enter" /></td>
	</tr>
    <td></td>
    <td><a href="index.php?p=course<?php echo (!empty($course)) ? "&c=course&course_id=".urlencode(base64_encode($course)) : ""; ?>">Cancel</a></td>
    </tr>
	</form>
	</table>
</div>
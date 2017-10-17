<div>
    <table class="form_table">
	<form autocomplete="off" action="index.php?c=course&course_id=<?php echo urlencode(base64_encode($course_id)); ?>" method="post">
	<tr>
	<td><label for="name" class="label">Course:</label></td>
    <td><input type="search" name="name" id="name" value="<?php echo $name; ?>" required="required" placeholder="Enter the course name, e.g Bachelor of Computer Science"/>
    </td>
    <tr>
    <tr>
    <td><label for="code" class="label">Course code:</label></td>
    <td><input type="search" name="code" id="code" value="<?php echo $code; ?>" placeholder="Enter a course code, e.g. BCSC"/></td>
    </tr>
    <tr>
    <td><label for="sub_department_search" class="label">Department:</label></td>
    <td>
    <input type="hidden" name="sub_department" id="sub_department" value="<?php echo $sub_department;?>" required="required" />
    <input type="search" name="sub_department_search" id="sub_department_search" value="<?php echo $sub_department_search;?>" <?php echo $disabled;?>  <?php echo $sub_department_disabled;?> placeholder="Choose a department from the autosuggest list" title="If a course falls under a certain department, e.g. Bachelors in Development Studuies falls under Department of development studies, select the department (Development studies) from the autosuggest list that appears as you type. If it falls directly under a faculty, you can leave this field blank"/>
    </td>
    </tr>
    <tr>
    <td><label for="department_search" class="label">Faculty:</label></td>
    <td>
    <input type="hidden" name="department" id="department" value="<?php echo $department;?>" required="required" />
    <input type="search" name="department_search" id="department_search" value="<?php echo $department_search;?>" <?php echo $disabled;?> <?php echo $department_disabled;?> placeholder="Choose a faculty institute or school from the autosuggest list" title="If a course falls under a certain faculty institute or school, e.g. Bachelors of Business Administration falls under Faculty of Business Administration, select the Faculty (Faculty of Business Administration) from the autosuggest list that appears as you type." required="required"/>
    </td>
    </tr>
    <tr>
     <td><label for="category" class="label">Category:</label></td>
        <td>
        <select name="category"  title=""/>
        <option value="" <?php echo (empty($category)) ? "selected='selected'" : ""; ?> disabled="disabled">Choose Category</option>
        <?php 	
        $categories = Course::category_array();
		//echo "<pre>".print_r($categories, true)."</pre>";
		foreach($categories as $key => $value){ ?>
        <option value="<?php echo $key;?>" <?php echo ($category == $key) ? "selected='selected'" : ""; ?>><?php echo $value; ?></option>
        <?php } ?>
        </select>
        </td>
    </tr>
    <tr>
     <td><label for="duration" class="label">Duration:</label></td>
        <td>
        <select name="duration"  title=""/>
        <option value="" <?php echo (empty($duration)) ? "selected='selected'" : ""; ?> disabled="disabled">Choose duration</option>
        <?php 	
        for($i = 1; $i<5; $i++){ ?>
        <option value="<?php echo $i;?>" <?php echo ($duration == $i) ? "selected='selected'" : ""; ?>><?php echo $i; ?></option>
        <?php } ?>
        </select>
        </td>
    </tr>
    <!--<tr>
    <td><label for="course_unit_no" class="label">Number of course units done:</label></td>
    <td>
    <input type="number" name="course_unit_no" id="course_unit_no" max="6" min="3" value="<?php echo $course_unit_no;?>" title="Enter the number if course units a student is expected to take. If a student takes 3 cores and two electives, then the number is 5. they should not exceed 6 or go below 3"/>
    </td>
    </tr>-->
    <tr>
    <td></td>
    <td><input class="button submit" type="submit" name="submit" id="submit" value="Submit" /></td>
	</tr>
    <td></td>
    <?php if(isset($course->id)){?>
    <td><a href="index.php?c=course&p=course&course_id=<?php echo urlencode(base64_encode($course->id));?>">Cancel</a></td>
	<?php } else{?>
    <td><a href="index.php?p=courses">Cancel</a></td>
    <?php }?>
    </tr>
	</form>
	</table>
</div>
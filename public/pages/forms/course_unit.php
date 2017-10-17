<div>
    <table class="form_table">
	<form autocomplete="off" action="index.php?c=course_unit&course_unit_id=<?php echo urlencode(base64_encode($course_unit_id)); ?>" method="post">
	<tr>
	<td><label for="course_unit_search" class="label">Course Unit:</label></td>
    <td><input type="search" name="name" id="course_unit_search" value="<?php echo $name; ?>" required="required" autofocus="autofocus"/>
    </td>
    <tr>
    <tr>
    <td><label for="code" class="label">Course code:</label></td>
    <td><input type="search" name="code" id="code" value="<?php echo $code; ?>" required="required"/></td>
    </tr>
    <tr>
    <td><label for="credit_unit" class="label">Credit Units:</label></td>
    <td><input type="number" step="0.5" name="credit_unit" id="credit_unit" value="<?php echo $credit_unit; ?>" max="4.0" min="0.0"  /></td>
    </tr>
   	<tr>
     <td><label for="semester" class="label">Semester:</label></td>
        <td>
        <select name="semester"  title=""/>
        <option value="" <?php echo (empty($semester)) ? "selected='selected'" : ""; ?> disabled="disabled">Choose semester</option>
        <?php 	
        for($i = 1; $i<3; $i++){ ?>
        <option value="<?php echo $i;?>" <?php echo ($semester == $i) ? "selected='selected'" : ""; ?>><?php echo $i; ?></option>
        <?php } ?>
        </select>
        </td>
    </tr>
    <tr>
     <td><label for="year" class="label">Year:</label></td>
        <td>
        <select name="year"  title=""/>
        <option value="" <?php echo (empty($year)) ? "selected='selected'" : ""; ?> disabled="disabled">Choose year of study</option>
        <?php 	
        for($i = 1; $i<5; $i++){ ?>
        <option value="<?php echo $i;?>" <?php echo ($year == $i) ? "selected='selected'" : ""; ?>><?php echo $i; ?></option>
        <?php } ?>
        </select>
        </td>
    </tr>
    <tr>
    <td></td>
    <td><input class="button submit" type="submit" name="submit" id="submit" value="Submit" /></td>
	</tr>
    <td></td>
    <td><a href="index.php?p=course_units">Cancel</a></td>
    </tr>
	</form>
	</table>
</div>
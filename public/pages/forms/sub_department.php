<div>
    <table class="form_table">
	<form autocomplete="off" action="index.php?c=sub_department&sub_department_id=<?php echo urlencode(base64_encode($sub_department_id)); ?>" method="post">
	<tr>
	<td><label for="name" class="label">Department:</label></td>
    <td><input type="search" name="name" id="name" value="<?php echo $name; ?>" required="required"/>
    </td>
    <tr>
    <td><label for="department_search" class="label">Academic Unit:</label></td>
    <td>
    <input type="hidden" name="department" id="department" value="<?php echo $department;?>" required="required" />
    <input type="search" name="department_search" id="department_search" value="<?php echo $department_search;?>" required="required"<?php echo $disabled;?> />
    </td>
    </tr>
	<!--<tr>
    <td><label for="user_search" class="label">Department Head:</label></td>
    <td><input type="search" name="user_search" id="user_search" placeholder="<?php echo $user_search; ?>" /></td>
	<input type="hidden" name="user" id="user" value="<?php echo $sub_department_head; ?>" />
    </tr>
    <tr>
    <td><label for="user_search" class="label">Briefly about the department:</label></td>
    <td><textarea name="about"><?php echo $about; ?></textarea></td>
    </tr>-->
	<tr>
    <td></td>
    <td><input class="button submit" type="submit" name="submit" id="submit" value="Submit" /></td>
	</tr>
    <td></td>
    <td><a href="index.php?p=sub_department<?php echo (!empty($sub_department_id)) ? "&c=sub_department&sub_department_id=".urlencode(base64_encode($sub_department_id)) : ""; ?>">Cancel</a></td>
    </tr>
	</form>
	</table>
</div>
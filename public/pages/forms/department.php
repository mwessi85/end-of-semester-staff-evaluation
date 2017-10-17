<div>
    <table class="form_table">
	<form autocomplete="off" action="index.php?c=department&department_id=<?php echo urlencode(base64_encode($department_id)); ?>" method="post">
	<tr>
	<td><label for="name">Academic Unit:</label></td>
    <td><input type="search" name="name" id="name" value="<?php echo $name; ?>" required="required"/>
    </td>
	</tr>
	<!--<tr>
    <td><label for="user_search">Department Head:</label></td>
    <td><input type="search" name="user_search" id="user_search" placeholder="<?php echo $user_search; ?>" /></td>
	<input type="hidden" name="user" id="user" value="<?php echo $department_head; ?>" />
    </tr>-->
    <!--
    <tr>
    <td><label for="user_search">Message from Head:</label></td>
    <td><textarea name="head_message"><?php echo $head_message; ?></textarea></td>
    </tr>
    <tr>
    <td><label for="user_search">Briefly about the Academic Unit:</label></td>
    <td><textarea name="about"><?php echo $about; ?></textarea></td>
    </tr>-->
    <tr>
    <td><label for="type">Department Type:</label></td>
    <td>
    <select name="type">
    <option value="" <?php echo ($type == "") ? "selected='selected'" : ""; ?> disabled="disabled">Choose Department type</option>
    <option value="Academic" <?php echo ($type == "Academic") ? "selected='selected'" : ""; ?>>Academic</option>
    <option value="Non-academic" <?php echo ($type == "Non-academic") ? "selected='selected'" : ""; ?>>Non-academic</option>
    </select>
    </tr>
	<tr>
    <td></td>
    <td><input class="button submit" type="submit" name="submit" id="submit" value="Submit" /></td>
	</tr>
    <td></td>
    <td><a href="index.php?p=departments">Cancel</a></td>
    </tr>
	</form>
	</table>
</div>
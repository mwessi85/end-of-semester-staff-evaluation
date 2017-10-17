<div>
    <table class="form_table">
	<form autocomplete="off" action="index.php?c=position&position_id=<?php echo urlencode(base64_encode($position_id)); ?>" method="post">
	<tr>
	<td><label for="name">Title:</label></td>
    <td><input type="search" name="title" id="title" value="<?php echo $title; ?>" required="required"/>
    <!--<input type="hidden" name="position_id" id="position_id" value="<?php echo urlencode(base64_encode($position_id)); ?>" />-->
    </td>
	</tr>
	<tr>
    <td><label for="category">Category:</label></td>
    <td>
    <select name="category">
    <option value="" <?php echo ($category == "") ? "selected='selected'" : ""; ?> disabled="disabled">Choose staff category</option>
    <option value="Academic" <?php echo ($category == "Academic") ? "selected='selected'" : ""; ?>>Academic</option>
    <option value="Non-academic" <?php echo ($category == "Non-academic") ? "selected='selected'" : ""; ?>>Non-academic</option>
    </select>
    </td>
    </tr>
	<tr>
    <td></td>
    <td><input class="button submit" type="submit" name="submit" id="submit" value="Submit" /></td>
	</tr>
    <td></td>
    <td><a href="index.php?p=position">Cancel</a></td>
    </tr>
	</form>
	</table>
</div>
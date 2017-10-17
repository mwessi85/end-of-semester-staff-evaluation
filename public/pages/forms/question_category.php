<div>
    <table class="form_table">
	<form autocomplete="off" action="index.php?c=question_category&question_category_id=<?php echo urlencode(base64_encode($question_category_id)); ?>" method="post">
	<tr>
	<td><label for="name" class="label">Question Category:</label></td>
    <td><input type="search" name="name" id="name" value="<?php echo $name; ?>" required="required"/></td>
	</tr>
	<tr>
    <td></td>
    <td><input class="button submit" type="submit" name="submit" id="submit" value="Submit" /></td>
	</tr>
    <td></td>
    <td><a href="index.php?p=question_category">Cancel</a></td>
    </tr>
	</form>
	</table>
</div>
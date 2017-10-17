<div>
    <table class="form_table">
	<form autocomplete="off" action="index.php?c=title&title_id=<?php echo urlencode(base64_encode($title_id)); ?>" method="post">
	<tr>
	<td><label for="title">Title:</label></td>
    <td><input type="search" name="title" id="title" value="<?php echo $title; ?>" required="required"/>
    <!--<input type="hidden" name="title_id" id="title_id" value="<?php echo urlencode(base64_encode($title_id)); ?>" />-->
    </td>
	</tr>
	<tr>
    <td></td>
    <td><input class="button submit" type="submit" name="submit" id="submit" value="Submit" /></td>
	</tr>
    <td></td>
    <td><a href="index.php?p=title">Cancel</a></td>
    </tr>
	</form>
	</table>
</div>
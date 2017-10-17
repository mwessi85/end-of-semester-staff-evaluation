<div>
    <table class="form_table">
	<form autocomplete="off" action="index.php?c=program&program_id=<?php echo urlencode(base64_encode($program_id)); ?>" method="post">
	<tr>
	<td><label for="name">Title:</label></td>
    <td><input type="search" name="name" id="name" value="<?php echo $name; ?>" required="required"/>
    <!--<input type="hidden" name="program_id" id="program_id" value="<?php echo urlencode(base64_encode($program_id)); ?>" />-->
    </td>
	</tr>
	<tr>
    <td><label for="ccode">Code:</label></td>
    <td><input type="search" name="code" id="code" value="<?php echo $code; ?>" required="required"/>
    </td>
    </tr>
	<tr>
    <td></td>
    <td><input class="button submit" type="submit" name="submit" id="submit" value="Submit" /></td>
	</tr>
    <td></td>
    <td><a href="index.php?p=program">Cancel</a></td>
    </tr>
	</form>
	</table>
</div>
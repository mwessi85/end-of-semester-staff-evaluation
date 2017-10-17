<div>    
<form autocomplete="on" action="index.php?c=password&user_id=<?php echo urlencode(base64_encode($user_id))?>" method="post" enctype="multipart/form-data" >
<!--<input type="hidden" name="id" id="id" value="<?php echo $user_id?>" />-->
<table class="form_table">
<tr>
<td><label for="password" class='label'>Current Passsword:</label></td>
<td><input type="password" name="password" id="password" value="" required="required" maxlength="30"/></td>
</tr>
<tr>
<td><label for="new_password_1" class='label'>New Password:</label></td>
<td><input type="password" name="new_password_1" id="new_password_1" value="" required="required" maxlength="30"/></td>
</tr>
<tr>
<td><label for="new_password_2" class='label'>Confirm Password:</label></td>
<td><input type="password" name="new_password_2" id="new_password_2" value="" required="required" maxlength="30"/></td>
</tr>

<tr>
<td></td>
<td><input class="button submit" type="submit" name="submit" id="add_user" value="Submit" /> </td>
<tr>
<td></td>
<td><a href="index.php?<?php 
if(isset($user->user_type)){
	if($user->user_type == "student"){
		echo "c=student&p=student&";
	}else{
		echo "c=staff&p=staff&";	
	}
}
echo "user_id=".urlencode(base64_encode($user_id));	?>">Cancel</a></td>

</tr>
</tr>
</table>
</form>
</div>
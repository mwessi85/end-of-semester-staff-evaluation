<span class='notification'>Note:<ul>
<li>If you have registered this semester (II) on this page, don't register again... ask your administrator for your username and password and login from the login page</li>
<li>Use the email that was assigned by the university (e.g. charles.mayiga@stud.umu.ac.ug). Do not use your private gmail or yahoo email addresses </li>
</ul>
</span>
<div>    
<form autocomplete="on" action="index.php?c=users&user_id=<?php echo urlencode(base64_encode($user_id))?>" 
method="post" enctype="multipart/form-data" >
<!--<input type="hidden" name="user_id" id="user_id" value="<?php echo urlencode(base64_encode($user_id))?>" />-->
<table class="form_table">
<tr>
 <td><label for="user_type" class="label">User type:<span class="required"> *</span></label></td>
    <td>
    <select name="user_type">
    <option value="" <?php echo ($user_type == "") ? "selected='selected'" : ""; ?> disabled="disabled">Choose a user type</option>
    <option value="staff" <?php echo ($user_type == "staff") ? "selected='selected'" : ""; ?>
	<?php if(!(admin())){ echo "disabled='disabled'";}?>>Staff</option>
    <option value="student" <?php echo ($user_type == "student" || !isset($session->user_id)) ? "selected='selected'" : ""; ?>>Student</option>
    </select>
    </td>
    </tr>
<tr>
<td><label for="last_name" class='label'>Surname:<span class="required"> *</span></label></td>
<td><input type="search" name="last_name" id="last_name" value="<?php echo $last_name; ?>" required="required" pattern="[A-Za-z]{1,25}" title="Remove any extra spaces" placeholder="e.g masereka"/></td>
</tr>
<tr>
<td><label for="first_name" class='label'>First Name:<span class="required"> *</span></label></td>
<td><input type="search" name="first_name" id="first_name" value="<?php echo $first_name; ?>" required="required" pattern="[A-Za-z]{1,25}" title="Remove any extra spaces" placeholder="e.g john"/></td>
</tr>

<tr>
<td><label for="other_name" class='label'>Other Name:</label></td>
<td><input type="search" name="other_name" id="other_name" value="<?php echo $other_name; ?>"  maxlength="30"  title="Remove any extra spaces"
 placeholder="e.g Pius"  pattern="[A-Za-z]{1,25}" /></td>
</tr>
<tr>
<td><label for="email" class='label'>Email:<span class="required"> *</span></label></td>
<td><input type="email" name="email" id="email" maxlength="50" value="<?php echo $email; ?>" required="required"  title="email should be your UMU student email address(e.g. john.masereka@stud.umu.ac.ug)" placeholder="e.g. john.masereka@stud.umu.ac.ug"/></td>
</tr>
<tr>
<td colspan="2"><span class='warning'>Double check your names and email before you click submit. NB: 'Other Name' is optional<br/>
If you do not remember your student email address, simply put your firstname.surname@stud.umu.ac.ug</span></td>
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


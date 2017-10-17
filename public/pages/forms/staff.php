<div>
<table class="form_table">
<form name="form1" autocomplete="off" 
action="index.php?c=staff&staff_id=<?php echo urlencode(base64_encode($staff_id));?>&user_id=<?php echo urlencode(base64_encode($user_id));?>" method="post">
<!--<input type="hidden" name="staff_id" id="staff_id" value="<?php echo urlencode(base64_encode($staff_id));?>" />
<input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id;?>" />-->
<tr>
    <td><label for="title_search" class="label">Title:</label></td>
    <td>
    <input type="hidden" name="title" id="title_" value="<?php echo $title;?>" />
    <input type="search" name="title_search" id="title_search" value="<?php echo $title_search;?>"/>
    </td>
</tr>
<tr>
    <td><label for="staff" class="label">Staff:</label></td>
    <td>
    <input type="text" name="staff" id="staff" value="<?php echo $user->full_name();?>" required="required" disabled="disabled"/>
    </td>
</tr>

<!--
<tr>
    <td><label for="staff_no" class="label">Staff No.</label></td>
    <td><input type="search" name="staff_no" id="staff_no" value="<?php echo $staff_no;?>" required="required" /></td>
</tr>-->
<tr>
    <td><label for="department_search" class="label">Department:</label></td>
    <td>
    <input type="hidden" name="department" id="department" value="<?php echo $department;?>" required="required" />
    <input type="search" name="department_search" id="department_search" value="<?php echo $department_search;?>" required="required"/>
    </td>
</tr>
<tr>
    <td><label for="position_search" class="label">Position:</label></td>
    <td>
    <input type="hidden" name="position" id="position" value="<?php echo $position;?>" required="required" />
    <input type="search" name="position_search" id="position_search" value="<?php echo $position_search;?>"required="required"/>
    </td>
</tr>
<!--<tr>
    <td><label for="bio" class="label">Bio:</label></td>
    <td><textarea name="bio"><?php echo $bio; ?></textarea></td>
    </tr>
<tr>-->
    <td></td>
    <td><input class="button submit" type="submit" name="submit_staff" id="add_user" value="Submit" />   </td>
    
</tr>
<tr>
    <td><a href="index.php?p=staff&user_id=<?php echo urlencode(base64_encode($user_id));?>&edit=true"><!--Clear--></a></td>
    <td><a href="index.php?p=staff&user_id=<?php echo urlencode(base64_encode($user_id));?>">Cancel</a></td>
    
</tr>

</form>
</table>
</div>

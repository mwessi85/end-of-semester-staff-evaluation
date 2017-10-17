<table class="form_table">
        <form autocomplete="off" action="index.php?c=phone&p=staff&user_id=<?php echo urlencode(base64_encode($user_id));?>&phone_id=<?php echo  urlencode(base64_encode($phone_id));?>" method="post">
        <!--<input type="hidden" name="phone_id" id="phone_id" value="<?php echo $phone_id;?>"/>-->
       <!-- <input type="text" name="user_id" id="user_id" value="<?php echo urlencode(base64_encode($user_id));?>"/>-->
        <tr>
            <td><label for="country_code">Country Code:</label></td>
            <td><input type="search" maxlength="3" name="country_code" id="country_code" value="<?php echo $country_code;?>" required="required" /></td>
        </tr>
		<tr>
            <td><label for="number">Phone number</label></td>
            <td><input type="text" maxlength="10" name="number" id="number" value="<?php echo $number;?>" required="required" /></td>
        </tr>
       <tr>
		 	<td></td>
            <td><input class="button submit" type="submit" name="submit_phone" id="add_phone" value="Submit" />
            <td><a href="index.php?c=phone&p=staff&user_id=<?php echo urlencode(base64_encode($user_id));?>">Cancel</a></td>
        </tr>
		</form>
        </table>
        
        


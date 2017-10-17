<div>
    <table class="form_table">
	<form autocomplete="off" action="index.php?c=question&question_id=<?php echo urlencode(base64_encode($question_id)); ?>" method="post">
	<tr>
	<td><label for="question" class="label">Question:</label></td>
    <td><input style="width:500px;" type="search" name="question" id="question" value="<?php echo $question; ?>" required />
    </td>
	</tr>
	<!--<tr>
    <td><label for="question_category_search" class="label">Category:</label></td>
    <td><input type="search" name="question_category_search" id="question_category_search" placeholder="<?php echo $question_category_search; ?>" /></td>
	<input type="hidden" name="question_category" id="question_category" value="<?php echo $question_category; ?>" />
    </tr>
    <tr>-->
    <td><label for="question_category" class="label">Question category:</label></td>
    <td>
    <select name="question_category">
    <option value="" <?php echo ($question_category == "") ? "selected='selected'" : ""; ?> disabled="disabled">Choose question category</option>
    <?php

		$question_category_objects = Question_category::find_all();
		foreach($question_category_objects as $question_category_object){?>
				<option value="<?php echo $question_category_object->id?>" 
				<?php echo ($question_category == $question_category_object->id) ? "selected='selected'" : ""; ?>
				><?php echo $question_category_object->name?></option>
		<?php }

	?>
    </select>
    </tr>
    <tr>
    <td><label for="status" class="label">Status:</label></td>
    <td><input type="radio" name="status" value="active" 
        <?php 
        if($status == "active"){
                echo " checked ";
        }
        ?>/> Active
        </td>
         <td><input type="radio" name="status" value="inactive" 
        <?php 
        if($status == "inactive"){
                echo " checked ";
        }
        ?>/> Inactive
        </td>
    </tr>
    
    <!--<tr>
    <td><label for="status">Status:</label></td>
    <td>
    <select name="status">
    <option value="" <?php echo ($status == "") ? "selected='selected'" : ""; ?> disabled="disabled">Choose status</option>
    <option value="Active" <?php echo ($status == "Active") ? "selected='selected'" : ""; ?>>Active</option>
    <option value="Inactive" <?php echo ($status == "Inactive") ? "selected='selected'" : ""; ?>>Inactive</option>
    </select>
    </tr>-->
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
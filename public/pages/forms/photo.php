<div>    
<form action="index.php?c=photo&user_id=<?php echo urlencode(base64_encode($user_id));?>" enctype="multipart/form-data" method="post">
<fieldset>
        <legend>Upload</legend>
<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size;?>" />
<!--<input type="hidden" name="user_id" value="<?php echo urlencode(base64_encode($user_id));?>" />-->
<p><input type="file" name="file_upload"/></p>
<input type="submit" name="submit" value="Upload"/>
</form>
</fieldset>
</div>
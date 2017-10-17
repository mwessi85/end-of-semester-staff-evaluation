
    <img src="
	<?php 
	if(isset($photo->id)){
		echo RESOURCE_PATH.$photo->image_path();
	}else{
		echo "uploads/change_photo.jpg";
			
	}
	?>
    " width="200" />
    <?php //echo USER_IMG_DIR;?>
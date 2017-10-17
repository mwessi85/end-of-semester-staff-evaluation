<div style="border:0px solid #666; clear:both;">
<?php 
if($staff = Staff::find_by_user_id($department->head)) :;
	$title_object = Title::find_by_id($staff->title);
	if($title_object){
		$staff_title = $title_object->title.". ";
	}else{
		$staff_title = "";	
	}
	$position_object = Position::find_by_id($staff->position);
	if($position_object){
		$staff_position = $position_object->title;
	}else{
		$staff_position = "";	
	}

	$staff_department = Department::find_by_id($staff->department);
	$user = User::find_by_id($department->head);
?>    
   <!-- <div style="margin-top:2em; border: 0px solid #666; clear:both; ">
        <div style="width: 250px; float: left; margin-right: 5%; clear:both;">
            
			<?php 
			$photo = Photograph::find_by_user_id($department->head);	
			require_once("photo.php"); 
			?><br />
            
        </div>
    </div>-->
    
    <table>
	<tr>
	<tr>
    	<!--<td><strong>Message from the <?php echo $staff_position;?>, <a href="index.php?c=staff&p=staff&user_id=<?php echo urlencode(base64_encode($department->head));?>"><?php echo $staff_title.$user->full_name(); ?></a></strong></td>-->
        
        
        <!--<td><strong><?php echo $staff_position;?>, <a href="index.php?c=staff&p=staff&user_id=<?php echo urlencode(base64_encode($department->head));?>"><?php echo $staff_title.$user->full_name(); ?></a></strong></td>-->
        <td></td>
    </tr>
    <tr>
    	
        <!--<td colspan="2"><p><?php echo $department->head_message;?></p></td>-->
        <td colspan="2"><p><?php echo $department->about;?></p></td>
    </tr>
	</table>
<?php endif?>
</div>


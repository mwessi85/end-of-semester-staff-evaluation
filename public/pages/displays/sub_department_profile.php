<div style="border:0px solid #666; clear:both;">
<?php 
if($staff = Staff::find_by_user_id($sub_department->head)) :;
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

	/*$department = Department::find_by_id($sub_department->department);*/
	$user = User::find_by_id($sub_department->head);
?>    
    <!--<div style="margin-top:2em; border: 0px solid #666; clear:both; ">
        <div style="width: 150px; float: left; margin-right: 5%; clear:both;">
            <?php 
			$photo = Photograph::find_by_user_id($sub_department->head);	
			require_once("photo.php"); 
			?>
        </div>
    </div>-->
    
    <table>
	<tr>
	<!--<tr>
    	<td><strong>Head of Department, <a href="index.php?c=staff&p=staff&user_id=<?php echo urlencode(base64_encode($sub_department->head));?>"><?php echo $staff_title.$user->full_name(); ?></a></strong></td>
        <td></td> 
    </tr>-->
    <tr>
    	
        <td colspan="2"><p><?php echo $sub_department->about;?></p></td>
    </tr>
	</table>
<?php endif?>
</div>


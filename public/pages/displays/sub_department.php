<div style="border:0px solid #666; clear:both;">
<?php 
if(Input::get('sub_department_id')){
	$sub_department_id = urldecode(base64_decode(Input::get('sub_department_id')));	
}

if($sub_department = Sub_department::find_by_id($sub_department_id)) :;

?>    

<?php endif?>

</div>


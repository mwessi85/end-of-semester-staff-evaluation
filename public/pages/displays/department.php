<div style="border:0px solid #666; clear:both;">
<?php 
if(Input::get('department_id')){
	$department_id = urldecode(base64_decode(Input::get('department_id')));	
}

if($department = Department::find_by_id($department_id)) :;

?>    

<?php endif?>

</div>


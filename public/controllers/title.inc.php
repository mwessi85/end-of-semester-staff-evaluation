<?php 
if(Input::get('title_id')){		
	$title_id = urldecode(base64_decode(Input::get('title_id')));
	if($title_id > 0){
		$title_object = Title::find_by_id($title_id);
		$fields = array("title");
		foreach ($fields as $field){
			$$field = $title_object->$field;
		}
	}
}else{
	$title_id = 0;
	$inputs = array("title");
	foreach ($inputs as $input){
		$$input = Input::get($input);
	}
}
if(Input::get('submit')){
	$title = ucfirst(Input::get('title'));
	if($title_id==0){
		$title_object = new Title();
	}
	$title_object->title = titleCase(Input::get('title'));
	if(!empty($title_object->title)){
		$action = $title_object->save();
		if(is_numeric($action)){
			$session->message("success: Title was added successfully");
		}else{
			$session->message("success: Title edit was successfull");
		}
		redirect_to("index.php?c=title&p=title");
	}
}else{	

}
?>
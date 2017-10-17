<?php 
if(Input::get('position_id')){	
	$position_id = urldecode(base64_decode(Input::get('position_id')));
	if($position_id > 0){
		$position = Position::find_by_id($position_id);
		$fields = array("title", "category");
		foreach ($fields as $field){
			$$field = $position->$field;
		}
	}
}else{
	$position_id = 0;
	$inputs = array("title", "category");
	foreach ($inputs as $input){
		$$input = Input::get($input);
	}
}
if(Input::get('submit')){
	$title = strtolower(Input::get('title'));
	if($position_id==0){
		$position = new Position();
	}
	$position->title = titleCase(Input::get('title'));
	$position->category = Input::get('category');
	if(Input::get('category') == ""){
		$session->message("error: No staff category was specified");
		redirect_to("index.php?p=position");
	}
	//echo "<p>".print_r($position, true)."</p>";
	if(!empty($position->title) && !empty($position->category)){
		$action = $position->save();
		if(is_numeric($action)){
			$session->message("success: Position was added successfully");
			$position->id = $action;
		}else{
			$session->message("success: Position edit was successfull");
		}
		redirect_to("index.php?c=position&p=position&id=".$position->id);
	}	
}else{	

}
?>
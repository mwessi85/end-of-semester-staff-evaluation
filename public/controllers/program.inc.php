<?php 
if(Input::get('program_id')){	
	$program_id = urldecode(base64_decode(Input::get('program_id')));
	if($program_id > 0){
		$program = Program::find_by_id($program_id);
		$fields = array("name", "code");
		foreach ($fields as $field){
			$$field = $program->$field;
		}
	}
}else{
	$program_id = 0;
	$inputs = array("name", "code");
	foreach ($inputs as $input){
		$$input = Input::get($input);
	}
}
if(Input::get('submit')){
	$name = strtolower(Input::get('name'));
	if($program_id==0){
		$program = new Program();
	}
	$program->name = titleCase(Input::get('name'));
	$program->code = strtoupper(Input::get('code'));
	if(Input::get('code') == ""){
		$session->message("error: No staff code was specified");
		redirect_to("index.php?p=program");
	}
	//echo "<p>".print_r($program, true)."</p>";
	if(!empty($program->name) && !empty($program->code)){
		$action = $program->save();
		if(is_numeric($action)){
			$session->message("success: Program was added successfully");
			$program_id;
		}else{
			$session->message("success: Program edit was successfull");
		}
		redirect_to("index.php?c=program&p=program&id=".$program->id);
	}	
}else{	

}
?>
<?php 
if(Input::get('question_category_id')){		
	$question_category_id = urldecode(base64_decode(Input::get('question_category_id')));
	//echo $question_category_id;
	//exit;
	if($question_category_id > 0){
		$question_category_object = Question_category::find_by_id($question_category_id);
		$fields = array("name");
		foreach ($fields as $field){
			$$field = $question_category_object->$field;
		}
		
	}
}else{
	$question_category_id = 0;
	$inputs = array("name");
	foreach ($inputs as $input){
		$$input = Input::get($input);
	}
}
if(Input::get('submit')){
	$name = ucfirst(Input::get('name'));
	if($question_category_id==0){
		$question_category_object = new Question_category();
	}
	$question_category_object->name = titleCase(Input::get('name'));
	if(!empty($question_category_object->name)){
		$action = $question_category_object->save();
		if(is_numeric($action)){
			$session->message("success: Question_category was added successfully");
		}else{
			$session->message("success: Question_category edit was successfull");
		}
		redirect_to("index.php?c=question_category&p=question_category");
	}
}else{	

}
?>
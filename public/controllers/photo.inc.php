<?php 
if(Input::get('user_id')){
	$user_id = urldecode(base64_decode(Input::get('user_id')));
}

$max_file_size = 10485760;
$photo = Photograph::find_by_user_id($user_id);	

if(Input::get('submit')){
	if(!$photo){
		$photo = new Photograph();	
		$photo->user_id = $user_id;
	}
	
	$photo->attach_file($_FILES['file_upload']);
	//echo "<pre>".print_r($photo, true)."</pre>";
	//echo $user_id;
//echo "<p>index.php?c=staff&p=staff&user_id=".urlencode(base64_encode($user_id))."</p>";
//exit;
	if($photo->save()){	
	}
}
$session->message("success: The photograph was successfully uploaded");
//echo $user_id;
//echo "<p>index.php?c=staff&p=staff&user_id=".urlencode(base64_encode($user_id))."</p>";
//exit;
redirect_to("index.php?c=staff&p=staff&user_id=".urlencode(base64_encode($user_id)));
?>
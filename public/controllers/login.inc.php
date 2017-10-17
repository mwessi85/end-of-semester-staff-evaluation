<?php
	//exit;
	if(Input::get('submit')){		
		$found_user = User::authenticate(Input::get('username'), Input::get('password'));
		if($found_user){
			$session->login($found_user);
			log_action("Login", $found_user->username." Logged in.");
			$session->message("success: Welcome ".$found_user->full_name().", you have successfully logged in");
			redirect_to("index.php?p=default");
		}else{
			$session->message("error: Username and password combination incorrect");
			redirect_to("index.php?p=login");
		}
	}
	
	//exit;
	if(Input::get('username_check')){		
		
		$sql = "SELECT * FROM students WHERE student_no = '".Input::get('student_no')."'";
		//echo $sql;
		
		$result = $database->query($sql);
		$row = $result->fetch();
		if(!empty($row)){
			$user = User::find_by_id($row['user_id']);
			//echo $user->username;
			//exit;
			$session->message("success: Your username is ".$user->username);
			redirect_to("index.php?p=login");
		}else{
			$session->message("error: Student No. not found... if you have not yet registered, please register or talk to a quality assurance adminstrator for further assistance");
			redirect_to("index.php?p=login");	
		}
	}
?>

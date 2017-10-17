<?php 
	if(Input::get('user_id')){
		$user_id = urldecode(base64_decode(Input::get('user_id')));
		if($student = Student::find_by_user_id($user_id)){
			if(Input::get('delete')){
				$result = Question_answer::delete_all_where("respondent_id", $user_id);
				$result = Student_course_unit::delete_all_where("user_id", $user_id);
				$result = Student::delete_all_where("user_id", $user_id);
				$user = User::find_by_id($user_id);
				$session->message("success: student ".$user->full_name()." has been deleted successfully!");
				redirect_to("index.php?p=students");
			}
			$student->student_no = str_replace("/", "-", $student->student_no);
			$stud_no = explode('-', $student->student_no);
			$branch = substr($stud_no[2],0,1);
			//echo $branch;
			$branches = Branch::getBranches();
			$branch = ucfirst($branches[$branch]);		
			$student_id = $student->id;	
			$sql = "SELECT * FROM student_course_units WHERE user_id = '".$user_id."'";
			$result = $database->query($sql);
			$row = $result->fetchColumn();
			$sql = "SELECT * FROM students WHERE user_id = '".$user_id."'";
			$result = $database->query($sql);
			$row_1 = $result->fetch();
			//echo "<pre>".print_r($row_1, true)."</pre>";
			//exit;
			if(!empty($row_1)){
				$course_unit_complete = $row_1['course_unit_complete'];	
			}
			if(!empty($row) && $session->session_no != Session::session_no(1)){
				$readonly = "readonly";	
				if(Input::get("year")){
					if(Input::get("year") != $student->year){
						$session->message("error: You need to first delete your existing course units before you can change the 'Year of Study'. If you have already evelauted a course unit, ask your administrator for assistance in changing your 'Year of Study'");
						redirect_to("index.php?c=student&p=student&user_id=".urlencode(base64_encode($user_id)));
					}	
				}
			}else{
				 $readonly = "";
				 $warning_message = "Note: Please make sure that your details (Course, Year of Study & Student No.) are correct before you begin entering your course units. After you have entered your course units, you will only be able to edit 'Total Lecturers' when you click on 'Edit: Student Details'. ";
						//redirect_to("index.php?c=student&p=student&user_id=".urlencode(base64_encode($user_id)));
				//exit;
			}
		}else{
			
			if(Input::get('c_delete')){
				//exit;
				$user = User::find_by_id($user_id);
				//echo "<pre>".print_r($user, true)."</pre>";
				if($user->user_type == "student"){
					
					$users_name = $user->full_name();
					$result = Question_answer::delete_all_where("respondent_id", $user_id);
					$result = Student_course_unit::delete_all_where("user_id", $user_id);
					$result = Student::delete_all_where("user_id", $user_id);
					$result = User::delete_all_where("id", $user_id);	
					$session->message("success: student ".$users_name." has been deleted successfully!");
					redirect_to("index.php?p=students");
				}
			}
			//echo "Did not work";
			//exit;
			
			$_GET['add'] = true;
			$inputs = array("student_no", "course", "course_search", "program", "program_search", "year", "course_unit_no");
			foreach ($inputs as $input){
				$$input = "";
			}
			$course_unit_complete = 0;		
		}
	}else{
		$session->message("error: No user was specified");
		redirect_to("index.php?p=user");	
	}
	
	if(Input::get('student_id')){
		//echo "Student Id provided".urldecode(base64_decode(Input::get('student_id')));
		$student_id = urldecode(base64_decode(Input::get('student_id')));
		if($student_id > 0){
			$student = Student::find_by_id($student_id);
			$fields = array("user_id", "student_no", "course", "program", "year", "course_unit_no");
			foreach ($fields as $field){
				$$field = trim($student->$field);
			}
			$previous_year = $year;
			$course_program = $student->program;
			if(!empty($course_program )){
				$program_object = Program::find_by_id($course_program);
				$program_search = $program_object->name;
				
			}
			
			$course_object = Course::find_by_id($course);
			if($course_object){
				$course_search = $course_object->name;
			}else{
				$course_search = "";
			}
		}elseif($student_id == 0){
			$inputs = array("student_no", "course", "course_search", "program", "program_search", "year", "course_unit_no");
			foreach ($inputs as $input){
				$$input = "";
			}	
		}
	}else{
		$student_id = 0;
		$user_id = urldecode(base64_decode(Input::get('user_id')));
		if($student = Student::find_by_user_id($user_id)){
			$student_id = $student->id;	
		}else{
			$_GET['add'] = true;
		}
	}	
	
	
	if(Input::get('submit')){
		if(!(Input::get('user_id'))){
			$message = "error: Noooo user specified";
			redirect_to("index.php?p=user");	
		}
		$inputs = array("student_no", "course", "course_search", "program", "program_search", "year", "course_unit_no");
		$i = 0;
		foreach ($inputs as $input){
			$$input = Input::get($input);
		}
		//if($){
				
		//}
		$student_no = str_replace("/", "-", $student_no);
		$student_no = strtoupper($student_no);
		
		if($student_id==0){
			$student = new Student();
			$sql = "SELECT * FROM students WHERE student_no = '".$student_no."'";
			
			$query = Student::query_object($sql);
			$row = $query->fetch();
			//echo "<pre>".print_r($row, true)."</pre>";
			if(!empty($row)){
				$user = User::find_by_id($row['user_id']);
				//echo "error: The Student No. (".$student_no.") already exists for student ".$user->full_name()." Try logging in using the username ".$user->username;
				//exit;
				$session->message("error: The Student No. (".$student_no.") already exists for student ".$user->full_name()." Try logging in using the username ".$user->username);
				$session->logout();
				redirect_to("index.php?p=login");
			}
			
			//exit;
		}
		$attributes  = array("user_id", "student_no","course", "program", "year", "course_unit_no");
		foreach ($attributes as $attribute){
			$student->$attribute = trim($$attribute);
		}
		
		if(empty($student->course)){
			$session->message("error: The course you entered does not exist, please type the course name & select it from the auto-suggest options that appear as you type");
			if($student_id){
				redirect_to("index.php?p=student&c=student&student_id=".urlencode(base64_encode($student_id))."&user_id=".urlencode(base64_encode($user_id))."&edit=true");
			}
			redirect_to("index.php?c=student&p=student&user_id=".urlencode(base64_encode($user_id)));
		}else{
		$course_object = Course::find_by_id($course);
			if($course_object){
				//echo "<p>".$course_object->name."</p>";
				//echo "<p>".$course_search."</p>";
				//exit;
				if(trim($course_object->name) != trim($course_search)){
					//echo "No match! ".$user_id;
					//exit;
					$session->message("error: The course you entered does not exist, please type the course name & select it from the auto-suggest options that appear as you type");
			if(isset($student_id)){
				redirect_to("index.php?p=student&c=student&student_id=".urlencode(base64_encode($student_id))."&user_id=".urlencode(base64_encode($user_id))."&edit=true");
			}
			redirect_to("index.php?c=student&p=student&user_id=".urlencode(base64_encode($user_id)));	
				}
			}
		}
		
		if(empty($student->program)){
			$session->message("error: The program you entered does not exist, please type the program name & select it from the auto-suggest options that appear as you type");
			if($student_id){
				redirect_to("index.php?p=student&c=student&student_id=".urlencode(base64_encode($student_id))."&user_id=".urlencode(base64_encode($user_id))."&edit=true");
			}
			redirect_to("index.php?c=student&p=student&user_id=".urlencode(base64_encode($user_id)));
		}else{
		$program_object = Program::find_by_id($program);
			//echo "<pre>".print_r($student, true)."</pre>";
			//echo "Search: ".$program_search;
	//exit;
			if($program_object){
				if($program_object->name != $program_search){
					//echo "No match! ".$user_id;
					//exit;
					$session->message("error: The program you entered does not exist, please type the program name & select it from the auto-suggest options that appear as you type");
			if(isset($student_id)){
				redirect_to("index.php?p=student&c=student&student_id=".urlencode(base64_encode($student_id))."&user_id=".urlencode(base64_encode($user_id))."&edit=true");
			}
			redirect_to("index.php?c=student&p=student&user_id=".urlencode(base64_encode($user_id)));	
				}
			}
		}
		if(empty($student->year)){
			$session->message("error: Year of study was not specified!");
			redirect_to("index.php?c=student&p=student&user_id=".urlencode(base64_encode($user_id)));	
		}
		
		
		//echo "<pre>".print_r($student, true)."</pre>";
		//exit;
		if(!empty($student->student_no) && !empty($student->course) && !empty($student->program) && !empty($student->year)){
			if(isset($student_id)){
				$sql = "SELECT * FROM students WHERE student_no = '".$student_no."'";
				$query = Student::query_object($sql);
				$row = $query->fetch();
				if($row['course'] != $student->course){
					$query = "DELETE FROM student_course_units WHERE user_id = ".$user_id;
					$result = $database->query($query);
					$query = "DELETE FROM question_answers WHERE respondent_id = ".$user_id;
					$result = $database->query($query);		
				}
			}
			//echo "<pre>".print_r($student, true)."</pre>";
			//exit;
			//$student->$course_unit_complete = $course_unit_complete;
			//
			//echo $course_unit_complete."<br>";
			$student->course_unit_complete = $course_unit_complete;
			
			//echo "<pre>".print_r($student, true)."</pre>";
			if($student->course_unit_complete >= $student->course_unit_no){
				$student->course_unit_no = $student->course_unit_complete;
			}

			//echo "<pre>".print_r($student, true)."</pre>";
			//exit;
			
			$action = $student->save();
			if(is_numeric($action)){
				//echo "<pre>".print_r($student, true)."</pre>";
				//exit;
				$user = User::find_by_id($student->user_id);
				$session->message("success: login with the username ".$user->username);
				$session->logout();
				redirect_to("index.php?p=login&username=".$user->username);
				//include("logout.inc.php");
				
			}else{
				//echo "<pre>".print_r($student, true)."</pre>";
			//exit;
				$session->message("success: Student edit successfull");
			}
			redirect_to("index.php?c=student&p=student&user_id=".urlencode(base64_encode($student->user_id)));
		}
		$session->message("error: Student edit successfull");
		redirect_to("index.php?c=student&p=student&user_id=".urlencode(base64_encode($student->user_id)));
		//exit;
	}
	$photo = Photograph::find_by_user_id($user_id);	
	//echo $student_no;
?>
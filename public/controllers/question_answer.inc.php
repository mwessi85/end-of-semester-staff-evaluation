<?php include("course_course_unit.inc.php");
if(Input::get('course_course_unit_id')){
	//echo "<p>".$course_course_unit->lecturer."</p>";
	$lecturer_id = $course_course_unit->lecturer;
	if($staff = Staff::find_by_user_id($course_course_unit->lecturer)){;
		$title_object = Title::find_by_id($staff->title);
		if($title_object){
			$staff_title = $title_object->title.". ";
		}else{
			$staff_title = "";	
		}
		$lecturer_name = $staff_title.$user->full_name();
	}
	
	if(!empty($course_object->sub_department)){
		$sub_department_object = Sub_department::find_by_id($course_object->sub_department);
		$sub_department = $sub_department_object->name;
		$sub_department_id = $sub_department_object->id;
	}else{
		$sub_department = "";
		if(!empty($course_object->department)){
			$department_object = Department::find_by_id($course_object->department);
			$sub_department = $department_object->name;	
			$sub_department_id = "";	
		}
	}
	
	if(!empty($course_object->department)){
		$department_object = Department::find_by_id($course_object->department);
		$department = $department_object->name;	
		$department_id = $department_object->id;	
	}else{
		$sub_department_object = Sub_department::find_by_id($course_object->sub_department);
		$department_object = Department::find_by_id($sub_department_object->department);
		$department = $department_object->name;	
		$department_id = $department_object->id;		
	}
	//$today = date("d-M-Y");
	$today = date("Y-m-d h:i:s A");
}
?>
<?php 
if(Input::get('submit')){
	foreach ($_POST as $key => $value) {
		if($key=='submit'){
			continue;	
		}
		$question_answer = new Question_answer();	
		if($key=='comment' || $key=='suggestion'){
			if($key=='comment'){
				$question_answer->question = "comment";
				$question_answer->question_id = 0;
			}
			if($key=='suggestion'){
				$question_answer->question = "suggestion";
				$question_answer->question_id = 0;
			}
			$question_answer->question_category_id = 6;
			$question_category = Question_category::find_by_id($question_answer->question_category_id);
			$question_answer->question_category = $question_category->name;
			$question_answer->answer = $value;
			$question_answer->answer_id = 0;
			
			//continue;
			
		}else{
			$question = Question::find_by_id($key);
			$question_answer->question = $question->question;
			$question_answer->question_id = $question->id;
			$question_answer->question_category_id = $question->category;
			$question_category = Question_category::find_by_id($question_answer->question_category_id);
			$question_answer->question_category = $question_category->name;
			$question_answer->answer = grade_interpreter($value);
			$question_answer->answer_id = $value;	
		}
		$question_answer->academic_unit = $department;
		$question_answer->academic_unit_id = $department_id;
		$question_answer->department = $sub_department;
		$question_answer->department_id = $sub_department_id;
		$question_answer->course_course_unit_id = $course_course_unit->id;
		$question_answer->course = $course_search;
		$question_answer->course_id = $course_id;
		
		
		
		$question_answer->course_unit = $course_unit_search;
		$question_answer->course_unit_id = $course_unit_id;
		$question_answer->year = $year;
		$question_answer->semester = $semester;
		$question_answer->lecturer = $lecturer_name;
		$question_answer->lecturer_id = $lecturer_id;
		$question_answer->respondent_id = $session->user_id;
		$respondent = User::find_by_id($session->user_id);
		$question_answer->respondent = $respondent->full_name();
		$student = Student::find_by_user_id($question_answer->respondent_id);
		
		$student->student_no = str_replace("/", "-", $student->student_no);
		//$stud_no = explode('-', $student->student_no);
		
		$student_no = explode('-', $student->student_no);
		//echo $student_no;
		
		
		$branch = substr($student_no[2],0,1);
		$question_answer->branch = $branch;
		//echo "<pre>".print_r($question_answer->branch , true)."</pre>";
		//exit;
		
		$program_id = $student->program;
		$year_of_study = $student->year;
		$program = $student->student_program();
		$question_answer->program = $program;
		$question_answer->program_id = $program_id;
		$question_answer->year_of_study = $year_of_study;
		//echo grade_interpreter($question_answer->answer)."<br>";
		//$question_answer->date = date("Y-m-d H:i:s", strtotime($today));
		//$question_answer->date = date(strtotime($today));
		$question_answer->date = mysql_datetime(strtotime(date("Y-m-d h:i:s")));
		//echo "<pre>".print_r($question_answer, true)."</pre>";
		//exit;	
		//exit;
		if(empty($question_answer->respondent_id)){
			$session->message("error: Login to access this page");
			if($student_id){
				redirect_to("index.php?logout=true");
			}
			redirect_to("index.php?c=student&p=student&user_id=".urlencode(base64_encode($user_id)));
		}
		$action = $question_answer->save();
		if(is_numeric($action)){
			//$affected = Question_answer::update_complete($question_answer->respondent_id);
			$session->message("success: Evaluation successful");
		}else{
			$session->message("error:Evaluation failed");
		}
    }
	if(is_numeric($action)){
		$affected = Question_answer::update_complete($question_answer->respondent_id);
		$session->message("success: Evaluation successful ".(!empty($affected)) ? "(".$affected.")" : "");
	}
	//$session->message("success: Evaluation successful");	
	//redirect_to("index.php?c=course&p=course&course_id=".urlencode(base64_encode($question_answer->course_id)));
	redirect_to("index.php?c=student&p=student&user_id=".urlencode(base64_encode($question_answer->respondent_id)));

}
?>
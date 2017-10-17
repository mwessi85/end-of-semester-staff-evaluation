<?php
	require_once(SITE_ROOT.DS."initialize.php");
	function strip_zeros_from_date($marked_string=""){
		$no_zeros = str_replace('*0', '', $marked_string);
		$cleaned_string = str_replace('*', '', $no_zeros);
		return $cleaned_string; 
	}
	function mysql_datetime($timestamp){
		$mysql_datetime = strftime("%Y-%m-%d %H:%M:%S", $timestamp);
		return $mysql_datetime; 
	}
	function redirect_to($location = NULL){
		if($location != NULL){
			header("Location: ".$location);
			exit;
		}
	}
	function output_message($message){
		if(!empty($message)){
			$message = explode(":", $message);
			if($message[0] == "error"){
				return "<span class='error'>".trim($message[1])."</span>";	
			}
			if($message[0] == "warning"){
				return "<span class='warning'>".trim($message[1])."</span>";	
			}
			if($message[0] == "message"){
				return "<span class='message'>".trim($message[1])."</span>";	
			}
			if($message[0] == "success"){
				return "<span class='success'>".trim($message[1])."</span>";	
			}
		}
		else{
			return "";	
		}
	}
	function __autoload($class_name){
		$class_name = strtolower($class_name);
		$path = LIB_PATH.DS.$class_name.".php";
		if(file_exists($path)){
			require_once($path);
		}else{
			die("The file ".$class_name.".php could not be found");	
		}
	}
	//function include_layout_template($template_name = ""){
	//	require_once(STYLE_PATH.DS.$template_name.".php");	
	//}
	function log_action($action, $message = ""){
		$logfile = "../logs/log.txt";
		$new = file_exists($logfile) ? false : true;
		if($handle = fopen($logfile, "a")){
			$timestamp = strftime("%Y-%m-%d %H:%M:%S", time());	
			$content = $timestamp." | ".$action." : ".$message."\r\n";
			fwrite($handle, $content);
			fclose($handle);
			if($new){
				chmod($logfile, 0755);	
			}
		}else{
			echo "Could not open log file for writing!";
			exit;	
		}
	}
	function return_student_course($user_id){
		$student_ob = Student::find_by_user_id($user_id);
		return !empty($student_ob) ? $student_ob->course : false;
		//return $student_ob->course;	
	}
	function logout($logout="false"){
	global $session;
		if($logout == true){
			$session->logout();
		}	
	}
	function show_logout($id){
		global $sesson;
		$user = User::find_by_id($id);
		//echo "<pre>".print_r($user, true)."</pre>";
		if(isset($user->first_name) && isset($user->last_name)){
			if($user->user_type == "staff"){
				echo  "Staff: <a href='index.php?c=staff&p=staff&user_id=".urlencode(base64_encode($user->id))."'>".$user->full_name()."</a>&nbsp;|&nbsp;(<a href='index.php?logout=true'>Logout</a>)";	
			}else{
				
				//echo $student_ob->course;
				
				echo  "Student: <a href='index.php?c=student&p=student&user_id=".urlencode(base64_encode($user->id))."'>".$user->full_name()."</a> | (<a href='index.php?logout=true'>Logout</a>)";	
			}
			
		}	
	}
	function datatime_to_text($datetime=""){
		$unixdatetime = strtotime($datetime);
		return strftime("%B %d, %Y at %I:%M %p", $unixdatetime);
	}
	function display_date($datetime=""){
		$unixdatetime = strtotime($datetime);
		return strftime("%Y %b %d", $unixdatetime);
	}
	
	function custom_echo($x, $length){
	  if(strlen($x)<=$length)
	  {
		echo $x;
	  }
	  else
	  {
		$y=substr($x,0,$length) . '...';
		echo $y;
	  }
	}
	
	function bottom_pagination($location){
		global $pagination;
		global $page;
		
		if($pagination->total_pages() > 1){
			if($pagination->has_previous_page()){
				echo "<a href='".$location."&page=".$prev = $pagination->previous_page()."'> &laquo; Prev </a>";
			}
			for($i=1; $i<=$pagination->total_pages(); $i++){
				if($i == $page){
					echo "<strong>&nbsp; ".$i." &nbsp;</strong>";
				}else{
					echo "<a href='".$location."&page=".$i."'>&nbsp; ".$i." &nbsp;</a>";
				}
			}
			if($pagination->has_next_page()){
				echo "<a href='".$location."&page=".$pagination->next_page()."'> Next &raquo; </a>";
			}
		}	
	}
	function bottom_pagination_staff($location){
		global $pagination;
		global $page;
		global $staff_id;
		if($pagination->total_pages() > 1){
			if($pagination->has_previous_page()){
				echo "<a href='".$location.".php?page=".$prev = $pagination->previous_page()."&staff_id=".$staff_id."'> &laquo; Prev </a>";
			}
			for($i=1; $i<=$pagination->total_pages(); $i++){
				if($i == $page){
					echo "<strong>&nbsp; ".$i." &nbsp;</strong>";
				}else{
					echo "<a href='".$location.".php?page=".$i."&staff_id=".$staff_id."'>&nbsp; ".$i." &nbsp;</a>";
				}
			}
			if($pagination->has_next_page()){
				echo "<a href='".$location.".php?page=".$pagination->next_page()."&staff_id=".$staff_id."'> Next &raquo; </a>";
			}
		}	
	}

	function confirm_pass($password_1, $password_2){
		if($password_1 == $password_2){
			return true;
		}
		return false;	
	}	
	
	//function titleCase($string, $delimiters = array(" ", "-", ".", "'", "O'", "Mc"), $exceptions = array("and", "to", "of", "das", "dos", "I", "II", "III", "IV", "V", "VI"))
	function titleCase($string, $delimiters = array(" ", "-", ".", "O'", "Mc"), $exceptions = array("this","that","which","with","for","an","as","a","if","on", "out", "in", "and", "to", "of", "das", "dos", "I", "II", "III", "IV", "V", "VI", "IT", "VB.NET", "C#", "C++", "Mr", "Mrs", "Ms", "Fr", "Sr", "Prof"))
{
    /*
     * Exceptions in lower case are words you don't want converted
     * Exceptions all in upper case are any words you don't want converted to title case
     *   but should be converted to upper case, e.g.:
     *   king henry viii or king henry Viii should be King Henry VIII
     */
    $string = mb_convert_case($string, MB_CASE_TITLE, "UTF-8");
    foreach ($delimiters as $dlnr => $delimiter) {
        $words = explode($delimiter, $string);
        $newwords = array();
        foreach ($words as $wordnr => $word) {
            if (in_array(mb_strtoupper($word, "UTF-8"), $exceptions)) {
                // check exceptions list for any words that should be in upper case
                $word = mb_strtoupper($word, "UTF-8");
            } elseif (in_array(mb_strtolower($word, "UTF-8"), $exceptions)) {
                // check exceptions list for any words that should be in upper case
                $word = mb_strtolower($word, "UTF-8");
            } elseif (!in_array($word, $exceptions)) {
                // convert to uppercase (non-utf8 only)
                $word = ucfirst($word);
            }
            array_push($newwords, $word);
        }
        $string = join($delimiter, $newwords);
   }//foreach
   return $string;
	//$s = 'SÃO JOÃO DOS SANTOS';
	//$v = titleCase($s); // 'São João dos Santos' 
}
function action($action){
	global $user_id;
	if($_SESSION['st_user_id'] == $user_id){
		echo $action;	
	}elseif($_SESSION['st_user_id'] == 1){
		echo $action;	
	}else{
		echo "";	
	}
}

function display($page){
	return 'require_once("display/'.$page.'.php")';	
}
function form($page){
	return 'require_once("forms/'.$page.'.php")';	
}
		
function check_restriction(){
	global $session;
	global $restricted;
	if($restricted == true){
		if(!$session->is_logged_in()){
			redirect_to("index.php");
		}
	}	
}	
function user_admin_action($id){
	global $session;
	
	//echo "<pre>".print_r($session, true)."</pre>";	
	//echo Session::session_no($id);
	//echo "<p>".$id."</p>";
	//echo "<p>".$session->user_id."</p>";
	//exit;
	if($session->session_no == Session::session_no($id) || $session->session_no == Session::session_no(1)){
		return true;
	}
	else{
		$session->message("error: You are not allowed to perform this action");
		redirect_to("index.php?p=main");	
	}
	return false;
}
function admin_only($id){
	global $session;
	if($session->session_no == Session::session_no(1)){
		return true;
	}
	else{
		$session->message("error: You are not allowed to perform this action");
		redirect_to("index.php?p=main");	
	}
	return false;
}
function admin_action($action){
	global $user_id;
	if($session->session_no == Session::session_no(1)){
		return true;	
	}
}
function admin(){
	global $session;
	//echo "<pre>".print_r($session, true)."</pre>";
	if(isset($session->session_no)){
		if($session->session_no == Session::session_no(1)){
			return true;
		}
	}
	return false;	
}
function grade_interpreter($grade){
	switch($grade){
		case 1:
		return "Unsatisfactory";
		break;	
		case 2:
		return "Below average";
		break;	
		case 3:
		return "Average/Good";
		break;	
		case 4:
		return "Very Good";
		break;	
		case 5:
		return "Excellent";
		break;	
		case 6:
		return "Not applicable";
		break;	
		default:
		return "text";	
	}
}

// Export to Excel functions

function xlsBOF() {
echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
}
function xlsEOF() {
	echo pack("ss", 0x0A, 0x00);
}
function xlsWriteNumber($Row, $Col, $Value) {
	echo pack("sssss", 0x203, 14, $Row, $Col, 0x0);
	echo pack("d", $Value);
}
function xlsWriteLabel($Row, $Col, $Value) {
	$L = strlen($Value);
	echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
	echo $Value;
}

function excel_items($sql){
	global $database; 
	// prepare headers information
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");
	header("Content-Disposition: attachment; filename=\"UMU_evaluation_".YEAR."_".SEMESTER."_(".date("Y-m-d %H:%M:%S").").xls\"");
	header("Content-Transfer-Encoding: binary");
	header("Pragma: no-cache");
	header("Expires: 0");
	// start exporting
	xlsBOF();
	// first row 
	xlsWriteLabel(0, 0,"ID");
	xlsWriteLabel(0, 1,"Question");;
	xlsWriteLabel(0, 2,"Answer");
	xlsWriteLabel(0, 3,"Academic/Unit");
	xlsWriteLabel(0, 4,"Department");
	xlsWriteLabel(0, 5,"Course");
	xlsWriteLabel(0, 6,"Program");
	xlsWriteLabel(0, 7,"Year of study");
	xlsWriteLabel(0, 8,"Course Unit");
	xlsWriteLabel(0, 9,"Year");
	xlsWriteLabel(0, 10,"Semester");
	xlsWriteLabel(0, 11,"Lecturer");
	xlsWriteLabel(0, 12,"Respondent");
	xlsWriteLabel(0, 13,"Date");
	// second row 
	
	$result = $database->query($sql);
	if (isset($result)) {
		$xlsRow = 1;
		$allResults = $result->fetchAll(PDO::FETCH_ASSOC);
		if ($allResults) {
			//echo "<p>".print_r($allResults, true)."</p>";
			//exit;
			
			
			foreach ($allResults as $row) { 
				xlsWriteNumber($xlsRow, 0, $row['id']);
				xlsWriteLabel($xlsRow, 1, $row['question']);
				xlsWriteLabel($xlsRow, 2, $row['answer']);
				xlsWriteLabel($xlsRow, 3, $row['academic_unit']);
				xlsWriteLabel($xlsRow, 4, $row['department']);
				xlsWriteLabel($xlsRow, 5, $row['course']);
				xlsWriteLabel($xlsRow, 6, $row['program']);
				xlsWriteLabel($xlsRow, 7, $row['year_of_study']);
				xlsWriteLabel($xlsRow, 8, $row['course_unit']);
				xlsWriteLabel($xlsRow, 9, $row['year']);
				xlsWriteLabel($xlsRow, 10, $row['semester']);
				xlsWriteLabel($xlsRow, 11, $row['lecturer']);
				xlsWriteLabel($xlsRow, 12, $row['respondent']."(".$row['respondent_id'].")");
				$date = strtotime($row['date']);
				$date = date("j-M-Y h:i:s A", $date);
				xlsWriteLabel($xlsRow, 13, $date);
				$xlsRow++;
			}
			xlsEOF();
		}
	}
	xlsEOF();
}

function excel_staff($course_course_unit_id, $year_of_study, $branch){
	global $database; 
	// prepare headers information
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");
	header("Content-Disposition: attachment; filename=\"UMU_evaluation_".YEAR."_".SEMESTER."_(".date("Y-m-d %H:%M:%S").").xls\"");
	header("Content-Transfer-Encoding: binary");
	header("Pragma: no-cache");
	header("Expires: 0");
	// start exporting
	//xlsBOF();
	// first row 
	//$course_course_unit_id = urldecode(base64_decode(Input::get('course_course_unit_id')));
	$branches = Branch::getBranches();
	$branch_id = $branch;
	$branch = ucfirst($branches[$branch]);
	$sql = "SELECT * FROM question_answers 
	WHERE course_course_unit_id = ".$course_course_unit_id." 
	AND year_of_study = ".$year_of_study." 
	AND semester = ".SEMESTER." 
	AND year = ".YEAR."
	AND branch = ".$branch_id;
	
	$result_programs = $database->query("SELECT COUNT(program)count, program FROM question_answers 
	WHERE course_course_unit_id = ".$course_course_unit_id." 
	AND year_of_study = ".$year_of_study." 
	AND semester = ".SEMESTER." 
	AND year = ".YEAR."
	AND branch = ".$branch_id." GROUP BY program");
	$programs = "";
	$i = 0;
	while($row_programs = $result_programs->fetch(PDO::FETCH_ASSOC)){
		$programs .= $row_programs["program"]."/";
		//echo $ro
	}
	$programs.="/";
	$programs = str_replace("//", "", $programs);
	
	
	$result = $database->query($sql);
	$row = $result->fetchColumn();
	if(!empty($row)){
		$row = $result->fetch(PDO::FETCH_ASSOC);
		$program = $row['program'];
		$year_of_study = $row['year_of_study'];
		$course_course_unit = Course_course_unit::find_by_id($course_course_unit_id);
		$fields = array("course", "course_unit", "lecturer", "year", "semester", "status");
		foreach ($fields as $field){
			$$field = $course_course_unit->$field;
		}
		//$semester = SEMESTER;
		//$year = YEAR;
		$year = $year."/".($year+1);
		if(!empty($lecturer)){
			$user = User::find_by_id($lecturer);
			$user_search = $user->full_name();
			if($staff = Staff::find_by_user_id($lecturer)){;
				$title_object = Title::find_by_id($staff->title);
				if($title_object){
					$staff_title = $title_object->title.". ";
				}else{
					$staff_title = "";	
				}
				$lecturer_name = $staff_title.$user->full_name();
			}	
		}
		
		$course_id = $course;
		if(!empty($course_id)){
			$course = Course::find_by_id($course_id);
			$course_object = $course;
			$course_name = $course->name;
		}
		$course_unit_id = $course_unit;
		
		if(!empty($course_unit_id)){
			$course_unit = Course_unit::find_by_id($course_unit_id);
			$course_unit_name = $course_unit->name;
		}
		
		if($course_object){
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
		}else{
			$sub_department = "";
			$department = "";	
		}
		//$today = date("d-M-Y");
		$today = date("Y-m-d h:i:s A");
	xlsBOF();

	xlsWriteLabel(0, 0,"Uganda Martyrs University");
	xlsWriteLabel(1, 1,"Faculty:");
	xlsWriteLabel(2, 1,"Lecturer:");
	xlsWriteLabel(3, 1,"Academic Year:");
	xlsWriteLabel(4, 1,"Date:");
	xlsWriteLabel(1, 3,"Semester:");
	xlsWriteLabel(2, 3,"Class & Year:");
	xlsWriteLabel(3, 3,"Program:");
	xlsWriteLabel(4, 3,"Course Unit:");
	xlsWriteLabel(1, 2, $department);
	xlsWriteLabel(2, 2, $lecturer_name);
	xlsWriteLabel(3, 2, $year);
	xlsWriteLabel(4, 2, $today);
	xlsWriteLabel(1, 4, $semester);
	xlsWriteLabel(2, 4, $course_name." (year ".$year_of_study.") ".$branch);
	xlsWriteLabel(3, 4, $programs);
	xlsWriteLabel(4, 4, $course_unit_name);
	 
	if($result){
		$sql = "SELECT DISTINCT(question_id) question_id, question 
		FROM question_answers 
		WHERE course_course_unit_id = ".$course_course_unit_id." AND year_of_study = ".$year_of_study." AND question_id > 0 AND branch = ".$branch_id;
		
		$result = $database->query($sql);
		$rows = $result->fetchAll();
		$xlsRow = 6;
		//xlsWriteLabel($xlsRow, 1,$xlsRow);
		//echo "<pre>".print_r($rows, true)."</pre>";
		foreach($rows as $row){
			xlsWriteLabel($xlsRow, 1,$row['question']);
			xlsWriteLabel(++$xlsRow, 3,"Frequency");
			xlsWriteLabel($xlsRow, 4,"Percentage");
			//if($xlsRow >= 6){
			//	break;
			//}
			$query = "SELECT COUNT(answer_id) count, answer FROM question_answers WHERE question_id = ".$row['question_id']." AND course_course_unit_id = ".$course_course_unit_id." AND year_of_study = ".$year_of_study." AND branch = ".$branch_id." AND answer_id > 0 GROUP BY answer_id ORDER BY answer_id";
			//echo $query;
			$result2 = $database->query($query);
			$answer_rows = $result2->fetchAll();
			$count = 0;
			$xlsRow++;
			foreach($answer_rows as $answer_row){
				xlsWriteLabel($xlsRow, 2,$answer_row['answer']);
				xlsWriteLabel($xlsRow, 3,$answer_row['count']);
				$count += $answer_row['count'];
				$xlsRow++;
			}
			xlsWriteLabel($xlsRow, 2, "Total");
			xlsWriteLabel($xlsRow, 3, $count);
			$xlsRow++;
		}
	
		$query = "SELECT DISTINCT(answer) answer, question 
		FROM question_answers 
		WHERE course_course_unit_id = ".$course_course_unit_id." AND year_of_study = ".$year_of_study." AND branch = ".$branch_id."  AND question_id = 0 ORDER BY question";
		
		$result = $database->query($query);
		$rows = $result->fetchAll();
		$xlsRow++;
			xlsWriteLabel($xlsRow, 1, "Comments and Suggestions");
		$xlsRow++;
		$xlsRow++;
		foreach($rows as $row){
			if(!empty($row['answer'])){
				xlsWriteLabel($xlsRow, 1, ucfirst($row['question']));
				xlsWriteLabel($xlsRow, 2, ucfirst($row['answer']));
				$xlsRow++;	
			}
		}
	}
	xlsEOF();
	}else{
		xlsBOF();
		xlsWriteLabel(0, 0,"NO results");
		xlsEOF();
	}
}

function excel_students($course_id){
	global $database; 
	$course = Course::find_by_id($course_id);
	//echo "<pre>".print_r($course, true)."</pre>";
	//echo $course_id."<p>Mike</p>";
	//exit;
	// prepare headers information
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");
	header("Content-Disposition: attachment; filename=\"Students_registered_".ucfirst($course->name)."_".YEAR."_".SEMESTER."_(".date("Y-m-d %H:%M:%S").").xls\"");
	header("Content-Transfer-Encoding: binary");
	header("Pragma: no-cache");
	header("Expires: 0");
	// start exporting
	xlsBOF();
	// first row 
	xlsWriteLabel(0, 0,"Name");
	xlsWriteLabel(0, 1,"Student No.");
	xlsWriteLabel(0, 2,"Year of study.");
	xlsWriteLabel(0, 3,"Course.");
	xlsWriteLabel(0, 4,"Status");
	xlsWriteLabel(0, 5,"Branch");
	// second row 
	
	$students = Student::find_all_by_course_id($course_id);
	$xlsRow = 1;
		foreach($students as $student){ 
			if($user = User::find_by_id($student->user_id)){
				$course_unit_count = 0;
				$course_unit_total = $student->course_unit_no;
				$student->student_no = str_replace("/", "-", $student->student_no);
				$stud_no = explode('-', $student->student_no);
				$branch = substr($stud_no[2],0,1);
				//echo $branch;
				$branches = Branch::getBranches();
				$branch = ucfirst($branches[$branch]);
				$count_display = "";
				
				$units = Student_course_unit::find_all_by_user_id($student->user_id);
				$unit_array = array();
				if($units){
					foreach($units as $unit){
						$unit_array[] = $unit->course_course_unit;
					}
					$unit_array_values = "'" . implode("', '", $unit_array) . "'";
					//echo "<pre>".print_r($unit_array, true)."</pre>";
					$query = Course_course_unit::find_all_course_course_units_by_course(" WHERE ccu.id IN (".$unit_array_values.") ORDER BY cu.name DESC");
				}else{
					$query = Course_course_unit:: find_all_course_course_units_by_course();
				}
				if(isset($query)){
					while($row = $query->fetch(PDO::FETCH_ASSOC)) {
						$course_complete = Question_answer::find_if_complete(YEAR, SEMESTER, $row['course_unit'], $student->user_id, $row['lecturer']);	
						
						if($course_complete>=1){
							++$course_unit_count;
						}
					}
					if($course_unit_count >= $course_unit_total && $course_unit_count >= 1){
						$count_display = "Complete (".$course_unit_count."/".$course_unit_total.")";	
					}elseif($course_unit_count > 0){
						$count_display = $course_unit_count."/".$course_unit_total;		
					}else{
						$count_display = $course_unit_count."/".$course_unit_total;	
					}	
				}
				//echo $user->full_name()." ".$student->student_no." ".$count_display."<br>";
				xlsWriteLabel($xlsRow, 0, $user->full_name());
				xlsWriteLabel($xlsRow, 1, $student->student_no);
				xlsWriteLabel($xlsRow, 2, $student->year);
				xlsWriteLabel($xlsRow, 3, ucfirst($course->name));
				xlsWriteLabel($xlsRow, 4, $count_display);
				xlsWriteLabel($xlsRow, 5, $branch);
			}
			$xlsRow++;	
		}
		//exit;
		xlsEOF();
}


?>

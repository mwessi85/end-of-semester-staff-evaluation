<?php
$query = Question_answer::find_all_download();
$row = $query->fetch(PDO::FETCH_ASSOC);
$headers = array_keys($row);
	//echo "<pre>".print_r($headers, true)."</pre>";
	//exit;
$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
if(Input::get('download')){
	admin_only($session->user_id);
	if(Input::get('department_id')){
		$department_id = urldecode(base64_decode(Input::get('department_id')));
		if(isset($session)){
			excel_items("SELECT * FROM question_answers WHERE academic_unit_id = ".$department_id." ORDER BY DATE DESC");
		}
	}elseif(Input::get('sub_department_id')){
		$sub_department_id = urldecode(base64_decode(Input::get('sub_department_id')));
		if(isset($session)){
			excel_items("SELECT * FROM question_answers WHERE department_id = ".$sub_department_id." ORDER BY DATE DESC");
		}
	}elseif(Input::get('course_id')){
		$course_id = urldecode(base64_decode(Input::get('course_id')));
		//echo Input::get('course_id')."<br>";
		if(isset($session)){
			if(Input::get('students')){
				excel_students($course_id);
			}else{
				excel_items("SELECT * FROM question_answers WHERE course_id = ".$course_id." ORDER BY DATE DESC");
			}
		}
	}elseif(Input::get('course_unit_id')){
		$course_unit_id = urldecode(base64_decode(Input::get('course_unit_id')));
		if(isset($session)){
			excel_items("SELECT * FROM question_answers WHERE course_unit_id = ".$course_unit_id." ORDER BY DATE DESC");
		}
	}elseif(Input::get('user_id')){
		$user_id = urldecode(base64_decode(Input::get('user_id')));
		if(Input::get('course_course_unit_id') && Input::get('year_of_study') && Input::get('branch')){
			
			excel_staff(urldecode(base64_decode(Input::get('course_course_unit_id'))), urldecode(base64_decode(Input::get('year_of_study'))), urldecode(base64_decode(Input::get('branch'))) );
		}
	}else{
		excel_items("SELECT * FROM question_answers ORDER BY DATE DESC");
	}
	//exit;
	
	
	
	/*$sql = "SELECT * FROM question_answers";
	header("Content-Type: text/csv");
	header("Content-Disposition: attachement;filename=course_evaluation.csv");
	header("Cache-control: no cache, no-state, must-revalidate");
	header("pragma: no-cache");
	header("Expires: 0");
	$csvoutput = fopen("php://output", "w");
	$row = $query->fetch(PDO::FETCH_ASSOC);
	$headers = array_keys($row);
	fputcsv($csvoutput, $headers);
	fputcsv($csvoutput, $row);
	while ($row = $query->fetch(PDO::FETCH_ASSOC)){
		fputcsv($csvoutput, $row);
	}
	fclose($csvoutput);
	exit;*/
}
//exit;
?>
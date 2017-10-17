<?php
$query = "SELECT * FROM question_answers ORDER BY id DESC";
$result = $database->query($query);
//$row = $result->fetch(PDO::FETCH_ASSOC);
//echo "<pre>".print_r($row , true)."</pre>";
$i =0;
if($result){
while($row = $result->fetch()){

	if($student = Student::find_by_user_id($row['respondent_id'])){
		$student->student_no = str_replace("/", "-", $student->student_no);
		$stud_no = explode('-', $student->student_no);
		$branch = substr($stud_no[2],0,1);

		if(empty($row['branch'])){
			$sql = "UPDATE question_answers SET branch = '".$branch."' WHERE respondent_id = ".$row['respondent_id'];
    		$query = $database->query($sql);
		}
		//echo ++$i;
	}else{
		$session->message("error: Failed at getting student");
		redirect_to("index.php");	
	}
}
$session->message("success: Update done");
redirect_to("index.php");
}else{
	$session->message("error: Failed!");
	redirect_to("index.php");	
}

?>
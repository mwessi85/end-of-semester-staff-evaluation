<?php 
//if(!empty($remove_duplicates){
	$sql = "SELECT * FROM question_answers WHERE course_course_unit_id = 11 AND year_of_study = 1 AND branch = 3";
	$result = $database->query($sql);
	$rows = $result->fetchAll();
	//echo "<pre>".print_r($rows, true)."</pre>";
	foreach($rows as $row){
		$sql ="
		SELECT * FROM question_answers WHERE
		question_id = ".$row['question_id']." AND 
		year_of_study = ".$row['year_of_study']." AND 
		program_id= ".$row['program_id']." AND 
		course_course_unit_id = ".$row['course_course_unit_id']." AND 
		course_id = ".$row['course_id']." AND 
		course_unit_id = ".$row['course_unit_id']." AND 
		year = ".$row['year']." AND 
		semester =  ".$row['semester']." AND 
		lecturer_id = ".$row['lecturer_id']." AND 
		branch = ".$row['branch']." AND 
		respondent_id = ".$row['respondent_id']." AND 
		question_id > 0 AND
		id !=  ".$row['id'];
		//echo $sql."<br>";
		$result_2 = $database->query($sql);
		$records = $result_2->fetchAll();
		if($records){
			foreach($records as $record){
				echo $record['respondent']." - ".$record['lecturer']." - ".$record['course']." - ".$record['course_unit']."<br>";
				//$query = "DELETE FROM question_answers WHERE id = ".$record['id'];
				//$result = $database->query($query);
			}
		}
	}

//}
?>
<p><a href="index.php?p=default">Home</a></p>

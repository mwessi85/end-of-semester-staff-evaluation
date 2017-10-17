<?php
$sql = "SELECT DISTINCT(course_id) course_id, course  FROM question_answers";
$result = $database->query($sql);
if($result){
	$course_rows = $result->fetchALL(PDO::FETCH_ASSOC);
	if($course_rows){
		foreach($course_rows as $course_row){?>
		<a href="index.php?c=course&p=course&course_id=<?php echo urlencode(base64_encode($course_row['course_id']));?>"><?php echo titleCase($course_row['course']); ?></a><br/>	
<?php		}			
	}
}
?>
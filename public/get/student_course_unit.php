<?php require_once("../../initialize.php");

$q = strtolower($_GET["q"]);


if (!$q) return;
$sql = "SELECT c.id course_id, c.name course_name, c.code course_code, cu.name, cu.code course_unit_code, ccu.status, ccu.id course_course_unit_id, ccu.course, ccu.course_unit, ccu.lecturer lecturer, ccu.year year, ccu.semester semester  FROM course_course_units ccu INNER JOIN courses c ON (c.id=ccu.course) INNER JOIN course_units cu ON (cu.id = ccu.course_unit) WHERE cu.name LIKE '%".$q."%' AND c.id = ".$_GET["course_id"]." ORDER BY name ASC";
$result = $database->query($sql);
$allResults = $result->fetchAll(PDO::FETCH_ASSOC);
foreach ($allResults as $row){
	$user = User::find_by_id($row['lecturer']);
	$lecturer = $user->full_name();
	//echo $_GET["q"];
	//echo "<pre>".print_r($_GET, true)."</pre>";
	//echo $_GET["course_id"];
	echo  $row['name'].": ".$row['course_name']." - ".$lecturer." | ".$row['course_course_unit_id']." \n";
}
return false;
?>
<p><font color="#000000">recognize </font></p>
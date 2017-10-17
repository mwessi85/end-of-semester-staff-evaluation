<?php require_once("../../initialize.php");

$q = strtolower($_GET["q"]);
if (!$q) return;

$sql = "SELECT * FROM sub_departments WHERE name LIKE '%$q%' ORDER BY name ASC";
$sub_departments = Sub_department::find_by_sql($sql);
foreach($sub_departments as $sub_department){
	echo $sub_department->name." | ".$sub_department->id." \n";
}
return false;
?>
<p><font color="#000000">recognize </font></p>
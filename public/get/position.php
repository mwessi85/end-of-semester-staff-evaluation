<?php require_once("../../initialize.php");

$q = strtolower($_GET["q"]);
if (!$q) return;

$sql = "SELECT * FROM positions WHERE title LIKE '%$q%' ORDER BY title ASC";
$positions = Title::find_by_sql($sql);
foreach($positions as $position){
	echo $position->title." | ".$position->id." \n";
}
return false;
?>
<p><font color="#000000">recognize </font></p>
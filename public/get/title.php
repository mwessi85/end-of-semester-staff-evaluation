<?php require_once("../../initialize.php");

$q = strtolower($_GET["q"]);
if (!$q) return;

$sql = "SELECT * FROM titles WHERE title LIKE '%$q%' ORDER BY title ASC";
$titles = Title::find_by_sql($sql);
foreach($titles as $title){
	
	echo $title->title." | ".$title->id." \n";
}
return false;
?>
<p><font color="#000000">recognize </font></p>



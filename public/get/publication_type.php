<?php require_once("../../initialize.php");

$q = strtolower($_GET["q"]);
if (!$q) return;

$sql = "SELECT * FROM publication_types WHERE type LIKE '%$q%' ORDER BY type ASC";
$publication_types = Publication_type::find_by_sql($sql);
foreach($publication_types as $publication_type){
	echo $publication_type->type." | ".$publication_type->id." \n";
}
return false;
?>
<p><font color="#000000">recognize </font></p>
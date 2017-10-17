<?php require_once("../../initialize.php");

$q = strtolower($_GET["q"]);
if (!$q) return;

$sql = "SELECT * FROM question_categorys WHERE name LIKE '%$q%' ORDER BY title ASC";
$question_categorys = Question_category::find_by_sql($sql);
foreach($question_categorys as $question_category){
	
	echo $question_category->title." | ".$question_category->id." \n";
}
return false;
?>
<p><font color="#000000">recognize </font></p>



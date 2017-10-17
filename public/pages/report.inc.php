<div style="border:0px solid #666; clear:both;">
<?php 

if(Input::get('course_course_unit_id')){
	$course_course_unit_id = urldecode(base64_decode(Input::get('course_course_unit_id')));
	//echo $course_course_unit;
	$branch_id = urldecode(base64_decode(Input::get('branch')));
	$branches = Branch::getBranches();
	$branch = ucfirst($branches[$branch_id]);
	$course_course_unit_id;
	if($course_course_unit_id > 0){
		$course_course_unit = Course_course_unit::find_by_id($course_course_unit_id);
		$fields = array("course", "course_unit", "lecturer", "year", "semester", "status");
		foreach ($fields as $field){
			$$field = $course_course_unit->$field;
		}
		if(!empty($course_course_unit->lecturer)){
			$user_id = $course_course_unit->lecturer;
			$user = User::find_by_id($user_id);
			$lecturer_id = $user->id;
			$lecturer_name = $user->full_name_title();
		}
		
		$course_id = $course_course_unit_course = $course_course_unit->course;
		if(!empty($course_course_unit_course)){
			$course_object = Course::find_by_id($course_course_unit_course);
			$course_name = $course_object->name;
		}
		$course_unit_id = $course_course_unit_course_unit = $course_course_unit->course_unit;
		if(!empty($course_course_unit_course_unit)){
			$course_unit_object = Course_unit::find_by_id($course_course_unit_course_unit);
			$course_unit_name = $course_unit_object->name;
		}
		
		 if(!empty($course_object->sub_department)){
				$sub_department_object = Sub_department::find_by_id($course_object->sub_department);
				$sub_department_name = $sub_department_object->name;
				$sub_department_id = $sub_department_object->id;
			}else{
				$sub_department = "";
				if(!empty($course_object->department)){
					$department_object = Department::find_by_id($course_object->department);
					$sub_department_name = $department_object->name;	
					$sub_department_id = "";	
				}
			}
			
			if(!empty($course_object->department)){
				$department_object = Department::find_by_id($course_object->department);
				$department_name = $department_object->name;	
				$department_id = $department_object->id;	
			}else{
				$sub_department_object = Sub_department::find_by_id($course_object->sub_department);
				$department_object = Department::find_by_id($sub_department_object->department);
				$department_name = $department_object->name;	
				$department_id = $department_object->id;		
			}
			if(Input::get('submit')){
				//echo Input::get('year_of_study');
				//exit;
				if(Input::get('fix')){
					$fix = Input::get('fix');
				}
				if(Input::get('year_of_study')){
					$year_of_study = Input::get('year_of_study');
				}else{
					$session->message("error:Year of study was not selected!");
					redirect_to("index.php?c=course&p=course&course_id=".urlencode(base64_encode($course_id)));	
				}
			}
	}
}
	
?>    

 <div style="width: 100%; float: right; margin-right: 2%; border: 0px solid #666;">
<table class="results">
<tr>
<td><?=$course_unit_name?>:</td>
<td><?=$lecturer_name?></td>
</tr>
</table>
<?php 
$sql = "SELECT DISTINCT(year_of_study) year_of_study FROM question_answers WHERE course_course_unit_id = ".$course_course_unit_id." AND branch = ".$branch_id;
	//echo $sql;
$result = $database->query($sql);
$row = $result->fetchColumn();
//echo "<pre>".print_r($row, true)."</pre>";
if(!empty($row)){
	//exit;
?>
 <form method="post" action="index.php?p=report&course_course_unit_id=<?php echo urlencode(base64_encode($course_course_unit_id))?>&branch=<?php echo urlencode(base64_encode($branch_id))?>" autocomplete="off">
    <fieldset>
        <legend>Evaluation performace summary</legend>
        
        <p>
       <!-- <label for="course_course_unit_id">Choose class: </label>-->
        <select name="year_of_study">
        <option selected disabled="disabled">Choose year of study</option>
         <?php 
		$result = $database->query($sql);
		$allResults = $result->fetchAll(PDO::FETCH_ASSOC);
        foreach($allResults as $row){
                echo "<option value = '".$row['year_of_study']."'>".$row['year_of_study']."</option>";

        }
        ?>
        </select></p>
        <p><input type="search" value="" placeholder="fix"></p>
    <input type="submit" name="submit" value="Go">
    </fieldset>
   </form>
   <?php } else{
		$session->message("error:NO report found!");
		redirect_to("index.php?c=course&p=course&course_id=".urlencode(base64_encode($course_id)));	
	}?>
 </div>
 
 
  
 </div>
 
 <div style="width: 100%; float: right; margin-right: 2%; border: 0px solid #666;">
  <?php 
    //$branches = Branch::getbranches();
	//echo "<pre>".print_r($branches, true)."</pre>";
	if(!empty($course_course_unit_id) && !empty($year_of_study)){
            //echo $course_course_unit_id;
			$condition =  " course_course_unit_id = ".$course_course_unit_id." AND year_of_study = ".$year_of_study." AND branch = ".$branch_id;
            $query = "SELECT * FROM question_answers WHERE ".$condition;
			//echo $query;
			
            $result = $database->query($query);
            $row = $result->fetch(PDO::FETCH_ASSOC);
            //echo "<pre>".print_r($row, true)."</pre>";
            //exit;
			//echo $query;
			
            $result_programs = $database->query("SELECT COUNT(program)count, program FROM question_answers WHERE ".$condition." GROUP BY program");
			//echo "SELECT COUNT(program), program FROM question_answers WHERE ".$condition." GROUP BY program";
            //$row_programs = $result_programs->fetchAll(PDO::FETCH_ASSOC);
			//echo "<pre>".print_r($row_programs, true)."</pre>";
			$programs = "";
			$i = 0;
			while($row_programs = $result_programs->fetch(PDO::FETCH_ASSOC)){
				$programs .= $row_programs["program"]."/";
				//echo $ro
			}
			$programs.="/";
			$programs = str_replace("//", "", $programs);
			//echo $programs;
			/*foreach($row_programs as $row_program){
				$programs .= $row_program["program"]."/";
				$i++;
			}*/
		
            $program = $row['program'];
            $today = date("Y-m-d h:i:s A");
			
			if(!empty($fix)){
				exit;
				//$sql = "SELECT * FROM question_answers WHERE ".$condition;
				$result = $database->query($query);
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
							if($fix == "DELETE"){
								$query = "DELETE FROM question_answers WHERE id = ".$record['id'];
								$result = $database->query($query);
							}
						}
					}
				}

}
			
            ?>
<!--<div style="width: 100%; float: right; margin-right: 2%; border: 0px solid #666;">-->
<div style="width: 830px; float: left; margin-right: 5%; clear:both; border: 0px solid #666;">
<table class="text">
<tr>
<td class="label">Program:</td><td colspan="4"><?php echo $course_name." ".$programs." (Year ".$year_of_study.") ".$branch;?>

</td>
</tr>
<tr>
<td class="label">Course Unit:</td><td><span class="red_outline"><?php echo $course_unit_name;?></span></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td class="label">Lecturer's/Facilitator's Name:</td><td><span class="red_outline"><a href="index.php?c=staff&p=staff&user_id=<?php echo urlencode(base64_encode($lecturer_id));?>"><?php echo $lecturer_name;?></a></span></td>
</tr>

<tr>
<td class="label">Faculty/Institute/School:</td><td><?php echo $department_name;?></td><td>&nbsp;</td><td class="label">Academic year-Semester:</td><td><?php echo $year."/".++$year." - Sem ".$semester;?></td>
</tr>
<tr>
<td class="label">Department:</td><td><?php echo $sub_department_name;?></td><td>&nbsp;</td><td class="label">Date:</td><td><?php echo $today;?></td>
</tr>
</table>
</div>
<div style="width: 100%; float: right; margin-right: 2%; border: 0px solid #666;">
<table class="text">

<?php 
//$sql = "SELECT DISTINCT(question_id) question_id, question FROM question_answers WHERE course_course_unit_id = ".$course_course_unit_id." AND question_id > 0";
//echo $sql;
//$sql = "SELECT DISTINCT(question_id) question_id, question FROM question_answers WHERE lecturer_id = ".$user->id."  AND question_id > 0 ".$condition;
$sql = "SELECT DISTINCT(question_id) question_id, question FROM question_answers WHERE ".$condition;
//echo $sql;
$result = $database->query($sql);
$rows = $result->fetchAll();
//echo "<pre>".print_r($rows, true)."</pre>";
//echo "|".$condition."|";
//exit;
foreach($rows as $row){
if($row['question_id'] > 0){
?>
<tr><td colspan="4"><strong><?=$row['question']?></strong></td></tr>
<tr><td></td><td></td><td>Frequency</td><td>Percentage</td></tr>

<?php

$query = "SELECT COUNT(answer_id) count, answer FROM question_answers WHERE".$condition." AND question_id = ".$row['question_id']." AND answer_id > 0 GROUP BY answer_id ORDER BY answer_id";
	
/*$query = "SELECT COUNT(answer_id) count, answer FROM question_answers WHERE".$condition." AND question_id = ".$row['question_id']." AND answer_id > 0 AND program = '".$program."' GROUP BY answer_id ORDER BY answer_id";*/
							
/*$query = "SELECT COUNT(answer_id) count, answer FROM question_answers WHERE".$condition." AND question_id = ".$row['question_id']." AND answer_id > AND program = ".$program." 0 GROUP BY answer_id ORDER BY answer_id";*/
							
//echo $query."<br>";
							
$result2 = $database->query($query);
$answer_rows = $result2->fetchAll();
$count = 0;
foreach($answer_rows as $answer_row){?>
    <tr><td></td><td><?=$answer_row['answer']?></td><td><?=$answer_row['count']?></td><td></td></tr>
    <?php 
    $count += $answer_row['count'];
}
?>
<tr><td></td><td><strong>Total</strong></td><td><strong><?=$count?></strong></td><td></td></tr>
<?php
}
}
?>
</table>
<?php 
//$sql = "SELECT DISTINCT(answer) answer, question FROM question_answers WHERE course_course_unit_id = ".$course_course_unit_id." AND question_id = 0 ORDER BY question";
$sql = "SELECT DISTINCT(answer) answer, question FROM question_answers WHERE ".$condition." AND question_id = 0  ORDER BY question";
//echo $sql;
$result = $database->query($sql);
$rows = $result->fetchAll();
foreach($rows as $row){
if(!empty($row['answer'])){
?>
<p><?= ucfirst($row['question'])?>: <?= $row['answer']?></p>
<?php	
}
}?>
            
            <?php
    }else{
		//echo $course_course_unit_id;	
	}
	/*else{
        $sql = "SELECT DISTINCT(course_course_unit_id) FROM question_answers WHERE lecturer_id = ".$user->id;
        $result = $database->query($sql);
        $rows = $result->fetchAll();	
        
        if($rows){
        $course_course_unit_array = array();
        foreach($rows as $row){
            $course_course_unit_array[] = $row['course_course_unit_id'];
        }
        $course_course_unit_id_values = "'" . implode("', '", $course_course_unit_array) . "'";
        $sql = "SELECT * FROM question_answers WHERE course_course_unit_id  IN (".$course_course_unit_id_values.")";
        }
    }*/
 ?>

 </div>
 <?php if(!empty($year_of_study) && !empty($course_course_unit_id)){?>
 <a href="index.php?c=csv_download&p=staff&download=true&course_course_unit_id=<?php echo urlencode(base64_encode($course_course_unit_id));?>&year_of_study=<?php echo urlencode(base64_encode($year_of_study));?>&user_id=<?php echo urlencode(base64_encode($course_id));?>&branch=<?php echo urlencode(base64_encode($branch_id));?>">Export to Excel</a>
 <?php } ?>
 | <a href="index.php?c=course&p=course&course_id=<?=urlencode(base64_encode($course_id))?>">Back</a>
</div>



<div style="border:0px solid #666; clear:both;">
<?php 
if(Input::get('user_id')){
	$user_id = urldecode(base64_decode(Input::get('user_id')));	
}
if($staff = Staff::find_by_user_id($user_id)) :;
	$title_object = Title::find_by_id($staff->title);
	if($title_object){
		$staff_title = $title_object->title.". ";
	}else{
		$staff_title = "";	
	}
	$position_object = Position::find_by_id($staff->position);
	if($position_object){
		$staff_position = $position_object->title;
	}else{
		$staff_position = "";	
	}

	$staff_department = Department::find_by_id($staff->department);
	$user = User::find_by_id($user_id);
?>    
    <div style="margin-top:2em; border: 0px solid #666; clear:both;">
       <!-- <div style="border: 0px solid #666; width: 250px; float: left">-->
        <div style="width: 280px; float: left; margin-right: 2%;  border: 0px solid #666;">
            <?php require_once("photo.php"); ?>
            
        <?php if(isset($_SESSION['st_user_id'])){?>
			<?php 
            if($session->session_no == Session::session_no($user_id) || $session->session_no == Session::session_no(1)){
                //require_once("pages/forms/photo.php");
            }
            ?>
        <?php }?>
        </div>
         <div style="width: 550px; float: right; margin-right: 2%; border: 0px solid #666;">
         	 <table>
                <tr>
                <tr>
                    <td class="label"></td>
                    <td><strong><?php echo $staff_title.$user->full_name(); ?></strong></td>
                </tr>
                <tr>
                    <td class="label">Position:</td>
                    <td><?php echo $staff_position; ?></td>
                </tr>
                <tr>
                    <td class="label">Academic unit:</td>
                    <td> 
                    <a href="index.php?c=department&p=department&department_id=<?php echo urlencode(base64_encode($staff->department));?>"><?php echo titleCase($staff_department->name); ?></a></td>
                </tr>
                <!--
                <tr>
                    <td class="label">Username:</td>
                    <td> <?php echo $user->username; ?></td>
                </tr>
                -->
                <tr>
                    <td class="label">Email:</td>
                    <td> <?php echo $user->email; ?></td>
                </tr>
            <?php if(isset($_SESSION['st_user_id'])){?>
                <?php  if($session->session_no == Session::session_no($user_id) || $session->session_no == Session::session_no(1)){?>
                    <tr>
                        <td class="label"></td>
                        <td><span class="required">Edit:</span>
                        <a href="index.php?p=users&c=users&user_id=<?php echo urlencode(base64_encode($user->id));?>&edit=true">User Details</a> | 
                        <a href="index.php?p=password&c=password&user_id=<?php echo urlencode(base64_encode($user->id));?>">Password</a></td>
                    </tr>
                <?php }?>
            <?php }?>
                <!--<tr>
                    <td class="label">Staff No:</td>
                    <td> <?php echo $staff->staff_no; ?></td>
                </tr>-->
                
            <?php if(isset($_SESSION['st_user_id'])){?>
                <?php  if($session->session_no == Session::session_no($user_id) || $session->session_no == Session::session_no(1)){?>
                         <td class="label"></td>
                         <td><span class="required">Edit:</span>
                         <a href="index.php?p=staff&c=staff&staff_id=<?php echo urlencode(base64_encode($staff->id));?>&user_id=<?php echo urlencode(base64_encode($user->id));?>&edit=true">Staff Details</a></td>
                     </tr>
                <?php }?>
            <?php }?>	
            
            <?php if($phones = Phone::find_all_by_user_id($user_id)){?>
                    <tr><td class="label">Tel:</td><td>
                    <?php 
                        $i = 0;
                        foreach($phones as $phone) : 
                        
                                    
                    ?>
                        <?php if(isset($_SESSION['st_user_id'])){?>
                            <?php  if($session->session_no == Session::session_no($user_id) || $session->session_no == Session::session_no(1)){?>
                            <a href='index.php?c=phone&p=phone&user_id=<?php echo urlencode(base64_encode($user->id));?>&edit=true&phone_id=<?php echo  urlencode(base64_encode($phone->id));?>'>
                            <?php 
                                 if($i == 0){
                                    echo $phone->phone_number(); 
                                 }else{
                                    echo ", ".$phone->phone_number();	 
                                 }
                                 
                                 ?>
                            </a>
                            
                        <?php }else{
                            if($i == 0){
                                    echo $phone->phone_number(); 
                                 }else{
                                    echo ", ".$phone->phone_number();	 
                                 }
                        }?>
                        
                        <?php }else{?>
                        <?php 
                                 if($i == 0){
                                    echo $phone->phone_number(); 
                                 }else{
                                    echo ", ".$phone->phone_number();	 
                                 }
                                 
                                 ?>
                                 
                            <?php }
                            
                            $i++;
                            ?>
                    <?php endforeach;
                }?> 
                <?php if(isset($_SESSION['st_user_id'])){?>
                <?php  if($session->session_no == Session::session_no($user_id) || $session->session_no == Session::session_no(1)){?>
                   &nbsp;|&nbsp; <a href='index.php?c=phone&p=phone&user_id=<?php echo urlencode(base64_encode($user->id));?>&add=true'>Add Phone</a>
                <?php }?>   
                </td>
                </tr>
                <?php }?>
                </table>
         </div>
         <?php if(isset($session)){?>
		<?php if(Session::user_permission($user->id)) :?>
        <div><p><a href='index.php?c=users&p=users&add=true'>Add User</a></div>
        <?php endif?>
    <?php }
	?>
         <div style="width: 100%; float: right; margin-right: 2%; border: 0px solid #666;">
         <form method="post" action="index.php?p=staff&user_id=<?php echo urlencode(base64_encode($user->id))?>" autocomplete="off">
            <fieldset>
                <legend>Evaluation performace summary</legend>
                <p>
               <!-- <label for="question_id">Choose question: </label>-->
                <select name="question_id">
                <option value="0" selected disabled="disabled">Choose question</option>
                 <?php 
				$sql = "SELECT DISTINCT(question_id), question, lecturer FROM question_answers WHERE question_category_id = 3 AND lecturer_id = ".$user->id;
				$result = $database->query($sql);
				$allResults = $result->fetchAll(PDO::FETCH_ASSOC);
				foreach($allResults as $row){
						echo "<option value = '".$row['question_id']."'>".$row['question']."</option>";
	
				}
				?>
				</select></p>
                
                <p>
               <!-- <label for="course_course_unit_id">Choose class: </label>-->
                <select name="course_course_unit_id">
                <option value = "0" selected disabled="disabled">Choose class</option>
                 <?php 
				$sql = "SELECT DISTINCT(course_course_unit_id) course_course_unit_id, program_id, course_id, course_unit_id, lecturer FROM question_answers WHERE lecturer_id = ".$user->id;
				//echo $sql;
				$result = $database->query($sql);
				$allResults = $result->fetchAll(PDO::FETCH_ASSOC);
				foreach($allResults as $row){
					$course_obj = Course::find_by_id($row['course_id']);
					$course_unit_obj = Course_unit::find_by_id($row['course_unit_id']);
					$program_obj = Program::find_by_id($row['program_id']);
					echo "<option value = '".$row['course_course_unit_id']."'>".$course_obj->name."(".$program_obj->name.") ".$course_unit_obj->name."</option>";
					$course_course_units[] = $row['course_course_unit_id'];	
				}
				$course_course_units = "'" . implode("', '", $course_course_units) . "'";
				$course_course_units = array_unique($course_course_units);
				?>
				</select></p>
                <p>
                <!--<label for="year_of_study">Choose year of study: </label>-->
                <select name="year_of_study">
                <option selected disabled="disabled">Choose year of study</option>
                 <?php 
				//$sql = "SELECT DISTINCT(year_of_study) year_of_study FROM question_answers WHERE lecturer_id = ".$user->id." AND course_course_unit_id IN (".$unit_array_values.") ";
				$sql = "SELECT DISTINCT(year_of_study) year_of_study FROM question_answers WHERE lecturer_id = ".$user->id;
				$result = $database->query($sql);
				$allResults = $result->fetchAll(PDO::FETCH_ASSOC);
				foreach($allResults as $row){
						echo "<option value = '".$row['year_of_study']."'>".$row['year_of_study']."</option>";
	
				}
				?>
				</select></p>
                
            <input type="submit" name="search_question" value="Go">
            </fieldset>
            <?php 
			if(Input::get('search_question')){
			?>
            <a href="index.php?c=csv_download&p=staff&download=true&user_id=<?php echo urlencode(base64_encode($user_id));?>">Export to Excel</a>
            <?php 
			}
			?>
           </form>
         </div>
         
         
			<?php 
			if(Input::get('search_question')){
				$id = "question_".$input = Input::get("question_id");
				$course_course_unit_id = Input::get("course_course_unit_id");
				$year_of_study = Input::get("year_of_study");
				$question_id = Input::get("question_id");
				
				if($course_course_unit_id>0){
					$condition =  " AND course_course_unit_id = ".$course_course_unit_id." ";
					if(!empty($year_of_study)){
						$condition =  " AND course_course_unit_id = ".$course_course_unit_id." AND year_of_study = ".$year_of_study." ";
					}else{
						$session->message("error: 'Year of study' must be selected");
						redirect_to("index.php?p=staff&user_id=".urlencode(base64_encode($staff->user_id)));
					}
					///$sql_all = "SELECT * FROM question_answers WHERE lecturer_id = ".$user->id.$condition;
				}else{
					$condition = "";	
				}
				if($question_id >0){
					$sql = "SELECT * FROM question_answers WHERE lecturer_id = ".$user->id." AND question_id = ".Input::get("question_id").$condition;
					if(isset($sql)){
						$result = $database->query($sql);
						$row = $result->fetch(PDO::FETCH_ASSOC);
						//$rows = $result->fetchAll();
						//echo "<pre>".print_r($rows, true)."</pre>";
					?>
				   <!-- <div style="width: 100%; float: right; margin-right: 2%; border: 0px solid #666;">-->
					<div style="width: 830px; float: left; margin-right: 5%; clear:right; border: 0px solid #666;">
						<script type='text/javascript'>
						window.onload = function () {
						var chart = new CanvasJS.Chart('<?php echo $id;?>',
						{
						title:{
							text: '<?php echo $row['question']?>'
						},
						animationEnabled: true,
				legend:{
					verticalAlign: "bottom",
					horizontalAlign: "center"
				},
				data: [
				{        
					indexLabelFontSize: 20,
					indexLabelFontFamily: "Monospace",       
					indexLabelFontColor: "darkgrey", 
					indexLabelLineColor: "darkgrey",        
					indexLabelPlacement: "outside",
					type: "pie",       
					showInLegend: true,
					toolTipContent: "{y} - <strong>#percent%</strong>",
							dataPoints: [
					<?php
				//echo "<pre>".print_r($allResults, true)."</pre>"; 
					$query = 'SELECT * FROM question_answers 
					WHERE question_id = '.Input::get("question_id").' AND lecturer_id = '.$user->id.$condition.' GROUP BY answer';
					
					$result2 = $database->query($query);
					$allResults2 = $result2->fetch(PDO::FETCH_ASSOC);
					$query = "SELECT COUNT(answer_id) count, answer, question 
					FROM question_answers 
					WHERE question_id = ".Input::get("question_id")." AND lecturer_id = ".$user->id.$condition." 
					GROUP BY answer";
					
					$query3 = "SELECT SUM(count) FROM (SELECT COUNT(answer_id) count, answer, question FROM question_answers WHERE question_id = ".$row['question_id']." AND lecturer_id = ".$user->id.$condition.")src";
					$result3 = $database->query($query3);
					$sum_results = $result3->fetchColumn();
					//echo "Mike: ".$sum_results."\n";
					$result2 = $database->query($query);
					$allResults2 = $result2->fetchAll(PDO::FETCH_ASSOC);
					//echo "<pre>".print_r($allResults2, true)."</pre>";
					if ($allResults2) {
						//$sum_results = array_sum($allResults2);
						//echo $sum_results."\n";
						foreach ($allResults2 as $row2) { 
							$value_count = $row2['count'];
							$value = $row2['answer'];
							$percentage = $value_count/$sum_results*100;
							if(empty($value)){
									
							}
							echo "{  y: ".$value_count.", legendText:'".$value."', indexLabel: '".$value."' },\n";
						}
					}
				?>
				]
			}
			]
		});
		
		chart.render();
		}
		</script>
		<?php 	}?>
        <div id="<?php echo $id;?>" style="width: 100%;">
                        
        </div>
        <?php
			}
		}?>
                        
                        
 
                        

                        
                        
			
            
         </div>
         <div style="width: 100%; float: right; margin-right: 2%; border: 0px solid #666;">
          <?php 
			if(!empty($condition)){
					//$sql = "SELECT * FROM question_answers WHERE course_course_unit_id = ".$course_course_unit_id;
					//$sql = "SELECT * FROM question_answers WHERE lecturer_id = ".$user->id." AND question_id = ".Input::get("question_id").$condition;
					$query = "SELECT * FROM question_answers WHERE lecturer_id = ".$user->id.$condition;
					//echo $sql;
					$result = $database->query($query);
					$row = $result->fetch(PDO::FETCH_ASSOC);
					//echo "<pre>".print_r($row, true)."</pre>";
					//exit;
					$program = $row['program'];
					$course_course_unit = Course_course_unit::find_by_id($course_course_unit_id);
					$fields = array("course", "course_unit", "lecturer", "year", "semester", "status");
					foreach ($fields as $field){
						$$field = $course_course_unit->$field;
					}
					if(!empty($course_course_unit->lecturer)){
						$user_id = $course_course_unit->lecturer;
						$user = User::find_by_id($user_id);
						$user_search = $user->full_name();
					}else{
						$user_search = "";
						$user_id = 0;	
					}
					
					$course_id = $course_course_unit_course = $course_course_unit->course;
					if(!empty($course_course_unit_course)){
						$course_object = Course::find_by_id($course_course_unit_course);
						$course_search = $course_object->name;
					}
					$course_unit_id = $course_course_unit_course_unit = $course_course_unit->course_unit;
					if(!empty($course_course_unit_course_unit)){
						$course_unit_object = Course_unit::find_by_id($course_course_unit_course_unit);
						$course_unit_search = $course_unit_object->name;
					}
					$lecturer_id = $course_course_unit->lecturer;
					if($staff = Staff::find_by_user_id($course_course_unit->lecturer)){;
						$title_object = Title::find_by_id($staff->title);
						if($title_object){
							$staff_title = $title_object->title.". ";
						}else{
							$staff_title = "";	
						}
						$lecturer_name = $staff_title.$user->full_name();
					}
					
					if(!empty($course_object->sub_department)){
						$sub_department_object = Sub_department::find_by_id($course_object->sub_department);
						$sub_department = $sub_department_object->name;
						$sub_department_id = $sub_department_object->id;
					}else{
						$sub_department = "";
						if(!empty($course_object->department)){
							$department_object = Department::find_by_id($course_object->department);
							$sub_department = $department_object->name;	
							$sub_department_id = "";	
						}
					}
					
					if(!empty($course_object->department)){
						$department_object = Department::find_by_id($course_object->department);
						$department = $department_object->name;	
						$department_id = $department_object->id;	
					}else{
						$sub_department_object = Sub_department::find_by_id($course_object->sub_department);
						$department_object = Department::find_by_id($sub_department_object->department);
						$department = $department_object->name;	
						$department_id = $department_object->id;		
					}
					//$today = date("d-M-Y");
					$today = date("Y-m-d h:i:s A");
					?>
<!--<div style="width: 100%; float: right; margin-right: 2%; border: 0px solid #666;">-->
<div style="width: 830px; float: left; margin-right: 5%; clear:both; border: 0px solid #666;">
<table class="text">
    <tr>
    	<td class="label">Program:</td><td colspan="4"><?php echo $course_search." ".$program." (Year ".$year_of_study.")";?>
        
        </td>
    </tr>
    <tr>
    	<td class="label">Course Unit:</td><td><span class="red_outline"><?php echo $course_unit_search;?></span></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td class="label">Lecturer's/Facilitator's Name:</td><td><span class="red_outline"><?php echo $lecturer_name;?></span></td>
    </tr>
    
    <tr>
    	<td class="label">Faculty/Institute/School:</td><td><?php echo $department;?></td><td>&nbsp;</td><td class="label">Academic year-Semester:</td><td><?php echo $year."/".++$year." - Sem ".$semester;?></td>
    </tr>
    <tr>
    	<td class="label">Department:</td><td><?php echo $sub_department;?></td><td>&nbsp;</td><td class="label">Date:</td><td><?php echo $today;?></td>
    </tr>
    </table>
</div>
<div style="width: 100%; float: right; margin-right: 2%; border: 0px solid #666;">
    <table class="text">
    
    <?php 
	//$sql = "SELECT DISTINCT(question_id) question_id, question FROM question_answers WHERE course_course_unit_id = ".$course_course_unit_id." AND question_id > 0";
	//echo $sql;
	//$sql = "SELECT DISTINCT(question_id) question_id, question FROM question_answers WHERE lecturer_id = ".$user->id."  AND question_id > 0 ".$condition;
	$sql = "SELECT DISTINCT(question_id) question_id, question FROM question_answers WHERE lecturer_id = ".$user->id.$condition;
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
		
		
		$query = "SELECT COUNT(answer_id) count, answer FROM question_answers WHERE question_id = ".$row['question_id'].$condition." AND answer_id > 0 GROUP BY answer_id ORDER BY answer_id";
		//echo $query;
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
	$sql = "SELECT DISTINCT(answer) answer, question FROM question_answers WHERE lecturer_id = ".$user->id."  AND question_id = 0 ".$condition." ORDER BY question";
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
			}
		 ?>
        
         </div>
         <?php if(!empty($year_of_study) && !empty($course_course_unit_id)){?>
         <a href="index.php?c=csv_download&p=staff&download=true&course_course_unit_id=<?php echo urlencode(base64_encode($course_course_unit_id));?>&year_of_study=<?php echo urlencode(base64_encode($year_of_study));?>&user_id=<?php echo urlencode(base64_encode($course_id));?>">Export to Excel</a>
         <?php } ?>
    </div>
    
   
<?php endif?>

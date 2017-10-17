<?php

$sql = "SELECT * FROM users WHERE user_type = 'student' ORDER BY last_name, first_name, id desc";
$users = User::find_by_sql($sql);
?>

<div style="width: 830px; float: left; margin-right: 5%; clear:both; border: 0px solid #666;">
<span class='notification'>If you have logged in before this semester and cannot remember your username, check this list to see if your name exists (use ctrl+F then type your name) and use the corresponding username. If you cannot find it, type your registration number in the form below the list. If you still have trouble, consult the Quality Assurance administrators<br/>
</span>
</div>
    <table class="results">
    <tr>
    <th>Name</th>
    <th>Username.</th>
    <th>&nbsp;</th>
    </tr>
    <?php
    $i = 1;
	if($users){
		foreach($users as $user){
			$sudent_detail = Student::find_by_user_id($user->id);
			if(!$sudent_detail){?>
				<tr>
				<?php 
				if(isset($session->user_id)){
					if(Session::user_permission($user->id)){?>
						<td><a href="index.php?c=student&p=student&user_id=<?php echo urlencode(base64_encode($user->id));?>"><?php echo $user->full_name(); ?></a></td>
		<?php 		}else{?>
						<td><?php echo $user->full_name(); ?></td>
		<?php 		} 
				}else{?>
				<td><?php echo $user->full_name(); ?></td>
		<?php 	}?>	
				<td><?php echo $user->username; ?></td>
		<?php 	if(isset($session->user_id)){ 
					if(Session::user_permission($user->id)){?>
						<td><a href="index.php?p=users&c=users&user_id=<?php echo urlencode(base64_encode($user->id));?>&edit=true">Edit</a></td>
		<?php 		} 
				}
			}
		}
	}?>
    </tr>
    </table>
<hr/>
</div>

<div class="form2" style="width: 800px; clear:both">
<span class='notification'>If you have forgotten your username, enter your registration number below and you will be remainded in green text above the login form. If the system does not have a record of you, <a href="index.php?c=users&p=users&add=true">register<!--register--></a>!</span>
</div>
<div class="form3" style="width: 200px;">

<table>
<form name="username_remainder" action="index.php?c=login&p=login" method="post"> 
<tr>
<td class="white_table"><label for="student_no" class='label'>Registration No.:<span class="required"> *</span></label></td>
<td class="white_table"><input type="text" name="student_no" id="student_no" value="" required="required" 
    maxlength="15" pattern="^20\d{2}[/ -]{1}[A-Z a-z]{1}\d{3}[/ -]{1}\d{5}$" title = "Enter your student number" placeholder="Enter your student number"/></td>
</tr>
<tr>
<td class="white_table"></td>
<td class="white_table"><input class="submit button" type="submit" name="username_check" value="Enter" /></td>
</tr>
</form>
</table>
</div>


<h1>Login</h1>
<span class='notification'>Login with your username and password. If you have not registered this semester (I 2017), please click 'Register' at the bottom of the page to start your registration. If you have registered but do not know your password, click <a href='index.php?p=students_partially_registered'>Help</a>.
</span>
<div class="form">
<table>
<form name="login_form" action="index.php?c=login&p=main" method="post"> 
<tr>
<td class="white_table"><label for="username" class='label'>Username:<span class="required"> *</span></label></td>
<td class="white_table"><input type="text" name="username" id="username" value="<?php echo htmlentities(Input::get('username'))?>" autofocus required="required" autocomplete="on" maxlength="30" /></td>
</tr>
<tr>
<td class="white_table"><label for="password" class='label'>Password:<span class="required"> *</span></label></td>
<td class="white_table"><input type="password" name="password" id="password" value="<?php //echo htmlentities(Input::get('password'))?>" maxlength="30" required="required"/></td>
</tr>
<tr>
<td class="white_table"></td>
<td class="white_table"><a onClick="return toggleMenu('menu1')">Forgot username</a></td>
</tr>
<tr>
<td class="white_table"></td>
<td class="white_table"><input class="submit button" type="submit" name="submit" value="Submit" /></td>
</tr>
</form>
</table>
<a href="index.php?c=users&p=users&add=true">Register<!-- Register --></a>
</div>
<span class='menu' id='menu1'>
<div class="form2" style="width: 800px; clear:both">
<span class='notification'>If you have forgotten your username, enter your registration number below and you will be remainded in green text above the login form. If the system does not have a record of you, <a href="index.php?c=users&p=users&add=true">Register<!--register--></a>!</span>
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
</span>
<div style="width: 830px; float: left; margin-right: 5%; clear:both; border: 0px solid #666;">
<table class="results">
<tr>
<th>Course Units</th>
<th>Credit Units</th>
<th>Semester</th>
<th>Year</th>
<th>&nbsp;</th>
<th>&nbsp;</th>
</tr>
<?php
$i = 1;
foreach($course_units as $course_unit) { ?>
<tr>
<td><a href="index.php?c=course_unit&p=course_unit&course_unit_id=<?php echo urlencode(base64_encode($course_unit->id));?>"><?php echo (isset($course_unit->code)) ? strtoupper($course_unit->code).": " : "" ; ?><?php echo titleCase($course_unit->name); ?></a></td>
<?php if($session->is_admin()) :?>
<td><?php echo $course_unit->credit_unit; ?></td>
<td><?php echo $course_unit->semester; ?></td>
<td><?php echo $course_unit->year; ?></td>
<td><a href="index.php?c=course_unit&p=course_units&edit=true&course_unit_id=<?php echo urlencode(base64_encode($course_unit->id))?>">Edit</a></td>
<td><a href="index.php?c=csv_download&p=course_units&download=true&course_unit_id=<?php echo urlencode(base64_encode($course_unit->id));?>">Download</a></td>
<?php endif ?>
</tr>
<?php }?>
</table>
<?php if($session->is_admin()) :?>
    <div><a href='index.php?c=course_unit&p=course_units&add=true'>Add Course Units</a></div>
<?php endif?>
</div>
<p></p>
<div id="pagination" style="clear:both; text-align:center;">
<?php bottom_pagination("index.php?p=course_units");?>
</div>
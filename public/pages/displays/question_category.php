<?php $question_categorys = Question_category::find_all();?>
<div>
<table class="results">
<tr>
<th></th>
<th>Question Category</th>
<th>&nbsp;</th>
</tr>
<?php //foreach($users as $user) : 
$i = 1;
foreach($question_categorys as $question_category) : ?>
<?php
//$user = User::find_by_id($title->head);
?>
<tr>
<td><?php echo $i++; ?></td>
<!--<td><img src="../<?php //echo $photo->image_path();?>" width="100" /></td>-->
<td><?php echo titleCase($question_category->name); ?></td>

<td>
<?php if($session->is_admin()) :?>
<a href="index.php?c=question_category&p=question_category&edit=true&question_category_id=<?php echo urlencode(base64_encode($question_category->id));?>">Edit</a>
<?php endif ?>
</td>
<!--<td><a href="delete_title.php?id=<?php echo urlencode(base64_encode($question_category->id));?>">Delete</a></td>-->
</tr>
<?php endforeach;?>
</table>
<?php if($session->is_admin()) :?>
    <div><p><a href='index.php?c=question_category&p=question_category&add=true'>Add Question category</a></div>
	<?php endif?>
</div>
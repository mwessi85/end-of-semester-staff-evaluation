<?php 
$sql = "SELECT DISTINCT(question_id), question, lecturer FROM question_answers WHERE lecturer_id = ".$user->id;
$result = $database->query($sql);
if (isset($result)) {
	$allResults = $result->fetchAll(PDO::FETCH_ASSOC);
	if ($allResults) {
		foreach ($allResults as $row) {
		?>
        <?php //echo 'question_'.$row['question_id']?>
		<script type='text/javascript'>
		  window.onload = function () {
			var chart = new CanvasJS.Chart('<?php echo 'question_'.$row['question_id']?>',
			{
				title:{
					text: '<?php echo $row['question']?>',
					fontFamily: 'Impact',
					fontWeight: 'normal'
				},
		
				legend:{
					verticalAlign: 'bottom',
					horizontalAlign: 'center'
				},
				data: [
				{
					//startAngle: 45,
					indexLabelFontSize: 20,
					indexLabelFontFamily: 'Garamond',
					indexLabelFontColor: 'darkgrey',
					indexLabelLineColor: 'darkgrey',
					indexLabelPlacement: 'outside',
					type: 'doughnut',
					showInLegend: true,
					dataPoints: [
	<?php
		//echo "<pre>".print_r($allResults, true)."</pre>"; 
			$query = 'SELECT COUNT(answer_id) count, answer, question FROM question_answers WHERE question_id = '.$row['question_id'].' AND lecturer_id = '.$user->id.' GROUP BY answer';
			
			$result2 = $database->query($query);
			$allResults2 = $result2->fetchAll(PDO::FETCH_ASSOC);
			$query = "SELECT SUM(answer_id) count, answer, question FROM question_answers WHERE question_id = ".$row['question_id']." AND lecturer_id = ".$user->id." GROUP BY answer";
			$query3 = "SELECT SUM(count) FROM (SELECT SUM(answer_id) count, answer, question FROM question_answers WHERE question_id = ".$row['question_id']." AND lecturer_id = ".$user->id." GROUP BY answer)src";
			$result3 = $database->query($query3);
			$sum_results = $result3->fetchColumn();
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
					echo "{  y: ".$value_count.", legendText:'".$value."', indexLabel: '".$percentage."%' },\n";
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
		<?php
	}
	}
}
?>



<!--<script type="text/javascript">
  window.onload = function () {
	var chart = new CanvasJS.Chart("chartContainer",
	{
		title:{
			text: "U.S Smartphone OS Market Share, Q3 2012",
			fontFamily: "Impact",
			fontWeight: "normal"
		},

		legend:{
			verticalAlign: "bottom",
			horizontalAlign: "center"
		},
		data: [
		{
			//startAngle: 45,
			indexLabelFontSize: 20,
			indexLabelFontFamily: "Garamond",
			indexLabelFontColor: "darkgrey",
			indexLabelLineColor: "darkgrey",
			indexLabelPlacement: "outside",
			type: "doughnut",
			showInLegend: true,
			dataPoints: [
				{  y: 53.37, legendText:"Android 53%", indexLabel: "Android 53%" },
				{  y: 35.0, legendText:"iOS 35%", indexLabel: "Apple iOS 35%" },
				{  y: 7, legendText:"Blackberry 7%", indexLabel: "Blackberry 7%" },
				{  y: 2, legendText:"Windows 2%", indexLabel: "Windows Phone 2%" },
				{  y: 5, legendText:"Others 5%", indexLabel: "Others 5%" }
			]
		}
		]
	});

	chart.render();
}
  </script>-->
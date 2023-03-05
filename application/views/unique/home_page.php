<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm">
			Home
			<?php echo $stats['global']['eco'];?>
		</div>	
		<div class="col-sm">
			<canvas id="canvas_min"></canvas>
		</div>
	</div>
</div>	

<script>
	var barChartData = {
		labels : ["<?php echo implode('","', $stats['dates']);?>"],
		datasets : [
		<?php
		foreach($stats['line'] AS $label=>$datas){
			echo '
			{
				label: \''.$label.'\',
				backgroundColor: "'.$stats['color'][$label].'",
				borderColor: "'.$stats['color'][$label].'",
				borderWidth: 1,
				data : ['.implode(",",$datas).']
			},';
		}
		?>
		],
		options: {
			legend: {
				display: true,
				labels: {
					fontColor: 'rgb(255, 99, 132)'
				}
			}
        }
	};

	window.onload = function() {
		var ctx = document.getElementById('canvas_min').getContext('2d');
		window.myBar = new Chart(ctx, {
			type: 'bar',
			data: barChartData,
			options: {
				responsive: true,
				legend: {
					position: 'top',
				},
				title: {
					display: true,
					text: 'Différence E85 / SP98 '
				}
			}
		});
	};	

	
</script>
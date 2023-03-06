<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm">
			<h3><?php echo Lang('Title_cost');?></h3>
			<table class="table">
				<thead>
					<tr>
						<th><?php echo Lang('Cost_Total');?></th>
						<th><?php echo Lang('Cost_perkm');?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?php echo $stats['global']['spend'];?></td>
						<td><?php echo $stats['global']['perkm'];?></td>
					</tr>
				</tbody>
			</table>
			<h3><?php echo Lang('Title_E85');?></h3>
			<table class="table">
				<thead>
					<tr>
						<th><?php echo Lang('eco');?></th>
						<th><?php echo Lang('');?></th>
						<th><?php echo Lang('');?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?php echo $stats['global']['eco'];?></td>
					</tr>
				</tbody>
			</table>						
			<h3><?php echo Lang('Title_conso');?></h3>
			<table class="table">
				<thead>
					<tr>
						<th><?php echo Lang('Conso_moy');?></th>
						<th><?php echo Lang('Conso_min');?></th>
						<th><?php echo Lang('Conso_max');?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?php echo $stats['global']['conso_moy'];?></td>
						<td><?php echo $stats['global']['conso_min'];?></td>
						<td><?php echo $stats['global']['conso_max'];?></td>
					</tr>
				</tbody>
			</table>
			<?php //echo debug($stats);?>
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
		//backgroundColor: "'.$stats['color'][$label].'",
		foreach($stats['line'] AS $label=>$datas){
			echo '
			{
				label: \''.Lang('Title_graph_'.$label).'\',
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
			type: 'line',
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
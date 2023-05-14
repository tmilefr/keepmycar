<div class="container-fluid">
	<table class="table table-striped table-sm">
	  <thead>
		<tr>			
			<th scope="col" class="col-sm-2 col-md-1 col-xl-1">&nbsp;</th>
			<?php
			foreach($this->{$_model_name}->_get('defs') AS $field=>$defs){
				if ($defs->list === true){
					echo '<th class="'.((isset($defs->class)) ? $defs->class:"").'" scope="col">'.$this->render_object->render_link($field).'</a></th>';
				}
			}
			?>

		  </tr>
	  </thead>
	  <tbody>
	<?php 
	foreach($datas AS $key => $data){
		echo '<tr>';
		echo '<td class="col-sm-2 col-md-1 col-xl-1">';
			echo $this->render_object->render_element_menu($data);
		echo '</td>';	

		foreach($this->{$_model_name}->_get('defs') AS $field=>$defs){
			if ($defs->list === true){
				echo '<td class="'.((isset($defs->class)) ? $defs->class:"").'">'.$this->render_object->RenderElement($field, $data->{$field}, $data->id).'</td>';
			}
		}
		echo '</tr>';
	}
	?>
	</tbody>
	</table>
</div>



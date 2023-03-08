<div class="container-fluid">
	<div class="card">
	  <div class="card-header">
		<?php echo $this->render_object->RenderElement('date').' '.$stats->km.' Km' ;?>
	  </div>
	  <div class="card-body">
		<h5 class="card-title">
			<?php echo $this->render_object->RenderElement('liter');?> L /
			<?php echo $this->render_object->RenderElement('billed');?> € / 
			<?php echo $this->render_object->RenderElement('e85');?> € / L
		</h5>
		<p class="card-text">
			<?php 
				echo $stats->conso.' L / 100'; 
			?>
		</p>
		<?php
			echo $this->render_object->render_element_menu();
		?>
	  </div>
	</div>	
</div>

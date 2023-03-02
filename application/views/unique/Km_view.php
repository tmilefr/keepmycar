<div class="container-fluid">
	<div class="card">
	  <div class="card-header">
		<?php echo $this->render_object->RenderElement('date').' '.$this->render_object->RenderElement('km');?>
	  </div>
	  <div class="card-body">
		<h5 class="card-title">
			<?php echo $this->render_object->RenderElement('liter');?> L /
			<?php echo $this->render_object->RenderElement('billed');?> €
		</h5>
		<p class="card-text">
			<?php 
				echo $this->bootstrap_tools->label('e85').' : '.$this->render_object->RenderElement('e85').'<br/>';
				echo $this->bootstrap_tools->label('sp98').' : '.$this->render_object->RenderElement('sp98').'<br/>'; 
 
			?>
		</p>
		<?php
			echo $this->render_object->render_element_menu();
		?>
	  </div>
	</div>	
</div>

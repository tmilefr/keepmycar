<div class="container-fluid">
	<div class="card">
	  <div class="card-header">
		<?php echo $this->render_object->RenderElement('name').' '.$this->render_object->RenderElement('model');?> / <?php echo $this->render_object->RenderElement('year');?>
	  </div>
	  <div class="card-body">
		<h5 class="card-title">
			<?php 
				echo $this->render_object->RenderElement('registration'); 
			?>
		</h5>
		<p class="card-text">
			<?php 
				echo $this->bootstrap_tools->label('power').' : '.$this->render_object->RenderElement('power').'<br/>'; 
				echo $this->bootstrap_tools->label('consume').' : '.$this->render_object->RenderElement('consume').'<br/>'; 
			?>
		</p>
		<?php
			echo $this->render_object->render_element_menu();
		?>
	  </div>
	</div>	
</div>

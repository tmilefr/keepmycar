<div class="container-fluid">
	<div class="card">
	  <div class="card-header">
		<?php echo $this->render_object->RenderElement('date').' '.$this->render_object->RenderElement('km');?> / <?php echo $this->render_object->RenderElement('id_equ');?>
	  </div>
	  <div class="card-body">
		<h5 class="card-title">
			<?php 
				echo $this->render_object->RenderElement('type'); 
			?>
		</h5>
		<p class="card-text">
			<?php 
				echo $this->bootstrap_tools->label('billed').' : '.$this->render_object->RenderElement('billed').'<br/>'; 
				echo $this->bootstrap_tools->label('object').' : '.$this->render_object->RenderElement('object').'<br/>'; 
				echo $this->bootstrap_tools->label('object').' : '.$this->render_object->RenderElement('object').'<br/>'; 
			?>
		</p>
		<?php
			echo $this->render_object->render_element_menu();
		?>
	  </div>
	</div>	
</div>

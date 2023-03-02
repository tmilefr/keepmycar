<div class="container-fluid">
	<div class="card">
	  <div class="card-header">
		<?php echo $this->render_object->RenderElement('name').' '.$this->render_object->RenderElement('surname');?> / <?php echo $this->render_object->RenderElement('family');?>
	  </div>
	  <div class="card-body">
		<h5 class="card-title">
			<?php 
				echo $this->render_object->RenderElement('email'); 
			?>
		</h5>
		<p class="card-text">
			<?php 
				echo $this->bootstrap_tools->label('section').' : '.$this->render_object->RenderElement('section').'<br/>'; 
			?>
		</p>
		<?php
			echo $this->render_object->render_element_menu();
		?>
	  </div>
	</div>	
</div>

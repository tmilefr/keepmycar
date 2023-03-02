<div class="container-fluid">
	<div class="card">
	  <div class="card-header">
	  	<span class="card-title"><?php echo $this->render_object->RenderElement('login')?></span>
	  </div>
	  <div class="card-body">
		<h5 class="card-title">
			<?php 
				echo $this->render_object->RenderElement('role_id'); 
			?>
		</h5>
		<p class="card-text">
			
		</p>		
		<?php
			echo $this->render_object->render_element_menu();
		?>
	  </div>
	</div>	
</div>


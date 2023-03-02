<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
			<!-- footer bar -->
			<nav class="navbar navbar-expand-lg navbar-light bg-light"> 
				<ul class="navbar-nav mr-auto"> 
					<li class="nav-item">
					<?php echo ((isset($this->pagination)) ? $this->pagination->create_links():'');?>
					</li>
					<li class="nav-item">
						
					</li>
					<?php /* //TODO : perpage<li class="nav-item">
						<?php echo ((isset($this->pagination)) ? $this->pagination->create_perpage():'');?>
					</li> */ ?>
					<li class="nav-item">
					<?php echo $footer_line;?>
					</li> 
				</ul>
				<span class="navbar-text">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></span>
			</nav>

			<?php //echo $this->_render_debug(); ?>

		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="AboutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel"><?php echo $this->config->item('app_name');?></h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<?php echo $this->config->item('about');?>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo Lang('Close');?></button>
		  </div>
		</div>
	  </div>
	</div>
	
	<!- modal tools for delete ->
	<div id="confirmModal" class="modal" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title"><?php echo Lang('DELETE_CONFIRMATION');?></h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<p><?php echo Lang('TXT_DELETE_CONFIRMATION');?></p>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-success" data-dismiss="modal"><?php echo Lang('CANCEL');?></button>
			<button type="button" class="btn btn-danger" id="confirmModalYes"><?php echo Lang('YES');?></button>
		  </div>
		</div>
	  </div>
	</div>	
	
	<!-- Optional JavaScript -->
	<?php $this->bootstrap_tools->RenderAttachFiles('js');?>
  </body>
</html>

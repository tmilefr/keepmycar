<div class="container-fluid">
	<?php
	echo form_open($this->render_object->_getCi('_controller_name').'/'.$this->render_object->_get('form_mod').'/'.$id, array('class' => '', 'id' => 'edit') , array('form_mod'=>$this->render_object->_get('form_mod'),'id'=>$id) );
	//champ obligatoire
	foreach($required_field AS $name){
		echo form_error($name, 	'<div class="alert alert-danger">', '</div>');
	}
	?>
	<div class="card" >
		<div class="card-header">
			<?php echo $this->lang->line($this->render_object->_getCi('_controller_name').'_'.$this->render_object->_get('form_mod'));?>
		</div>	
		<div class="card-body">
			<div class="form-row">
				<div class="form-group col-md-4">
					<?php 
						echo $this->bootstrap_tools->label('date');
						echo $this->render_object->RenderFormElement('date'); 
					?>
				</div>
				<div class="form-group col-md-4">
				<?php 
						echo $this->bootstrap_tools->label('km');
						echo $this->render_object->RenderFormElement('km');
					?>
				</div>
				<div class="form-group col-md-4">
					<?php 
						echo $this->bootstrap_tools->label('id_equ');
						echo $this->render_object->RenderFormElement('id_equ');
					?>
				</div>
			</div>
			<div class="form-row">
			<div class="form-group col-md-4">
					<?php 
						echo $this->bootstrap_tools->label('type');
						echo $this->render_object->RenderFormElement('type');
					?>
				</div>				
				<div class="form-group col-md-8">
					<?php 
						echo $this->bootstrap_tools->label('object');
						echo $this->render_object->RenderFormElement('object');
					?>			
				</div>
				<div class="form-group col-md-4">
					<?php 
						echo $this->bootstrap_tools->label('billed');
						echo $this->render_object->RenderFormElement('billed');
					?>
				</div>				
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary"><?php echo $this->render_object->_get('_ui_rules')[$this->render_object->_get('form_mod')]->name;?></button>
		</div>
	</div>
<?php
echo $this->render_object->RenderFormElement('created'); 
echo $this->render_object->RenderFormElement('updated'); 
echo form_close();
?>
</div>

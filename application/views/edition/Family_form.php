<div class="container-fluid">
	<?php
	echo form_open($this->render_object->_getCi('_controller_name').'/'.$this->render_object->_get('form_mod'), array('class' => '', 'id' => 'edit') , array('form_mod'=>$this->render_object->_get('form_mod'),'id'=>$id) );
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
	<div class="form-group col-md-6">
		<?php 
			echo $this->bootstrap_tools->label('name');
			echo $this->render_object->RenderFormElement('name'); 
		?>
	</div>
	<div class="form-group col-md-6">
		<?php 
			echo $this->bootstrap_tools->label('adress');
			echo $this->render_object->RenderFormElement('adress');
		?>
	</div>
</div>
<div class="form-row">
	<div class="form-group col-md-6">
		<?php 
			echo $this->bootstrap_tools->label('postalcode');
			echo $this->render_object->RenderFormElement('postalcode');
		?>
	</div>
	<div class="form-group col-md-6">
		<?php 
			echo $this->bootstrap_tools->label('town');
			echo $this->render_object->RenderFormElement('town'); 
		?>
	</div>
</div>
<div class="form-row">
	<div class="form-group col-md-6">
		<?php 
			echo $this->bootstrap_tools->label('country');
			echo $this->render_object->RenderFormElement('country'); 
		?>
	</div>
</div>
<button type="submit" class="btn btn-primary"><?php echo $this->render_object->_get('_ui_rules')[$this->render_object->_get('form_mod')]->name;?></button>
<?php
echo $this->render_object->RenderFormElement('created'); 
echo $this->render_object->RenderFormElement('updated'); 
echo form_close();
?>
</div>

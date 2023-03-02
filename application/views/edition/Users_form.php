<div class="container-fluid">

<?php
echo form_open('Users_controller/'.$this->render_object->_get('form_mod'), array('class' => '', 'id' => 'edit') , array('form_mod'=>$this->render_object->_get('form_mod'),'id'=>$id) );

//champ obligatoire
foreach($required_field AS $name){
	echo form_error($name, 	'<div class="alert alert-danger">', '</div>');
}
?>
<div class="form-row">
	<div class="form-group col-md-4">
		<?php 
			echo $this->bootstrap_tools->label('name');
			echo $this->render_object->RenderFormElement('name'); 
		?>
	</div>
	<div class="form-group col-md-4">
		<?php 
			echo $this->bootstrap_tools->label('surname');
			echo $this->render_object->RenderFormElement('surname');
		?>
	</div>
	<div class="form-group col-md-4">
		<?php 
			echo $this->bootstrap_tools->label('family');
			echo $this->render_object->RenderFormElement('family');
		?>
	</div>
</div>
<div class="form-row">
	<div class="form-group col-md-6">
		<?php 
			echo $this->bootstrap_tools->label('email');
			echo $this->render_object->RenderFormElement('email');
		?>
	</div>
	<div class="form-group col-md-6">
		<?php 
			echo $this->bootstrap_tools->label('password');
			echo $this->render_object->RenderFormElement('password'); 
		?>
	</div>
</div>
<div class="form-row">
	<div class="form-group col-md-6">
		<?php 
			echo $this->bootstrap_tools->label('section');
			echo $this->render_object->RenderFormElement('section'); 
		?>
	</div>
</div>
<div class="modal-footer">
<button type="submit" class="btn btn-primary"><?php echo $this->render_object->_get('_ui_rules')[$this->render_object->_get('form_mod')]->name;?></button>
</div>
<?php
echo $this->render_object->RenderFormElement('created'); 
echo $this->render_object->RenderFormElement('updated'); 
echo form_close();
?>
</div>

<?php
echo form_open('Parameters/edit', array('class' => '', 'id' => 'edit') , array('form_mod'=>'','id'=>'') );

$bloc = '';
		foreach($this->Parameters_model->_get('defs') AS $field => $def){
		 if ($def->bloc != $bloc){
			if ($bloc != ''){
				 echo '</div></div><br/>';
			}
			echo '<div class="card"><div class="card-header">'.$def->bloc.'</div><div class="card-body">';
			$bloc = $def->bloc;
		 }

		?>
		<div class="form-row">
			 <div class="col">
				<?php 
					echo form_error($field , 	'<div class="alert alert-danger">', '</div>');
					echo $this->render_object->label($field);
					echo $this->render_object->RenderFormElement($field); 
				?>
			</div>
		</div>
		<?php } ?>
		<br/>
		<div class="form-row">
			<div class="col">
				<button type="submit" class="btn btn-primary"><?php echo Lang('valid');?></button>
			</div>
		</div>
	</div>
</div>
	
<?php
echo form_close();
?>


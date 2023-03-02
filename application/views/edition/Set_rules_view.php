<div class="card" >
	<div class="card-header">
		<?php echo $this->lang->line('Acl_roles_controller_rules');?>
	</div>
	<div class="card-body">
		<?php 
		echo form_open('Acl_roles_controller/set_rules/'.$id, array('class' => '', 'id' => 'edit') , array('form_mod'=>'roles','id'=>$id) );
		?>
		<table class="table table-striped table-sm">
		<thead>
			<tr>			
				<th scope="col">&nbsp;</th>
				<th scope="col"><?php echo $this->lang->line('controller');?></th>
				<th scope="col"><?php echo $this->lang->line('actions');?></th>
			</tr>
		</thead>
		<tbody>
		<?php 
		foreach($ctrls AS $key => $ctrl){
			echo '<tr>';
			echo '<td>';
				
			echo '</td>';	
			echo '<td>'.$ctrl->controller.'</td>';
			echo '<td><table>';
			foreach($ctrl->actions AS $action){ 
				?>
				<td>
				<div class="custom-control custom-switch form-check-inline">
					<input type="checkbox" <?php echo (($action->allow ) ? 'checked="checked"':'');?> class="custom-control-input" name="rules[]" id="customSwitch<?php echo $ctrl->id.'_'.$action->id;?>" value="<?php echo $ctrl->id.'_'.$action->id;?>">
					<label class="custom-control-label" for="customSwitch<?php echo $ctrl->id.'_'.$action->id;?>"><?php echo $action->action;?></label>
				</div>
				</td>
			<?php 
				
			}
			echo '</tr></table></td>';
			echo '</tr>';
		}
		?>
		</tbody>
		</table>
		<div class="modal-footer">
		<button type="submit" class="btn btn-primary"><?php echo $this->lang->line('VALIDER');?></button>
		</div>
		<?php
			echo form_close();
		?>
	</div>
</div>



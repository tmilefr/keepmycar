<?php
/*
 * element_password.php
 * PASSWORD Object in page
 * 
 */
require_once(APPPATH.'libraries/elements/element.php');

class element_password extends element
{
	public function __construct(){
		parent::__construct();
		if (isset($this->CI->bootstrap_tools))
		{
			$this->CI->bootstrap_tools->_SetHead('assets/js/togglefield.js','js');
		}
	}
	
	public function RenderFormElement(){ 
		
		if ($this->disabled)
			$txt = '<input type="hidden" name="'.$this->name.'" value="'.$this->value.'"><input class="form-control" type="text" value="********" readonly>';
		else {
			//en edition, le mot de passe est déjà crypt ... en relation avec le js togglefield
			$txt = $this->CI->bootstrap_tools->password_text($this->name, $this->CI->lang->line($this->name) , $this->value, 'readonly');
			$txt .= '<div class="form-check">
						<input class="form-check-input togglefield" data-toggle="input'.$this->name.'" type="checkbox" name="'.$this->name.'_check" id="'.$this->name.'_check" value="change_password">
						<label class="form-check-label" for="'.$this->name.'_check">
						'.$this->CI->lang->line(''.$this->name.'_change').'
						</label>
					</div>';
		}
		return $txt;
	}
	
	public function Render(){
		return '********';
	}

	public function PrepareForDBA($value){
		//en edition, le mot de passe est déjà crypt ...
		if($this->CI->input->post($this->name.'_check') == "change_password"){
			return crypt($value, PASSWORD_SALT);
		} else {
			return $value;
		}		
	}
}


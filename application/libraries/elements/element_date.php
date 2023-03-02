<?php
/*
 * element_date.php
 * Date Object in page
 * 
 */
require_once(APPPATH.'libraries/elements/element.php');

class element_date extends element
{	
	
	public function __construct(){
		parent::__construct();
		if (isset($this->CI->bootstrap_tools))
		{
			$this->CI->bootstrap_tools->_SetHead('assets/plugins/js/bootstrap-datepicker.js','js');
			$this->CI->bootstrap_tools->_SetHead('assets/plugins/js/locales/bootstrap-datepicker.fr.js','js');
			$this->CI->bootstrap_tools->_SetHead('assets/plugins/css/datepicker.css','css');		
		}
	}
	
	public function RenderFormElement(){
		return $this->CI->bootstrap_tools->input_date($this->name,$this->value,$this->datatarget);
	}
	
	public function Render(){
		return GetFormatDate($this->value);
	}
}


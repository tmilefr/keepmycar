<?php
/*
 * element_date.php
 * Date Object in page
 * 
 */
require_once(APPPATH.'libraries/elements/element.php');

class element_time extends element
{	
	

	public function __construct(){
		parent::__construct();
		if (isset($this->CI->bootstrap_tools))
		{
			$this->CI->bootstrap_tools->_SetHead('assets/vendor/jquery-timepicker/jquery.timepicker.js','js');
			$this->CI->bootstrap_tools->_SetHead('assets/vendor/jquery-timepicker/jquery.timepicker.css','css');		
		}
	}

	public function RenderFormElement(){
		$js = "<script>
			$('#input".$this->GetName()."').timepicker({
				timeFormat: 'HH:mm:ss',
				minTime: '".$this->minTime."',
				maxHour: ".$this->maxHour.",
				maxMinutes: ".$this->maxMinutes.",
				startTime: new Date(0,0,0,".$this->startTime.",0,0),
				interval: 15".(($this->change) ? ",change: ".$this->change.",":"")."
			});
		</script>";

		$this->CI->bootstrap_tools->_SetHead($js , 'txt');		
		return $this->CI->bootstrap_tools->input_time($this->GetName(),$this->value,$this->datatarget);
	}

}


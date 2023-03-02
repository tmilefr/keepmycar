<?php
/*
 * element_checkbox.php
 * CHECKBOX Object in page
 * 
 */
require_once(APPPATH.'libraries/elements/element.php');

class element_typeahead extends element
{	
	protected $query = null;
	protected $id_key = null;
	protected $data_key = null;
	protected $json_data_key = null;
	protected $json_url = null;
	protected $alternate_field = null;

	public function __construct(){
		parent::__construct();
		if (isset($this->CI->bootstrap_tools))
		{
			$this->CI->bootstrap_tools->_SetHead('assets/plugins/js/bootstrap3-typeahead.js','js');
			$this->CI->bootstrap_tools->_SetHead('assets/js/ahead.js','js');
		}
		//$this->_debug = TRUE;
	}
	
	public function RenderFormElement(){
		$clean_name = str_replace(['[',']'],['',''],$this->name);
		return '<input data-dst="input'.$clean_name.$this->parent_id.'" name="ta'.$this->name.'" id="ta'.$clean_name.'" data-source="'.base_url().$this->CI->_get('_controller_name').'/JsonData/'.(($this->json_url) ? $this->json_url:$clean_name).'"  autocomplete="off" class="typeahead form-control" value="'.((isset($this->values[$this->value])) ? $this->values[$this->value] : '').'" placeholder="'.$this->CI->lang->line('help_'.$this->name).'"><input type="hidden" id="input'.$clean_name.$this->parent_id.'" name="'.$this->name.'" value="'.$this->value.'">';
	}
	
	/** @return string  */
	public function JsonData(){
		$json = ' ';
		if ($this->query){
			$datas = $this->CI->db->query($this->query)->result();
			foreach($datas AS $key=>$data){
				$value = $data->{$this->json_data_key};
				if (!$value && $this->alternate_field)
					$value = $data->{$this->alternate_field};				
				$json.= '{"id":"'.$data->{$this->id_key}.'", "label":"'.$value.'"},';
			}
		}
		return  substr($json,0,-1);
	}

	public function SetValues(){
		if ($this->query){
			$datas = $this->CI->db->query($this->query)->result();
			foreach($datas AS $key=>$data){
				$value = $data->{$this->data_key};
				if (!$value && $this->alternate_field)
					$value = $data->{$this->alternate_field};

				$this->values[$data->{$this->id_key}] = $value;
			}
		}
	}

	public function Render(){
		return ((isset($this->values[$this->value])) ? $this->values[$this->value] : $this->CI->lang->line('NOT_FOUND'));
	}
}


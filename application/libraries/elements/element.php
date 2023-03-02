<?php
/*
 * element.php
 * Object in page
 * 
 */

class element
{
	protected $mode; //view, form.
	protected $name   	= null; //unique id ?
	protected $value  	= null;
	protected $values 	= [];
	protected $type 	= '';
	protected $mutliple	= FALSE;
	protected $parent_id= 0;
	protected $disabled = false;
	protected $label = false;
	protected $_debug = false;
	protected $param = '';
	protected $overridename = '';
	protected $datatarget = '';
	protected $change = '';
	
	public function SetMultiple($action = 'FALSE'){
		$this->name = str_replace(['[',']'],['',''], $this->name);
		$this->mutliple = $action;
		if ($this->mutliple)
			$this->name .= '[]';
	}

	public function set_name($name){ //?
		$this->name = str_replace($name,'', $this->name);
		$this->name .= $name;
	}


	/** @return mixed  */
	public function GetName(){
		return (($this->overridename) ? $this->overridename:$this->name);
	}

	//todo use GetName everywhere nl 26/09/2022
	public function RenderFormElement(){
		if ($this->disabled)
			$txt = '<input type="hidden" name="'.$this->GetName().'" value="'.$this->value.'"><input class="form-control" type="text" value="'.$this->Render().'" readonly>';
		else
			$txt = $this->CI->bootstrap_tools->input_text( $this->GetName() , $this->CI->lang->line($this->name) , $this->value, $this->label, $this->datatarget);
		return $txt;
	}
	
	public function Render(){
		return $this->value;
	}

	public function SetValues(){
		$data = array(); //passage de l'objet en tableau.
		if (isset($this->values) && $this->values && !is_string($this->values)){
			foreach($this->values AS $key=>$value){
				$data[$key] = $value;
			}
		}
		$this->values = $data;
	}

	/** @return stdClass  */
	public function SetParams(){
		$op_mg = new stdClass();
		preg_match('/(\w+)\((\w+)\,(\w+)\:(.*)\)/', $this->param, $param);
		//echo debug($param);
		if (count($param)){
			$op_mg->param = $this->param;
			$op_mg->method 	= $param[1];
			$op_mg->table 	= $param[2];
			$op_mg->id 		= $param[3];
			switch(TRUE){
				case strpos($param[4],'|'): //cas ?
					$op_mg->choice = explode('|', $param[4]);
					$op_mg->value = $param[4] = str_replace("|","@", $param[4] );
				break;
				case strpos($param[4],'#')://cas distinct(options,cle:value#filter=classif)
					$filter = explode('#', $param[4]);
					$op_mg->value = $param[4] = $filter[0];								
					$filtre = explode("=",$filter[1]);
					$op_mg->filter_field =  $filtre[0];
					$op_mg->filter_value =  $filtre[1];
				break;
				default: //cas distinct(famille,id:login)
					$op_mg->value = $param[4];
			}
			if (strpos($param[4],'@')){
				$param[4] = str_replace('@','_',$param[4]);
			}
			$op_mg->key = $param[3];
			$op_mg->data = $param[4];
		}
		return $op_mg;
	}

	/**
	 * Constructor of class element.
	 * @return void
	 */
	public function __construct()
	{
		$this->CI =& get_instance();
	}

	/**
	 * Destructor of class element.
	 * @return void
	 */
	public function __destruct()
	{
		unset($this->CI);
		if ($this->_debug)
			echo '<pre><code>'.print_r($this , 1).'</code></pre>';
	}
	
	/**
	 * Generic set
	 * @return void
	 */
	public function _set($field,$value){
		$this->$field = $value;
	}

	/**
	 * @param mixed $field 
	 * @return mixed 
	 */
	public function _get($field){
		if (isset($this->$field))
			return $this->$field;
		else
			return false;
	}

}


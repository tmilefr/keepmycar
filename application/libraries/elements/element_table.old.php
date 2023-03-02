<?php
/*
 * element.php
 * Object in page
 * 
 */

class element_table extends element
{
	protected $mode; //view, form.
	protected $name   	= null; //unique id ?
	protected $value  	= null;
	protected $values 	= [];
	protected $type 	= '';
	protected $model 	= '';
	protected $foreignkey = '';

	public function __construct(){
		parent::__construct();
		if (isset($this->CI->bootstrap_tools))
		{
			$this->CI->bootstrap_tools->_SetHead('assets/js/dynamic_row.js','js');
		}
		$this->CI->load->model($this->model);
	}	

	public function PrepareForDBA($value){
		$obj = [];
		//return json_encode($obj);
		$id = $this->CI->render_object->_get('id');
		if ($id){
			$fields = array_keys($this->CI->{$this->model}->_get('defs'));
			
			if (method_exists($this->CI->{$this->model},'DeleteLink'))
				$this->CI->{$this->model}->DeleteLink($id);
			foreach( $this->CI->input->post($fields[1]) AS $key=>$ref){
				if ($ref != '...'){
					$lgn = new Stdclass();
					foreach($fields AS $key => $field){
						switch($field){
							case 'id':

							break;
							case 'created':
								$lgn->created = date('Y-m-d H:i:s');
							break;
							case $fields[1]:
								$lgn->{$fields[1]} = $ref;
							break;
							default:
								if ($field == $this->foreignkey){
									$lgn->$field = $id;
								} else {
									$lgn->$field = $this->CI->input->post($field);
								}
							break;
						}
					}
					$this->CI->{$this->model}->post($lgn);
					$obj[] = $lgn;
				}
			}
		}	
		return json_encode($obj);
	}

	public function RenderFormElement(){
		//return $this->CI->bootstrap_tools->input_text($this->name, $this->CI->lang->line($this->name) , $this->value);
		$id = $this->CI->render_object->_get('id');
	
		$table = '<div class="Dynamic_row">';

		$this->CI->{$this->model}->_set('filter', [$this->foreignkey => $id ]);
		$this->CI->{$this->model}->_set('order', $this->foreignkey);
		$datas = $this->CI->{$this->model}->get_all();
		if (count($datas)){
			foreach($datas AS $key => $data){
				
				$table .= '<div class="input-group mb-3">';
				foreach($this->CI->{$this->model}->_get('defs') AS $field=>$defs){
					
					if ($defs->list === true){
						switch($defs->type){
							case 'select':
							case 'select_database':
								$table .= $this->CI->bootstrap_tools->input_select($field.'[]', $defs->values, $data->{$field}); //'<select type="text" name="'.$field.'[]" class="form-control m-input" value="'.$value.'" placeholder="'.$field.'" autocomplete="off">';
							break;
							default:
								$table .= '<input type="text" name="'.$field.'[]" class="form-control m-input" value="'.$data->{$field}.'" placeholder="'.$field.'" autocomplete="off">';
						}
						
					} else {
						if ($field == 'id'){
							$table .= '<input type="hidden" id="id_table" name="id_table[]" value="'.$data->id.'">';
						}
					}				
				}
				$table .= '<div class="input-group-append"><button id="removeRow'.$data->id.'" type="button" class="removeRow btn btn-danger">Remove</button></div></div>';
			}
		}
		$table .= '<div class="d-none" id="model"><div class="input-group mb-3">';
		foreach($this->CI->{$this->model}->_get('defs') AS $field=>$defs){
			if ($defs->list === true){
				switch($defs->type){
					case 'select':
					case 'select_database':
						$table .= $this->CI->bootstrap_tools->input_select($field.'[]', $defs->values, ''); //'<select type="text" name="'.$field.'[]" class="form-control m-input" value="'.$value.'" placeholder="'.$field.'" autocomplete="off">';
					break;
					default:
						$table .= '<input type="text" name="'.$field.'[]" class="form-control m-input" value="" placeholder="'.$field.'" autocomplete="off">';
				}
			}				
		}
		$table .= '<div class="input-group-append"><button id="removeRow" type="button" class="removeRow btn btn-danger">Remove</button></div></div></div>';
		$table .= '</div><button id="addRow" type="button" class="btn btn-info">Add Row</button><textarea class="d-none" id="input'.$this->name.'" name="'.$this->name.'">'.$this->value.'</textarea>';
		return $table;

	}
	
	public function Render(){
		return $this->value;
	}

	/**
	 * Destructor of class element.
	 * @return void
	 */
	public function __destruct()
	{
		unset($this->CI);
		//echo '<pre><code>'.print_r($this , 1).'</code></pre>';
	}
	
	/**
	 * Generic set
	 * @return void
	 */
	public function _set($field,$value){
		$this->$field = $value;
	}
	/**
	 * Generic get
	 * @return void
	 */
	public function _get($field){
		return $this->$field;
	}

}


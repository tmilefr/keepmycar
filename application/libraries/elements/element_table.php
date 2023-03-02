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
	protected $value  	= NULL;
	protected $values 	= [];
	protected $type 	= '';
	protected $model	= '';
	protected $foreignkey = '';
	protected $action = '';
	protected $ref = '';
	protected $parent_id = '';

	public function __construct(){
		parent::__construct();
		if (isset($this->CI->bootstrap_tools))
		{
			$this->CI->bootstrap_tools->_SetHead('assets/js/dynamic_row.js','js');
		}
		if ($this->model)
			$this->CI->load->model($this->model);
	}	

	public function AfterExec($datas){
		$this->CI->{$this->model}->SetLink($this->foreignkey, $datas['id']);
	}

	public function PrepareForDBA($value){
		//echo debug($_POST);
		$this->CI->{$this->model}->_set('debug',TRUE);

		$id_parent = $this->CI->render_object->_get('id');
		$obj = [];
		$datas = [];
		//return json_encode($obj);
		if (method_exists($this->CI->{$this->model},'DeleteLink'))
			$this->CI->{$this->model}->DeleteLink($id_parent);

		foreach($this->CI->{$this->model}->_get('defs') AS $field=>$defs){
			$datas[$field] = $this->CI->input->post($field.'_'.$this->model);
		}	

		foreach($datas[$this->ref] AS $key=>$value){
			if ($value != '...'){
				$lgn = new Stdclass();
				foreach($this->CI->{$this->model}->_get('defs') AS $field=>$defs){
					$lgn->{$field} = $datas[$field][$key];
				}
				if ($lgn->{$this->ref}){
					if ($id_parent){
						$lgn->{$this->foreignkey} = $id_parent;
					} else {
						$lgn->{$this->foreignkey} = 'tmp';
					}					
					$this->CI->{$this->model}->post($lgn);
					$obj[] = $lgn->{$this->ref};
				}
			}
		}
		return json_encode($obj);
	}

	public function RenderFormElement(){
		//return $this->CI->bootstrap_tools->input_text($this->name, $this->CI->lang->line($this->name) , $this->value);
		$id = $this->CI->render_object->_get('id');
		$ref = [];
		$table = '<div class="Dynamic_row" id="DR_'.$this->name.'">';
		if ($id){
			$this->CI->{$this->model}->_set('filter', [$this->foreignkey => $id ]);
			$this->CI->{$this->model}->_set('order', $this->foreignkey);
			$datas = $this->CI->{$this->model}->get_all();
			if (count($datas)){
				foreach($datas AS $key => $data){
					$table .= '<div class="input-group mb-3">';
					foreach($this->CI->{$this->model}->_get('defs') AS $field=>$defs){
						//echo debug($this->CI->render_object->_get('form_mod'), __file__.' '.__line__);
						$defs->_set('form_mod', $this->CI->render_object->_get('form_mod'));
						$defs->_set('value', $data->{$field});
						$defs->_set('parent_id', $data->id);
						
						$defs->set_name('_'.$this->model);
						$defs->SetMultiple(TRUE);
						

						if (in_array( $field , ['id',$this->foreignkey])){							
							$table .= '<input type="hidden" value="'.$data->{$field}.'" name="'.$field.'_'.$this->model.'[]">';
						} else {
							$table .= $defs->RenderFormElement();
						}				
					}
					$table .= '<div class="input-group-append"><button id="removeRow'.$data->id.'" type="button" class="removeRow btn btn-danger">'.$this->CI->lang->line('RemoveRow').'</button></div></div>';
				}
			}
		}
		$table .= '<div class="d-none" id="model'.$this->name.'"><div class="input-group mb-3">';
		foreach($this->CI->{$this->model}->_get('defs') AS $field=>$defs){
			$defs->_set('value', '');
			$defs->set_name('_'.$this->model);
			$defs->SetMultiple(TRUE);
			$defs->_set('parent_id', 'new');

			if (in_array( $field , ['id',$this->foreignkey])){							
				$table .= '<input type="hidden" value="" name="'.$field.'_'.$this->model.'[]">';
			} else {
				$table .= $defs->RenderFormElement();
			}			
		}
		$table .= '<div class="input-group-append"><button id="removeRow" type="button" class="removeRow btn btn-danger">'.$this->CI->lang->line('RemoveRow').'</button></div></div></div>';
		$table .= '</div><button type="button" ref="'.$this->name.'" class="addRow btn btn-info">'.$this->CI->lang->line('AddRow').'</button> '.$this->CI->lang->line($this->name.'_AddRow').'';
		return form_hidden($this->name , $this->value ).$table;

	}
	
	public function Render(){
		$tmp = $this->value;
		if($this->parent_id){
			$this->CI->{$this->model}->_set('filter', [$this->foreignkey => $this->parent_id ]);
			$this->CI->{$this->model}->_set('order', $this->foreignkey);
			$datas = $this->CI->{$this->model}->get_all();
			$dts = [];
			foreach($datas AS $data){
				foreach($this->CI->{$this->model}->_get('defs') AS $field=>$defs){
					if ($field != 'id'){
						$defs->_set('value', $data->{$field});
						$dts[] = $defs->render();
					}
				}
			}
			$tmp = implode(' ,', $dts);
		}
		return $tmp;
	}

	/**
	 * Destructor of class element.
	 * @return void
	 */
	public function __destruct()
	{
		unset($this->CI);
		//echo '<pre><code>'.print_r($this , 1).'</code></pre>';
		//echo debug($this);
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


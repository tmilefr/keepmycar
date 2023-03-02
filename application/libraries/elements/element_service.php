<?php
/*
 * element.php
 * Object in page
 * 
 */

class element_service
{
	protected $mode; //view, form.
	protected $name   	= null; //unique id ?
	protected $value  	= null;
	protected $values 	= [];
	protected $type 	= '';
	
	public function RenderFormElement(){
		return $this->CI->bootstrap_tools->input_text($this->name, $this->CI->lang->line($this->name) , $this->value);
	}
	
	public function Render(){

		$id_cnt = $this->CI->render_object->_get('id');
		$this->CI->ContributionLgn_model->_set('filter', ['id_cnt'=> $id_cnt ]);
		$this->CI->ContributionLgn_model->_set('order', 'id_cnt');

		$lgns = $this->CI->ContributionLgn_model->get_all();
		$string = "";
		$data = array();
		foreach($lgns AS $lgn){

			$this->CI->Service_model->_set('key', 'id');
			$this->CI->Service_model->_set('key_value', $lgn->id_ser );
			$detail = $this->CI->Service_model->get_one();
			//echo '<pre>'.print_r($detail, true).'</pre>';
			$data[] = $detail;
		}
		$head = ['name','amount'];

		return $this->CI->bootstrap_tools->render_table($head, $data);

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


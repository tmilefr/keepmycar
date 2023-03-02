<?php
defined('BASEPATH') || exit('No direct script access allowed');
Class Stats_object{

	protected $CI 		= NULL; //Controller instance 
	protected $_debug	= FALSE;
	
	public function __construct(){
		$this->CI =& get_instance();
		
		$this->CI->load->model('Projets_stats_model');
	}
	
	public function _set($field,$value){
		$this->$field = $value;
	}

	public function _get($field){
		return $this->$field;
	}	
	
	public function stats_user($year){
		return $this->CI->Projets_stats_model->get_stats_user(null,$year,null);
	}
	
	public function __destruct(){
		if ($this->_debug == TRUE){
			unset($this->CI);
			unset($this->_model);
			echo '<pre><code>'.print_r($this , 1).'</code></pre>';
		}
	}
	
}

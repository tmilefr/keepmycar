<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(dirname(__FILE__).'/Core_model.php');
class Work_model extends Core_model{

	function __construct(){
		parent::__construct();
		
		$this->_set('table'	, 'works');
		$this->_set('key'	, 'id');
		$this->_set('order'	, 'filter');
		$this->_set('direction'	, 'desc');
		$this->_set('json'	, 'Works.json');
		$this->_init_def();
	}


}
?>

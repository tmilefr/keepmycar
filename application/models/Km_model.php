<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(dirname(__FILE__).'/Core_model.php');
class Km_model extends Core_model{

	function __construct(){
		parent::__construct();
		$this->_set('_debug', FALSE);
		
		$this->_set('table'	, 'kms');
		$this->_set('key'	, 'id');
		$this->_set('order'	, 'date');
		$this->_set('direction'	, 'desc');
		$this->_set('json'	, 'Km.json');
		$this->_init_def();
	}

	function Stats(){

	}

	function get_last(){
		return $this->query('SELECT km AS km_prec FROM `kms` ORDER BY km DESC LIMIT 1');
	}

}
?>


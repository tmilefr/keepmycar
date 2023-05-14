<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(dirname(__FILE__).'/Core_model.php');
class Km_details_model extends Core_model{

	function __construct(){
		parent::__construct();
		$this->_set('_debug', FALSE);
		
		$this->_set('table'	, 'km_details');
		$this->_set('key'	, 'id');
		$this->_set('order'	, 'id_km');
		$this->_set('direction'	, 'desc');
		$this->_set('json'	, 'Km_details.json');
		$this->_init_def();
	}
}
?>


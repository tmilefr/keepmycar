<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(dirname(__FILE__).'/Core_model.php');
class Linksworksplans_model extends Core_model{

	function __construct(){
		parent::__construct();
		
		$this->_set('table'	, 'linksworksplans');
		$this->_set('key'	, 'id');
		$this->_set('order'	, 'filter');
		$this->_set('direction'	, 'desc');
		$this->_set('json'	, 'Linksworksplans.json');
		$this->_init_def();
	}

	function SetLink($foreign_key, $id){
		if ($id){
			$this->db->set($foreign_key, $id);
			$this->db->where($foreign_key, null);
			$this->db->update($this->table); 
		}
		$this->_debug_array[] = debug($this->db->last_query());
	}

	function DeleteLink($id = null){
		if ($id){
			$this->db->where_in('id_work', $id)
				 ->delete($this->table);
			$this->_debug_array[] = debug($this->db->last_query());
		}
		
	}


}
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(dirname(__FILE__).'/Core_model.php');
class Acl_actions_model extends Core_model{

	function __construct(){
		parent::__construct();
		$this->_set('_debug', FALSE);
		
		$this->_set('table'	, 'acl_actions');
		$this->_set('key'	, 'id');
		$this->_set('order'	, 'action');
		$this->_set('direction'	, 'desc');
		$this->_set('json'	, 'Acl_actions.json');
		$this->_init_def();
	}

	function DeleteLink($id_ctrl = null){
		if ($id_ctrl){
			$this->db->where_in('id_ctrl', $id_ctrl)
				 ->delete($this->table);
		}
	}

	function SetLink($id_ctrl = null){
		if ($id_ctrl){
			$this->db->set('id_ctrl', $id_ctrl);
			$this->db->where('id_ctrl', 0);
			$this->db->update($this->table);	
			$this->_debug_array[] = $this->db->last_query();
		}
	}

}
?>


<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(dirname(__FILE__).'/Core_model.php');
class Acl_users_model extends Core_model{
	
	function __construct(){
		parent::__construct();
		
		$this->_set('table'	, 'acl_users');
		$this->_set('key'	, 'id');
		$this->_set('order'	, 'name');
		$this->_set('direction'	, 'desc');
		$this->_set('json'	, 'Acl_users.json');
		$this->_init_def();
	}

	/**
	 * @brief Get current user by session info
	 * @param   int $userId
	 * @return  array
	 */
	public function getUserRoleId($userId = 0)
	{
	    $query = $this->db->select("role_id")
			->from('acl_users u')
			->where("id", $userId)
			->get();
		$this->_debug_array[] = $this->db->last_query();
		
		// User was found
		if ($query->num_rows() > 0)
		{
			$row = $query->row_array();
			return $row['role_id'];
		}
		
		// No role
		return 0;
	}

	function verifyLogin($login, $password){

		$usercheck = new stdClass();
		$usercheck->name = 'nobody';
		$usercheck->type  = "none";
		$usercheck->autorize = false;
		$usercheck->role_id = 0;
		$usercheck->id = 0;
	    $query = $this->db->select('*')
			->from('acl_users u')
			->where("login", $login )
			->get();
		$this->_debug_array[] = $this->db->last_query();
		// User was found
		if ($query->num_rows() > 0)
		{
			$row = $query->row_array();
			if (hash_equals($row['password'], crypt($password, PASSWORD_SALT))) {
				$usercheck = new stdClass();
				$usercheck->name = $row['name'];
				$usercheck->autorize = true;
				$usercheck->id = $row['id'];
				$usercheck->role_id = $row['role_id'];
				$usercheck->type  = "sys";

				//echo debug($usercheck);
			}

		}
		return $usercheck;
	}


}
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * User Controller
 *
 * @package     WebApp
 * @subpackage  Core
 * @category    Factory
 * @author      Tmile
 * @link        http://www.24bis.com
 */
class Acl_actions_controller extends MY_Controller {

	public function __construct(){
		parent::__construct();
		
		$this->_controller_name = 'Acl_actions_controller';  //controller name for routing
		$this->_model_name 		= 'Acl_actions_model';	   //DataModel
		$this->_edit_view 		= 'edition/Acl_actions_form';//template for editing
		$this->_list_view		= 'unique/Acl_actions_view.php';
		$this->_autorize 		= array('add'=>true,'edit'=>true,'list'=>true,'delete'=>true,'view'=>true);
		
		
		$this->title .=  $this->lang->line('GESTION').$this->lang->line($this->_controller_name);
		
		$this->_set('_debug', FALSE);
		$this->init();
		
		
	}

}

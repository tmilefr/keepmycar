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
class Km_controller extends MY_Controller {

	public function __construct(){
		parent::__construct();
		
		$this->_controller_name = 'Km_controller';  //controller name for routing
		$this->_model_name 		= 'Km_model';	   //DataModel
		$this->_edit_view 		= 'edition/Km_form';//template for editing
		$this->_list_view		= 'unique/Km_view.php';
		$this->_autorize 		= array('add'=>true,'edit'=>true,'list'=>false,'delete'=>true,'view'=>true);
		$this->_search 			= FALSE;

		
		$this->title .= $this->lang->line('GESTION').$this->lang->line($this->_controller_name);
		

		$this->load->model('Km_details_model'); //TODO : Auto load.
		$this->_set('_debug', FALSE);
		$this->init();
	}

	/**
	 * @brief Edition override Method
	 * @param $id 
	 * @returns 
	 * 
	 * 
	 */
	public function add(){
		$this->_set('render_view', FALSE);

		//recupération du dernier kilométrage saisi
		$prec = $this->{$this->_model_name}->get_last();
		$dba_data = new stdClass();
		$dba_data->km_prec = $prec[0]->km_prec;
		$this->render_object->_set('dba_data',$dba_data);

		parent::add();
		$this->render_view();	
	}
	/**
	 * @brief Genric View Method
	 * @param $id 
	 * @returns 
	 * 
	 * 
	 */
	public function view($id){
		$this->_set('render_view', FALSE);
		parent::view($id);

		$stats = new stdClass();
		$stats->km = $this->_dba_data->km - $this->_dba_data->km_prec;
		$stats->conso 	= round($this->_dba_data->liter * 100 / $stats->km,2);
		$this->data_view['stats'] 	=  $stats;
		$this->render_view();	
	}



}

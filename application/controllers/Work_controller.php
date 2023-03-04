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
class Work_controller extends MY_Controller {

	public function __construct(){
		parent::__construct();
		
		$this->_controller_name = 'Work_controller';  //controller name for routing
		$this->_model_name 		= 'Work_model';	   //DataModel
		$this->_edit_view 		= 'edition/Work_form';//template for editing
		$this->_list_view		= 'unique/Work_view.php';
		$this->_autorize 		= array('add'=>true,'edit'=>true,'list'=>false,'delete'=>true,'view'=>true);
		$this->_search 			= FALSE;

		
		$this->title .= $this->lang->line('GESTION').$this->lang->line($this->_controller_name);
		//$this->_set('_debug', FALSE);
		$this->init();
		
		$this->load->model('Plan_model');
		$this->render_object->Set_Rules_elements('Plan_model'); //loading Linksworksplans_model ELements
	
		$this->load->model('Reminder_model');
		$this->render_object->Set_Rules_elements('Reminder_model'); //loading Linksworksplans_model ELements

	}




	public function edit($id = 0){
		$this->_set('_redirect', FALSE);
		parent::edit($id);

		if ($this->form_validation->run($this->_model_name) === FALSE){

		} else {
			$type = $this->input->post('type');
			if (is_array($type)){
				foreach($type as $key=>$plan){
					$this->Plan_model->_set('key_value',$plan);
					$plan_detail  = $this->Plan_model->get_one();
					//$this->Reminder_model->_set('_debug', TRUE);
					$reminder = $this->Reminder_model->is_exist('','', ['id_work'=>$id,'id_plan'=>$plan]);
					if (!$reminder){

						$reminder = new StdClass();
						$reminder->id_work = $id;
						$reminder->id_plan = $plan;
						$reminder->id_equ = $this->input->post('id_equ');
						if ($this->input->post('km'))
							$reminder->next_km = $this->input->post('km') + $plan_detail->freq_km ;
						else 
							$reminder->next_km = 0;

						$reminder->next_date = (substr($this->input->post('date'),0,4)+$plan_detail->freq_time).substr($this->input->post('date'),4);
						$reminder->object = 'prévu par travaux du '.$this->input->post('date');

						$this->Reminder_model->post($reminder);
					}

				}
			}
			redirect($this->_get('_rules')[$this->next_view]->url);
		}
	}
	
}

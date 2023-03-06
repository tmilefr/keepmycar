<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->_controller_name = 'Home';  //controller name for routing
		$this->_model_name 		= 'Acl_users_model';	   //DataModel
		$this->title .= $this->lang->line($this->_controller_name);
		$this->data_view['content'] = '';
		$this->_set('_debug', FALSE);
		$this->load->library('Acl');
		//$this->load->model('Acl_users_model');
		$this->init();
		$this->bootstrap_tools->_SetHead('assets/vendor/chart.js/Chart.js','js');
	}

	public function maintenance(){
		$this->_set('view_inprogress','unique/Home_controller_maintenance');
		$this->render_view();
	}

	public function login(){
		$captcha_error = '';
		$login_error = '';
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			if ($this->config->item('captcha')){
				$captcha = json_decode($this->{$this->_model_name}->_get('defs')['recaptchaResponse']->PrepareForDBA($this->input->post("g-recaptcha-response")));
				//echo '<pre>'.print_r($captcha, TRUE).'</pre>';
			} else {
				$captcha = new StdClass();
				$captcha->success = true;
			}
			if (isset( $captcha->{'error-codes'}))
				$captcha_error = implode('<br/>', $captcha->{'error-codes'});

			if ($this->form_validation->run('Acl_users_model') == true AND isset($captcha) AND $captcha->success == true) {
				$data = $this->input->post();

				$login_error = $this->acl->CheckLogin($data);
				//$this->session->set_flashdata('login_error', $this->acl->CheckLogin($data));
				if ($this->acl->IsLog()){ 
					redirect('/Home');
				}
			}	
        }
		//BUG d'appel à l'objet, compensation
		$this->{$this->_model_name}->_get('defs')['recaptchaResponse']->_set('captcha',  $this->config->item('captcha') );
		$this->data_view['required_field'] = $this->{$this->_model_name}->_get('required');
		$this->data_view['captcha_error'] = $captcha_error;
		$this->data_view['login_error'] = $login_error;
		$this->_set('view_inprogress','unique/login_view');
		$this->render_view();
	}

	public function About(){
		$this->_set('view_inprogress','unique/about');
		$this->render_view();
	}

	//gestion de mon compte 
	public function myaccount(){
		//compte de type admin
		if ($this->acl->getType()  == "sys"){
			redirect('Acl_users_controller/edit/'.$this->acl->getUserId());
		}
	}

	
	public function logout(){
		session_destroy();
        redirect('/Home/login');
	}

	public function index()
	{
		$this->_set('view_inprogress','unique/home_page');

		$this->load->model('Km_model');
		$this->render_object->Set_Rules_elements('Km_model'); //loading Linksworksplans_model ELements

		$this->load->model('Work_model');
		$this->render_object->Set_Rules_elements('Work_model'); //loading Linksworksplans_model ELements

		$this->Km_model->_set('order','date');
		$this->Km_model->_set('direction','ASC');
		$datas = $this->Km_model->get_all();

		$stats =  [];
		$stats['global']['eco'] 	= 0;
		$stats['global']['km'] 		= 0;
		$stats['global']['liter'] 	= 0;
		$stats['global']['perday'] 	= 0;
		$stats['global']['perkm'] 	= 0;
		$stats['global']['billed'] 	= 0;
		

		foreach($datas as $key=>$data){
			$datas[$key]->nb 		= $data->km -  $data->km_prec;
			$datas[$key]->conso 	= round($data->liter * 100 / $data->nb,2);
			$datas[$key]->economie	= $data->liter * $data->sp98 - $data->billed;

			if ($key == 0){
				$stats['global']['conso_min'] = $data->conso;
				$stats['global']['conso_max'] = $data->conso;
			}
			if ($data->conso < $stats['global']['conso_min'] )
				$stats['global']['conso_min'] = $data->conso;
			if ($data->conso > $stats['global']['conso_max'] )
				$stats['global']['conso_max'] = $data->conso;

			$stats['dates'][] = $data->date;
			$stats['global']['km'] 		+= $data->nb; 
			$stats['global']['liter'] 	+= $data->liter; 
			$stats['global']['eco'] 	+= $data->economie;
			$stats['global']['billed'] 	+= $data->billed; 
			$stats['line']['economie'][$data->date] = $data->economie;
			$stats['line']['conso'][$data->date] = $data->conso;
		}
		$stats['global']['conso_moy'] = round($stats['global']['liter'] * 100 / $stats['global']['km'],2);
		
		$this->Work_model->_set('order','id');
		$datas = $this->Work_model->get_all();
		$stats['global']['spend'] = 0;
		foreach($datas AS $key=>$data){
			if ($key == 0){
				$max_km = $data->km;
				$min_km = $data->km;
			}
			if($data->km > $max_km){
				$max_km = $data->km;
			}
			if($data->km < $min_km){
				$min_km = $data->km;
			}		
			$stats['global']['dist_km'] = $max_km - $min_km;
			$stats['global']['spend'] += $data->billed;
		}
		$stats['global']['perkm'] = round($stats['global']['spend'] / $stats['global']['dist_km'],2);

		$stats['color']['economie'] = '#0099ff';
		$stats['color']['km'] = '#2682C4';		
		$stats['color']['conso'] = '#AACE3A';	

		$this->data_view['stats'] = $stats;
		$this->render_view();
	}

	public function no_right()
	{
		$this->_set('view_inprogress','unique/no_right');
		$routes = $this->session->userdata('routes');
		$this->data_view['routes_history'] = $routes;
		$this->render_view();
	}


}

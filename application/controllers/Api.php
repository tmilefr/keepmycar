<?php
defined('BASEPATH') OR exit('No direct script access allowed');





class Api extends MY_Controller {

	private $autorized_model  = ['kms'=>'Km_model','detail'=>'Km_details_model','users'=>'Acl_users_model','roles'=>'Acl_roles_model']; //model accessible en api

	public function __construct(){
		parent::__construct();
	}
	
	public function get($_model_name = null ,$id = null){
		if (!in_array($_model_name,array_keys($this->autorized_model))){
			http_response_code(405);
			echo json_encode(["message" => "Object Not Allowed"]);
			die();
		}
		$this->_model_name = $this->autorized_model[$_model_name];
		$this->load->model($this->_model_name);
		$this->render_object->Set_Rules_elements($this->_model_name); //loading Linksworksplans_model ELements
		$this->render_object->_set('_render_model','json');


		header("Content-Type: application/json");
		switch($_SERVER['REQUEST_METHOD'])
		{
			case 'POST':

			break;
			case 'GET':
				if ($id){
					$this->{$this->_model_name}->_set('key_value',$id);
					$dba_data = $this->{$this->_model_name}->get_one();
					if (!$dba_data)
						http_response_code(204);
					echo json_encode($dba_data);
				} else {
					$datas = $this->{$this->_model_name}->get_all();
					if (!count($datas))
						http_response_code(204);
					$response = new StdClass();
					$response->raw = $datas;
					$resp = [];
					foreach($datas AS $key=>$data){
						$res = [];
						foreach($data AS $field=>$value){
							$obj = new stdClass();
							$obj->raw = $value;
							$obj->render = $this->render_object->RenderElement($field,$value,$data->id, $this->_model_name );
							$res[$field] = $obj;
						}
						$resp[$key] = $res;
					}

					echo json_encode($resp);
				}
			break;
			default:
				// Requête invalide
				http_response_code(405);
				echo json_encode(["message" => "Method Not Allowed"]);
				break;
		}
	}
	
	public function all(){

	}

	public function logout(){
		session_destroy();
		http_response_code(401);
		die;
	}

	public function login(){
		if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
			header('Access-Control-Allow-Origin: *');
			header('Access-Control-Allow-Credentials: true');
			header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
			header('Access-Control-Allow-Headers: token, Content-Type');
			header('Access-Control-Max-Age: 1728000');
			header('Content-Length: 0');
			header('Content-Type: text/plain');
			die();
		}
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Content-Type, Authorization');
		header('Access-Control-Allow-Credentials: true');
		header("Content-Type: application/json");
		switch($_SERVER['REQUEST_METHOD'])
		{
			case 'POST':
				$input = json_decode(file_get_contents("php://input"));
				$data = [];
				$data['login'] = $input->login;
				$data['password'] = $input->password;
				$data['api-key'] = $input->{'api-key'};

				$usercheck = $this->acl->CheckLogin($data);
				if (!$usercheck || !$usercheck->autorize){
					http_response_code(403);
					echo json_encode(["message" => "Auth failed"]);
					die;
				}
				http_response_code(200);
				echo json_encode(
				array(
					"message" => "Successful login.",
					"jwt" => $usercheck->token,
					"id" => $usercheck->id,
					"role_id" => $usercheck->role_id,
					"type" => $usercheck->type,
					"expireAt" => $usercheck->expireAt,
					"expireAtRender" => date('Y-m-d H:i:s', $usercheck->expireAt)
				));
			break;
			default:
				// Requête invalide
				http_response_code(405);
				echo json_encode(["message" => "Method Not Allowed"]);
			break;
		}
		//die();
	}
	
}

?>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$autoload = str_replace('application\\','',APPPATH).'vendor\\autoload.php';
require_once($autoload);
use Firebase\JWT\JWT;
use Firebase\JWT\Key;



class Api extends MY_Controller {

	private $secretKey  = ''; //key from ACL

	public function __construct(){
		parent::__construct();
		$this->secretKey = $this->acl->_get('secretKey');
	}
	
	public function get($id = null){
		$this->_model_name = 'Km_model';
		$this->load->model($this->_model_name);
		$this->render_object->Set_Rules_elements('Km_model'); //loading Linksworksplans_model ELements

		header("Content-Type: application/json");
		switch($_SERVER['REQUEST_METHOD'])
		{
			case 'POST':

			break;
			case 'GET':
				if ($id){
					$this->{$this->_model_name}->_set('key_value',$id);
					$dba_data = $this->{$this->_model_name}->get_one();
					echo json_encode($dba_data);
				} else {
					$datas = $this->{$this->_model_name}->get_all();
					echo json_encode($datas);
				}
			break;
			default:
				// Requête invalide
				header("HTTP/1.0 405 Method Not Allowed");
				echo json_encode(["message" => "La méthode n'est pas autorisée"]);
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
				//echo print_r($input);
				if ($input->{'api-key'} == $this->secretKey){
					$usercheck = $this->Acl_users_model->verifyLogin($input->login, $input->password);

					if (!$usercheck->autorize){
						http_response_code(401);
						echo json_encode(["message" => "Auth failed"]);
						die;
					}

					$issuer_claim = "KeepMyCar"; // this can be the servername
					$audience_claim = "API access";
					
					$issuedat_claim = time(); // issued at
					$notbefore_claim = $issuedat_claim + 1; //not before in seconds
					$expire_claim = $issuedat_claim + 6000; // expire time in seconds
					$token = array(
					"iss" => $issuer_claim,
					"aud" => $audience_claim,
					"iat" => $issuedat_claim,
					"nbf" => $notbefore_claim,
					"exp" => $expire_claim,
					"data" => $usercheck);
	
					http_response_code(200);
	
					$jwt = JWT::encode($token, $this->secretKey, 'HS256');

					echo json_encode(
					array(
						"message" => "Successful login.",
						"jwt" => $jwt,
						"id" => $usercheck->id,
						"role_id" => $usercheck->role_id,
						"type" => $usercheck->type,
						"expireAt" => $expire_claim
					));
					
				} else {
					http_response_code(401);
					die;
				}
			break;
			case 'GET':

			break;
			default:
				// Requête invalide
				header("HTTP/1.0 405 Method Not Allowed");
				echo json_encode(["message" => "La méthode n'est pas autorisée"]);
				break;
		}
		//die();
	}
	
}

?>

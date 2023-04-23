<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
//ALTER TABLE `users` ADD `role_id` INT(11) NOT NULL AFTER `created`;
//GESTION DE la connection et de la sécurité du site

$autoload = str_replace('application\\','',APPPATH).'vendor\\autoload.php';
require_once($autoload);
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Acl
{

    private $secretKey;

    protected $is_log = false;
    protected $CI;
    protected $controller = NULL;
    protected $action = NULL;
    protected $permissions = [];
    protected $guestPages = [
        'home/logout',
        'home/login',
        'home/no_right',
        'home/maintenance',
		'api/login',
		'api/logout'
    ];
    protected $DontCheck    = FALSE;
    protected $_debug       = FALSE;
    protected $_debug_array = [];
    protected $usercheck    = NULL;
    protected $role_famille = 2;
	//protected $ApiMode 		= FALSE;

    
    /**
     * Constructor
     *
     * @param array $config            
     */
    public function __construct($config = array())
    {
        $this->CI = &get_instance();
        $this->CI->load->library('session');
        $this->CI->load->helper('url');
        $this->CI->load->model('Acl_roles_model');
        $this->CI->load->model('Acl_users_model');
		$this->CI->config->load('secured');
        //$this->CI->load->library('RestClient', $this->api);


		$this->secretKey = API_KEY;

        $this->controller = strtolower($this->CI->uri->rsegment(1));
        $this->action     = strtolower($this->CI->uri->rsegment(2));
        $this->routes_hisory = [];

        //un utilisateur est il connecté ? on centralise les appels à ses données.
        $this->usercheck = $this->CI->session->userdata('usercheck');
        if (!isset($this->usercheck->autorize)){ //initialisation de l'objet pour la sécurité
            $this->usercheck  = new StdClass();
            $this->usercheck->autorize =  false;
            $this->usercheck->type  = "none";
            $this->usercheck->name = 'nobody';
            $this->usercheck->id = 0;     
            $this->usercheck->role_id = 0;            
        }

        //création du tableau des droits pour l'utilisateur.
        if ($this->IsLog()){
            $this->permissions = $this->CI->Acl_roles_model->getRolePermissions();
        }
    }
    
    /**
     * Check if user is connected
     *
     * @access public
     * @return bool
     * 
     */
    public function IsLog(){
        
        $headers = getallheaders();
        //token JWT pour les apis
        if (isset($headers['Authorization']) && preg_match('/Bearer (.*)/', $headers['Authorization'], $matches)) {
            $jwt = trim($matches[1]);
            try{
                $decoded = JWT::decode($jwt,  new Key($this->secretKey, 'HS256') ); 
				//$this->ApiMode = true;
                if (isset($decoded->data)){
					$this->usercheck  = new StdClass();
					$this->usercheck->autorize =  true;
					$this->usercheck->type  = $decoded->data->type;
					$this->usercheck->name = $decoded->data->name;
					$this->usercheck->id = $decoded->data->id;    
					$this->usercheck->role_id = $decoded->data->role_id;
					$this->CI->session->set_userdata('usercheck', $this->usercheck); 
					$this->permissions = $this->CI->Acl_roles_model->getRolePermissions();

					if (!$this->hasAccess()){
						echo json_encode(["message" => "Wrong Token"]);
						http_response_code(403);
						die;
					}
                }
            } catch (Exception $e) {
				echo json_encode(["message" => $e->getMessage()]);
                http_response_code(401);
                die;
            }
        }        
        $this->_debug_array[] =  $this->usercheck;
        if (  $this->usercheck->autorize === true ){
            return TRUE;
        } else {
            return FALSE;
        }
    }
   
    /**
     * Check is current controller/method has access in role
     *
     * @access public
     * @return bool
     * 
     */
    public function hasAccess($currentPermission = null)
    {
        if ($this->DontCheck)
            return TRUE;
        if (isset($this->usercheck->role_id)){  
            //test de l'url par défaut si pas fournie
            if (!$currentPermission)
                $currentPermission =  $this->controller . '/' . $this->action;
            //on regarde dans le tableau des droits ratatchés à l'utilisateur.
            if (isset($this->permissions[$this->getUserRoleId()]) && count($this->permissions[$this->getUserRoleId()]) > 0) {
                if (in_array( strtolower($currentPermission) , $this->permissions[$this->getUserRoleId()])) {
                    return TRUE;
                } else {
					//echo $currentPermission.' NOT GRANTED'."<br/>";
                    $this->_debug_array[] = $currentPermission.' NOT GRANTED';
                }
            }
        }        
        return FALSE;
    }
    
    /**
     * Check if current controller/method has access
     *
     * @access public
     * @return bool
     * 
     */
    public function Route(){
        if ($this->DontCheck)
            return TRUE;      
        if ( $this->IsLog() ) {
            /*if ($this->action == 'index')
                return TRUE;*/
            // Check for ACL
            if (!$this->CI->acl->hasAccess()) {
                if ($this->controller . '/' . $this->action != '/home/no_right' && !in_array($this->controller . '/' . $this->action, $this->CI->acl->getGuestPages())) {
                    $this->routes_hisory[] = $this->controller . '/' . $this->action;
                    $this->CI->session->set_userdata('routes',  $this->routes_hisory); 
                    return redirect('/Home/no_right');
                } 
            } else {
                if ($this->CI->config->item('maintenance') == true &&  $this->controller . '/' . $this->action != 'home/maintenance'){
                    //unset($this->CI);
                    //echo debug($this);
                    if ($this->getType() != 'sys') //les utilisateurs SYS ne sont pas concerné.
                        return redirect('/Home/maintenance');
                }  

                $this->_debug_array[] = $this->controller . '/' . $this->action.' GRANTED';
            }
        } else {
            if (!in_array($this->controller . '/' . $this->action, $this->CI->acl->getGuestPages()) && $this->controller . '/' . $this->action != 'Home/login'){
                return redirect('Home/login');
            }
        }
    }

    /**
     * Check login for user
     *
     * @access public
     * @return bool
     * 
     */
    public function CheckLogin($data){
        //Compte admin
        $this->usercheck = $this->CI->Acl_users_model->verifyLogin($data['login'], $data['password']);//? best way , realy ?
        $this->CI->session->set_userdata('usercheck', $this->usercheck); 
        //pas d'accès.
        if (!$this->usercheck->autorize){
            return $this->CI->lang->line('WRONG_ACCES');
        }
    }

    /**
     * Get Type
     *
     * @access public
     * @return bool
     * 
     */
    public function getType(){
        if (isset($this->usercheck->type)){
            return $this->usercheck->type;
        } else {
            return FALSE;
        }  
    }

    // --------------------------------------------------------------------
    
     /**
     * Get Name
     *
     * @access public
     * @return bool
     * 
     */
    public function GetUserName(){
        if (isset($this->usercheck->name)){
            return $this->usercheck->name;
        } else {
            return FALSE;
        }  
    }

    /**
     * Return the value of user id from the session.
     * Returns 0 if not logged in
     *
     * @access private
     * @return int
     */
    public function getUserId()
    {
        if (isset($this->usercheck->id))
            return $this->usercheck->id;
        return false;
    }

    /**
     * Return user role
     *
     * @return int
     */
    public function getUserRoleId()
    {
        if (isset($this->usercheck->role_id))
            return $this->usercheck->role_id;
        return false;
    }
    
    //liste des pages ne nécessitant pas de login
    public function getGuestPages()
    {
        return $this->guestPages;
    }

    public function _set($field,$value){
		$this->$field = $value;
	}

	public function _get($field){
		return $this->$field;
	}	

	function __destruct(){
		if ($this->_debug){
			unset($this->CI);
			echo debug($this, __file__);
		}
	}
    
}

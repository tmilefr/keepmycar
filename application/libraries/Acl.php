<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
//ALTER TABLE `users` ADD `role_id` INT(11) NOT NULL AFTER `created`;
//GESTION DE la connection et de la sécurité du site
class Acl
{
    protected $is_log = false;
    protected $CI;
    protected $userId = NULL;
    protected $userRoleId = NULL;
    protected $controller = NULL;
    protected $action = NULL;
    protected $permissions = [];
    protected $guestPages = [
        'home/logout',
        'home/login',
        'home/no_right',
        'home/index',
        'home/Myaccount',
        'home/about',
        'home/maintenance',
        'home'
    ];
    protected $DontCheck    = FALSE;
    protected $_debug       = FALSE;
    protected $_debug_array = [];
    protected $usercheck    = NULL;
    protected $role_famille = 2;

    protected $api = [
        'base_url'  => 'https://delta-enfance3.fr/familleabcm/ABCMRegios68200/' , 
        'user_agent' => "abcmschule"
    ];
    
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
        $this->CI->load->library('RestClient', $this->api);

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
        //echo debug($this->permissions);
        if ($this->DontCheck)
            return TRUE;
          
        if ($this->IsLog() ){  
            //tst de l'url par défaut si pas fournie
            if (!$currentPermission)
                $currentPermission =  $this->controller . '/' . $this->action;

            //on regarde dans le tableau des droits ratatchés à l'utilisateur.
            if (isset($this->permissions[$this->getUserRoleId()]) && count($this->permissions[$this->getUserRoleId()]) > 0) {
                if (in_array( strtolower($currentPermission) , $this->permissions[$this->getUserRoleId()])) {
                    return TRUE;
                } else {
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
            if ($this->controller . '/' . $this->action != 'home/login'){
                return redirect('/Home/login');
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
        $this->usercheck = $this->CI->Acl_users_model->verifyLogin($data['login'], $data['password']);
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
        if ($this->IsLog() ){
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
        if ($this->IsLog() ){
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
        if ($this->IsLog())
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
        if ($this->IsLog())
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

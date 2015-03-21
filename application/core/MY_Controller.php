<?php

class CS_Controller extends CI_Controller {
    
    protected $userId = 0;
    protected $autoSetDefaultValue = true;
            function __construct() {
        parent::__construct();
        
        $this->load->database();
        $this->load->library('session');
        $this->load->model('cs_model', "m");
        $this->crud = new Grocery_CRUD_CS();
        $this->crud->set_language("thai"); 
//        $this->crud->get_form_validation()->set_message('required', "กรุณาใส่ %s ");
        $this->setDefaultAction();
        
        $this->userId = $this->session->userdata("userID");
        if(!$this->userId){
            redirect("login");
        }
        $permission = $this->m->getPermission($this->userId, $this->router->fetch_class());
        $this->session->set_userdata("permission", $permission);
    }

    public function view($view, $output = array('output' => '' , 'js_files' => array() , 'css_files' => array() )) {
        $this->load->view('header.php', $output);
        
        $this->load->view($view, $output);
        
        $this->load->view('footer.php', $output);
    }

    public function output() {
//        $output = array('output' => '' , 'js_files' => array() , 'css_files' => array() )
        $this->view("grocery.php", $this->crud->render());
    }
    
     protected function setDefaultAction(){
        
        
        
        $this->crud
                ->field_type("CREATE_DATE", "hidden")
                ->field_type("CREATE_USER_ID", "hidden")    
                ->field_type("UPDATE_DATE", "hidden")    
                ->field_type("UPDATE_USER_ID", "hidden")       
                ->field_type("IS_CANCEL", "hidden")   
            ->unset_print()->unset_export()->unset_read()
            ->callback_before_insert(array($this,'clearBeforeInsertAndUpdate'))
            ->callback_before_update(array($this,'clearBeforeInsertAndUpdate'))
            ->callback_before_delete(array($this,'_beforeDelete'))
//            ->set_default_value(array("permissionEdit" => $this->permissionEdit))
            ;
            
        $state = $this->crud->getState();
        
        $fields = array();
        switch ($state) {
            case 'edit':
            case 'update':
                $fields = array_merge($fields, array("UPDATE_DATE", "UPDATE_USER_ID"));
            case 'add':
            case 'insert':
                $fields = array_merge($fields, array("CREATE_DATE", "CREATE_USER_ID"));
            default:
                $this->crud->fields($fields);
                break;
        }
    }
    
    protected function setDefaultValue($array, $mode = null) {
        
        $state = ($mode != null ? $mode : $this->crud->getState());
        
        switch ($state) {
            case "insert":
                $array["CREATE_DATE"] = date("YmdHis", time());
                $array["CREATE_USER_ID"] = $this->userId;
            case "update":
                $array["UPDATE_DATE"] = date("YmdHis", time());
                $array["UPDATE_USER_ID"] = $this->userId;
                break;
            default:
                
                break;
        }
        return $array;
    }
    
    
    public function clearBeforeInsertAndUpdate($array) {
        if($this->autoSetDefaultValue){
            $array = $this->setDefaultValue($array);
        }
        return $array;
    }
    
    public function _beforeDelete() {
        return true;
    }
    
    
}


<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_Group extends CS_Controller {

    public function __construct()
    {
            parent::__construct();
    }

    public function index()
    {
         try{
           $fieldArr = array('USER_GROUP_CODE', 'USER_GROUP_NAME', 'USER_PERMISSION');

//                $fieldIntArr = array('MATERIAL_PRICE','MATERIAL_BALANCE','BUDGET_YEAR');
//                $crud->set_theme('datatables');
            $this->crud->set_table('user_group')
            ->set_subject('กลุ่มผู้ใช้')
            ->set_relation_n_n('USER_PERMISSION', 'USER_PERMISSION', 'MENU_PAGE', 'USER_GROUP_ID', 
                    'MENU_PAGE_ID', 'MENU_PAGE_NAME', 'USER_PERMISSION_SEQ', 'MENU_PAGE.PARENT_ID IS NOT NULL', 'MENU_PAGE_CODE')
//            ->set_relation('USER_ID', 'TRN_USER_GROUP', 'MATERIAL_TYPE_NAME')
            ->display_as('USER_GROUP_CODE', 'รหัสกลุ่มผู้ใช้')
            ->display_as("USER_GROUP_NAME", "ชื่อกลุ่มผู้ใช้")   
            ->display_as("USER_PERMISSION", "โปรแกรม")
//            ->field_type("PASSWORD", "password", null, "")   
            ->required_fields($fieldArr)
            ->columns($fieldArr)
            ->fields($fieldArr)
            ->field_style($fieldArr, array('width' => '500px'))
//            ->field_style("USER_PERMISSION_ID" , array('height' => '500px'))
                    ->order_by('USER_GROUP_CODE','asc')
                    

            ->set_rules('USER_GROUP_CODE', 'รหัสกลุ่มผู้ใช้', 'trim|required|xss_clean|callback_user_group_code_check')
            ->set_rules('USER_GROUP_NAME', 'ชื่อกลุ่มผู้ใช้', 'trim|required|xss_clean|callback_user_group_name_check')
            ;

            $this->output();

        }catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());

            $output = $this->grocery_crud->render();

            $this->output($output);
        }
    }

    
    public function user_group_code_check($str = null, $row = null, $rows = null) {
        $id = $this->uri->segment(4);
        
        $num_row = 0;
        if (!empty($id) && is_numeric($id)) {
            $this->db->where("user_group_id !=", $id);
            $num_row = $this->db->where('user_group_code', $str)->get('user_group')->num_rows();
        }
        
        if ($num_row >= 1) {
            $this->form_validation->set_message('user_group_code_check', 'รหัสกลุ่มผู้ใช้นี้ถูกใช้แล้ว');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function user_group_name_check($str = null, $row = null, $rows = null) {
        $id = $this->uri->segment(4);
        
        $num_row = 0;
        if (!empty($id) && is_numeric($id)) {
            $this->db->where("user_group_id !=", $id);
            $num_row = $this->db->where('user_group_name', $str)->get('user_group')->num_rows();
        }
        
        if ($num_row >= 1) {
            $this->form_validation->set_message('user_group_name_check', 'ชื่อกลุ่มผู้ใช้นี้ถูกใช้แล้ว');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function clearBeforeInsertAndUpdate($array) {
        $array = parent::clearBeforeInsertAndUpdate($array);
//        $userPermissionId = $array['USER_PERMISSION_ID'];
//        $parentIdArr = ($userPermissionId != null ? $this->m->getParentId($userPermissionId) : array());
//        
//        $array['USER_PERMISSION_ID'] = (empty($parentIdArr) ? array() : array_merge($array['USER_PERMISSION_ID'], $parentIdArr));
        return $array;
    }
    
}
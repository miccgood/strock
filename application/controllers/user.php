<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CS_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        try {
            $fieldArr = array('USER_CODE', 'USERNAME', 'PASSWORD', 'TRN_USER_GROUP_ID');
            $columnArr = array('USER_CODE', 'USERNAME', 'TRN_USER_GROUP_ID');
            $required_fields = $fieldArr;
            if($this->crud->getState() == 'edit'){
                $required_fields = $columnArr;
            }
//                $fieldIntArr = array('MATERIAL_PRICE','MATERIAL_BALANCE','BUDGET_YEAR');
//                $crud->set_theme('datatables');
            $this->crud->set_table('user')
                    ->set_subject('ผู้ใช้')
                    ->set_relation_n_n('TRN_USER_GROUP_ID', 'TRN_USER_GROUP', 'USER_GROUP', 'USER_ID', 'USER_GROUP_ID', 'USER_GROUP_NAME', 'TRN_USER_GROUP_SEQ'
                            , null, 'USER_GROUP_CODE')
//            ->set_relation('USER_ID', 'TRN_USER_GROUP', 'MATERIAL_TYPE_NAME')
                    ->display_as('USER_CODE', 'รหัสผู้ใช้')
                    ->display_as("USERNAME", "ชื่อผู้ใช้")
                    ->display_as("PASSWORD", "รหัสผ่าน")
                    ->display_as("TRN_USER_GROUP_ID", "กลุ่มผู้ใช้")
                    ->field_type("PASSWORD", "password", null, "")
                    ->columns($columnArr)
                    ->fields($fieldArr)
                    ->field_style($fieldArr, array('width' => '500px'))
                    ->set_rules('USER_CODE', 'รหัสผู้ใช้', 'trim|required|xss_clean|callback_user_code_check')
                    ->set_rules('USERNAME', 'ชื่อผู้ใช้', 'trim|required|xss_clean|callback_user_name_check')
                    ->order_by('USER_CODE','asc')
                    
                ->required_fields($required_fields)
            ;

            $this->output();
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());

            $output = $this->grocery_crud->render();

            $this->output($output);
        }
    }

    public function user_code_check($str = null, $row = null, $rows = null) {
        $id = $this->uri->segment(4);
        $num_row = 0;
        if (!empty($id) && is_numeric($id)) {
            $this->db->where("user_id !=", $id);
            $num_row = $this->db->where('user_code', $str)->get('user')->num_rows();
        }
        
        if ($num_row >= 1) {
            $this->form_validation->set_message('user_code_check', 'รหัสผู้ใช้นี้ถูกใช้แล้ว');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function user_name_check($str = null, $row = null, $rows = null) {
        $id = $this->uri->segment(4);
        
        $num_row = 0;
        if (!empty($id) && is_numeric($id)) {
            $this->db->where("user_id !=", $id);
            $num_row = $this->db->where('username', $str)->get('user')->num_rows();
        }
        
        if ($num_row >= 1) {
            $this->form_validation->set_message('user_name_check', 'ชื่อผู้ใช้นี้ถูกใช้แล้ว');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function clearBeforeInsertAndUpdate($row, $rows, $pk) {
        try {
            $password = $row["PASSWORD"];
            if ($password == "") {
                unset($row["PASSWORD"]);
            } else {
                $row["PASSWORD"] = md5($row["PASSWORD"]);
            }
            return $row;
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());

//            $output = $this->grocery_crud->render();
//            $this->output($output);
        }
    }

}

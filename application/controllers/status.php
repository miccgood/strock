<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Status extends CS_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        try{
            $fieldArr = array('STATUS_CODE', 'STATUS_NAME');

            $this->crud->set_table('status')
            ->set_subject('สถานะ')
            ->display_as('STATUS_CODE', 'รหัสสถานะ')
            ->display_as('STATUS_NAME', 'ชื่อสถานะ')
            ->columns($fieldArr)
            ->fields($fieldArr)
            ->field_style($fieldArr, array('width' => '500px'))

            ->set_rules('STATUS_CODE', 'รหัสสถานะ', 'trim|required|xss_clean|callback_status_code_check')
            ->set_rules('STATUS_NAME', 'ชื่อสถานะ', 'trim|required|xss_clean|callback_status_name_check')
        
            ->required_fields($fieldArr)
            ;

            $this->output();

        }catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());

            $output = $this->grocery_crud->render();

            $this->output($output);
        }
    }
    
    
    public function status_code_check($str = null, $row = null, $rows = null) {
        $id = $this->uri->segment(4);
        $num_row = 0;
        if (!empty($id) && is_numeric($id)) {
            $this->db->where("status_id !=", $id);
            $num_row = $this->db->where('status_code', $str)->get('status')->num_rows();
        }
        
        if ($num_row >= 1) {
            $this->form_validation->set_message('status_code_check', 'รหัสสถานะนี้ถูกใช้แล้ว');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function status_name_check($str = null, $row = null, $rows = null) {
        $id = $this->uri->segment(4);
        
        $num_row = 0;
        if (!empty($id) && is_numeric($id)) {
            $this->db->where("status_id !=", $id);
            $num_row = $this->db->where('status_name', $str)->get('status')->num_rows();
        }
        
        if ($num_row >= 1) {
            $this->form_validation->set_message('status_name_check', 'ชื่อสถานะนี้ถูกใช้แล้ว');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    

}
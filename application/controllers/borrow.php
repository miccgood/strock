<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Borrow extends CS_Controller {

    public static $preBorrowCode = "BR";
    public function __construct()
    {
            parent::__construct();
    }

    public function index()
    {
        $status0 = $this->m->getStatusIdByCode("0000");
        try{
            $borrowCode = $this->getBorrowCode();

            $fieldArr = array('BORROW_CODE', 'MATERIAL_ID', 'MATERIAL_BALANCE', 'UNIT', 'REMARK', 'USER_ID', 'BORROW_DATE', 'STATUS_ID');

//               $fieldArr = array('BORROW_CODE', 'MATERIAL_ID', 'UNIT', 'REMARK', 'USER_ID', 'BORROW_DATE', 'STATUS_ID');

//                $fieldIntArr = array('MATERIAL_PRICE','MATERIAL_BALANCE','BUDGET_YEAR');
//                $crud->set_theme('datatables');
            $this->crud->set_table('borrow')
            ->set_subject('รายการยืม')
            ->set_relation('MATERIAL_ID', 'MATERIAL', 'MATERIAL_NAME')
            ->set_relation('USER_ID', 'USER', 'DISPLAY_NAME')
            ->set_relation('STATUS_ID', 'STATUS', 'STATUS_NAME')

            ->display_as('BORROW_CODE', 'รหัสใบยืม')
            ->display_as('MATERIAL_ID', 'วัสดุ')
            ->display_as('UNIT', 'จำนวน')
            ->display_as('REMARK', 'หมายเหตุ')
            ->display_as('USER_ID', 'ผู้ยืม')
            ->display_as('BORROW_DATE', 'วันที่ยืม')
            ->display_as('STATUS_ID', 'สถานะใบยืม')
            ->display_as('MATERIAL_BALANCE', 'จำนวนทั้งหมด')
            ->columns($fieldArr) 
            ->fields($fieldArr)
            ->field_style($fieldArr, array('width' => '500px'))
            ->required_fields($fieldArr)
            ->field_style(array('UNIT'), array('width' => '100px'))

            ->field_type('BORROW_DATE', 'readonly', null, date("d/m/Y"))
            ->field_type('UNIT', 'integer')
            ->field_type('BORROW_CODE', 'readonly', null, $borrowCode)
            ->field_type('USER_ID', 'readonly', NULL, $this->userId)
            ->field_type('STATUS_ID', 'readonly', NULL, $status0)
            ->field_type('MATERIAL_BALANCE', 'readonly', null, '')

            ->set_rules(array('UNIT'), null, 'integer|required')

            ->load_js_stock("borrow")
            ;
            $this->output();

        }catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());

            $output = $this->grocery_crud->render();

            $this->output($output);
        }
    }

    private function getBorrowCode(){
        $thisYear = substr(DateUtils::getThaiYear(), 2, 2);
        $borrowCode = $this->m->getNewBorrowCode();
        $borrowCode = self::$preBorrowCode . $thisYear . str_pad($borrowCode, 5, "0", STR_PAD_LEFT); 
        return $borrowCode;
    }
    
    public function getCountMaterialById()
    {
        $post = $this->input->post();
        $materialId = $post['materialId'];
        $material_balance = $this->m->getCountMaterialById($materialId);
        $ret = array("material_balance" => $material_balance);
        echo json_encode($ret);
    }
}
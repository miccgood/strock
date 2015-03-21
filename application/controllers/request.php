<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Request extends CS_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
             try{
//                $crud = new grocery_CRUD();

                $fieldArr = array('REQUEST_CODE', 'USER_ID', 
                        'STATUS_ID', 'MATERIAL_ID', 
                        'UNIT', 'REQUEST_DATE');
                 
                $fieldIntArr = array('UNIT');
                
                $this->crud->set_table('request')
                ->set_subject('รายการขอเบิก')
                        
                ->set_relation('MATERIAL_ID', 'MATERIAL', 'MATERIAL_NAME')
                ->set_relation('STATUS_ID', 'STATUS', 'STATUS_NAME')
//                ->set_relation('USER_ID', 'USER', 'USERNAME', 'USER_ID = ' . $this->userId)
                        
                ->display_as('REQUEST_CODE', "เลขที่ขอเบิก")
                ->display_as('USER_ID', "ผู้ใช้")
                ->display_as('STATUS_ID', "สถานะ")
                ->display_as('MATERIAL_ID', "วัสดุ")
                ->display_as('UNIT', "จำนวน")
                ->display_as('REQUEST_DATE', "วันที่ขอเบิก")
                        
                ->fields($fieldArr)
                ->required_fields(array_merge($fieldArr, $fieldIntArr))
                ->field_style(array_merge($fieldIntArr, $fieldArr), array('width' => '500px'))
                ->field_style($fieldIntArr, array('width' => '100px'))
                ->field_type("USER_ID", "hidden", $this->userId)
                ;
//                $output = $crud->render();

                $this->output();

            }catch(Exception $e){
                show_error($e->getMessage().' --- '.$e->getTraceAsString());
                
                $output = $this->grocery_crud->render();

                $this->output($output);
            }
	}


}
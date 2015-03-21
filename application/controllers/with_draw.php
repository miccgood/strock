<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class With_draw extends CS_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
             try{
//                $crud = new grocery_CRUD();

                $fieldArr = array('WITH_DRAW_CODE', 
                        'MATERAIL_ID', 'UNIT', 
                        'REMARK', 'USER_ID', 
                        'WITH_DRAW_DATE', 'STATUS_ID');
                 
                $fieldIntArr = array('UNIT');
                
                $this->crud->set_table('with_draw')
                ->set_subject('รายการรับ')
                        
                ->set_relation('MATERIAL_ID', 'MATERIAL', 'MATERIAL_NAME')
                ->set_relation('STATUS_ID', 'STATUS', 'STATUS_NAME')
                ->set_relation('USER_ID', 'USER', 'USERNAME')
//                        
                ->display_as('WITH_DRAW_CODE', "เลขที่รับวัสดุ")
                ->display_as('MATERAIL_ID', "วัสดุ")
                ->display_as('UNIT', "จำนวน")
                ->display_as('REMARK', "หมายเหตุ")
                ->display_as('USER_ID', "ผู้รับ")
                ->display_as('WITH_DRAW_DATE', "วันที่รับวัสดุ")
                ->display_as('STATUS_ID', "สถานะ")
//                        
                ->fields($fieldArr)
                ->required_fields(array_merge($fieldArr, $fieldIntArr))
                ->field_style(array_merge($fieldIntArr, $fieldArr), array('width' => '500px'))
                ->field_style($fieldIntArr, array('width' => '100px'))
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
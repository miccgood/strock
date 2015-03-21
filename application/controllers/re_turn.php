<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Re_turn extends CS_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
             try{
//                $crud = new grocery_CRUD();

                $fieldArr = array('RETURN_CODE', 'UNIT', 
                        'REMARK', 'BORROW_ID');
                 
                $fieldIntArr = array('UNIT');
                
                $this->crud->set_table('return')
                ->set_subject('รายการคืน')
                        
                ->set_relation('BORROW_ID', 'BORROW', 'BORROW_CODE')
////                        
                ->display_as('RETURN_CODE', "เลขที่การคืน")
                ->display_as('UNIT', "จำนวน")
                ->display_as('REMARK', "หมายเหตุ")
                ->display_as('BORROW_CODE', 'รหัสใบยืม')
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
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Document extends CS_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
             try{
                $fieldArr = array('DOCUMENT_CODE', 'COMPANY_NAME', 'DOCUMENT_DATE', 'MATERIAL_ID', 'USER_ID');
                 
                $this->crud->set_table('document')
                ->set_subject('เอกสาร')
                ->set_relation('MATERIAL_ID', 'MATERIAL', 'MATERIAL_NAME')
                ->set_relation('USER_ID', 'USER', 'USER_NAME')
                        
                ->display_as('DOCUMENT_CODE', 'รหัสเอกสาร')
                ->display_as('COMPANY_NAME', 'ชื่อบริษัท')
                ->display_as('DOCUMENT_DATE', 'วันที่เอกสาร')
                ->display_as('MATERIAL_ID', 'วัสดุ')
                ->display_as('USER_ID', 'เจ้าของเอกสาร')
                ->columns($fieldArr) 
                ->fields($fieldArr)
                ->field_style($fieldArr, array('width' => '500px'))
                        
                ->field_type('DOCUMENT_DATE', 'date')
                        
                ;
                $this->output();

            }catch(Exception $e){
                show_error($e->getMessage().' --- '.$e->getTraceAsString());
                
                $output = $this->grocery_crud->render();

                $this->output($output);
            }
	}


}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Material_Type extends CS_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
             try{
               $fieldArr = array('MATERIAL_TYPE_CODE', 'MATERIAL_TYPE_NAME');
                 
                $this->crud->set_table('material_type')
                ->set_subject('ประเภทวัสดุ')
                ->display_as('MATERIAL_TYPE_CODE', 'รหัสประเภทวัสดุ')
                ->display_as('MATERIAL_TYPE_NAME', 'ชื่อประเภทวัสดุ')
                ->columns($fieldArr)
                ->fields($fieldArr)
                ->field_style($fieldArr, array('width' => '500px'))
                ->required_fields($fieldArr)
                        ;
                        
                $this->output();

            }catch(Exception $e){
                show_error($e->getMessage().' --- '.$e->getTraceAsString());
                
                $output = $this->grocery_crud->render();

                $this->output($output);
            }
	}


}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Material_Unit extends CS_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
             try{
               $fieldArr = array('MATERIAL_UNIT_CODE', 'MATERIAL_UNIT_NAME');
                 
                $this->crud->set_table('material_unit')
                ->set_subject('หน่วย')
                ->display_as('MATERIAL_UNIT_CODE', 'รหัสหน่วย')
                ->display_as('MATERIAL_UNIT_NAME', 'ชื่อหน่วย')
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
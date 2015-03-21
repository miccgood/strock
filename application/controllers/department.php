<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Department extends CS_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
             try{
               $fieldArr = array('DEPARTMENT_CODE', 'DEPARTMENT_NAME');
                 
                $this->crud->set_table('department')
                ->set_subject('หน่วยงาน')
                        
                ->display_as('DEPARTMENT_CODE', 'Department Code')
                ->display_as("DEPARTMENT_NAME", "Department Name")    
                ->columns($fieldArr)
                ->field_style($fieldArr, array('width' => '500px'))
                ;
                        
                $this->output();

            }catch(Exception $e){
                show_error($e->getMessage().' --- '.$e->getTraceAsString());
                
                $output = $this->grocery_crud->render();

                $this->output($output);
            }
	}


}
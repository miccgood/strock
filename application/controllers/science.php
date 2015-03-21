<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Science extends CS_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
             try{
               $fieldArr = array('SCIENCE_CODE', 'SCIENCE_NAME');
                 
                $this->crud->set_table('science')
                ->set_subject('วิชา')
                ->display_as('SCIENCE_CODE', 'รหัสวิชา')
                ->display_as('SCIENCE_NAME', 'ชื่อวิชา')
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
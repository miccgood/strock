<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Store extends CS_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
             try{
               $fieldArr = array('STORE_CODE', 'STORE_NAME');
                 
//                $fieldIntArr = array('MATERIAL_PRICE','MATERIAL_BALANCE','BUDGET_YEAR');
//                $crud->set_theme('datatables');
                $this->crud->set_table('store')
                ->set_subject('คลังวัสดุ')
                        
                ->display_as('STORE_CODE', 'Store Code')
                ->display_as("STORE_NAME", "Store Name")    
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
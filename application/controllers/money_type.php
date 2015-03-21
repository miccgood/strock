<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Money_Type extends CS_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
            try{
                $fieldArr = array('MONEY_TYPE_CODE', 'MONEY_TYPE_NAME');
                 
                $this->crud->set_table('money_type')
                ->set_subject('ประเภทเงิน')
                ->display_as('MONEY_TYPE_CODE', 'รหัสประเภทเงิน')
                ->display_as('MONEY_TYPE_NAME', 'ชื่อประเภทเงิน')
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
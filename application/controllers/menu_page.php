<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu_Page extends CS_Controller {

    public function __construct()
    {
            parent::__construct();
    }

    public function index($stage = null, $pk = null)
    {
         try{
           $fieldArr = array('MENU_PAGE_CODE', 'MENU_PAGE_NAME', 'MENU_PAGE_LINK', 'PARENT_ID', 'ICON');

           $where = (isset($pk) ? 'PARENT_ID IS NULL AND MENU_PAGE_ID <> ' . $pk : 'PARENT_ID IS NULL');
            $this->crud->set_table('menu_page')
            ->set_subject('โปรแกรม')
            ->display_as('MENU_PAGE_CODE', 'รหัสโปรแกรม')
            ->display_as("MENU_PAGE_NAME", "ชื่อโปรแกรม")  
            ->display_as("MENU_PAGE_LINK", "ลิงค์โปรแกรม")  
            ->display_as("PARENT_ID", "กลุ่มโปรแกรม")  
            ->display_as("ICON", "ไอคอน")  
            ->set_relation('PARENT_ID', 'menu_page', 'MENU_PAGE_NAME', $where, 'MENU_PAGE_CODE')
            ->ORDER_BY("MENU_PAGE_CODE")
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
    
    public function _beforeDelete() {
        return FALSE;
    }
}
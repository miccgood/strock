<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Permission extends CS_Controller {

    public function __construct()
    {
            parent::__construct();
    }

    public function index()
    {
         try{
           $fieldArr = array('USER_GROUP_ID', 'MENU_PAGE_ID', 'IS_ADD', 'IS_EDIT', 'IS_DELETE');

//                $fieldIntArr = array('MATERIAL_PRICE','MATERIAL_BALANCE','BUDGET_YEAR');
//                $crud->set_theme('datatables');
            $this->crud->set_table('user_permission')
            ->set_subject('สิทธิ์เข้าใช้งาน')
//            ->set_relation_n_n('USER_PERMISSION_ID', 'USER_PERMISSION', 'MENU_PAGE', 'USER_GROUP_ID', 
//                    'MENU_PAGE_ID', 'MENU_PAGE_NAME', 'USER_PERMISSION_ID', 'MENU_PAGE.PARENT_ID IS NOT NULL')
            ->set_relation('USER_GROUP_ID', 'USER_GROUP', 'USER_GROUP_NAME')
            ->set_relation('MENU_PAGE_ID', 'MENU_PAGE', 'MENU_PAGE_NAME')
                    
            ->display_as('USER_GROUP_ID', 'กลุ่มผู้ใช้')
            ->display_as("MENU_PAGE_ID", "โปรแกรม")   
            ->display_as("IS_ADD", "เพิ่ม")
            ->display_as("IS_EDIT", "แก้ไข")
            ->display_as("IS_DELETE", "ลบ")
//            ->field_type("PASSWORD", "password", null, "")   
            ->columns($fieldArr)
            ->fields($fieldArr)
            ->field_style($fieldArr, array('width' => '500px'))
            ;

            $this->output();

        }catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());

            $output = $this->grocery_crud->render();

            $this->output($output);
        }
    }

//    public function clearBeforeInsertAndUpdate($array) {
//        $array = parent::clearBeforeInsertAndUpdate($array);
//        $userPermissionId = $array['USER_PERMISSION_ID'];
//        $parentIdArr = $this->m->getParentId($userPermissionId);
//        $array['USER_PERMISSION_ID'] = (empty($parentIdArr) ? array() : array_merge($array['USER_PERMISSION_ID'], $parentIdArr));
//        return $array;
//    }
    
}
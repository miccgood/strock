<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Material extends CS_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
             try{
                $fieldArr = array('MATERIAL_CODE', 'MATERIAL_NAME', 
                        'MATERIAL_DETAIL', 'MATERIAL_UNIT_ID', 
                        'MATERIAL_TYPE_ID', 'MATERIAL_PRICE', 
                        'MATERIAL_BALANCE', 'DEPARTMENT_ID',
                        'MONEY_TYPE_ID', 'SCIENCE_ID', 
                        'STORE_ID', 'BUDGET_YEAR');
                 
                $fieldNumArr = array('MATERIAL_PRICE');
                $fieldIntArr = array('MATERIAL_BALANCE','BUDGET_YEAR');
                
                
                $requiredArr = array('MATERIAL_CODE', 'MATERIAL_NAME', 
                        'MATERIAL_UNIT_ID', 
                        'MATERIAL_TYPE_ID', 'MATERIAL_PRICE', 
                        'MATERIAL_BALANCE', 'DEPARTMENT_ID',
                        'MONEY_TYPE_ID', 'SCIENCE_ID', 
                        'STORE_ID', 'BUDGET_YEAR');
                
                
                $this->crud->set_table('material')
                ->set_subject('วัสดุ')
                ->set_relation('MATERIAL_TYPE_ID', 'MATERIAL_TYPE', 'MATERIAL_TYPE_NAME')
                ->set_relation('MATERIAL_UNIT_ID', 'MATERIAL_UNIT', 'MATERIAL_UNIT_NAME')
//                ->set_relation('MATERIAL_STORE_ID', 'MATERIAL_STORE', 'MATERIAL_STORE_NAME')
                ->set_relation('MONEY_TYPE_ID', 'MONEY_TYPE', 'MONEY_TYPE_NAME')
                ->set_relation('DEPARTMENT_ID', 'DEPARTMENT', 'DEPARTMENT_NAME')
                ->set_relation('SCIENCE_ID', 'SCIENCE', 'SCIENCE_NAME')
                ->set_relation('STORE_ID', 'STORE', 'STORE_NAME')
                        
                ->display_as('MATERIAL_CODE', 'รหัสวัสดุ')
                ->display_as('MATERIAL_NAME', 'ชื่อวัสดุ')
                ->display_as('MATERIAL_DETAIL', 'รายละเอียดวัสดุ')
                ->display_as('MATERIAL_UNIT_ID', 'หน่วย')
                ->display_as('MATERIAL_TYPE_ID', 'ประเภทวัสดุ')
                ->display_as('MATERIAL_PRICE', 'ราคา')
                ->display_as('MATERIAL_BALANCE', 'คงเหลือ')
//                ->display_as('MATERIAL_STORE_ID', 'คลังวัสดุ')
                ->display_as('MATERIAL_DEPARTMENT_ID', 'หน่วยงาน')
                ->display_as('MONEY_TYPE_ID', 'ประเภทเงิน')
                ->display_as('DEPARTMENT_ID', 'หน่วยงาน')
                ->display_as('SCIENCE_ID', 'สาขา')
                ->display_as('STORE_ID', 'คลังวัสดุ')
                ->display_as('BUDGET_YEAR', 'ปีงบประมาณ')
                ->columns($fieldArr)
                ->fields($fieldArr)
                ->required_fields(array_merge($requiredArr, $fieldIntArr, $fieldNumArr))
                ->field_type('BUDGET_YEAR', 'year')
                ->field_style(array_merge($fieldIntArr, $fieldArr, $fieldNumArr), array('width' => '500px'))
                ->field_style($fieldIntArr, array('width' => '100px'))
                ->set_rules($fieldIntArr, null, 'integer|required')
                ->set_rules($fieldNumArr, null, 'numeric|required')
                ->unset_texteditor(array('MATERIAL_DETAIL','full_text'))
                ;
                        
                $this->output();

            }catch(Exception $e){
                show_error($e->getMessage().' --- '.$e->getTraceAsString());
                
                $output = $this->grocery_crud->render();

                $this->output($output);
            }
	}

	public function offices_management()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('offices');
			$crud->set_subject('Office');
			$crud->required_fields('city');
			$crud->columns('city','country','phone','addressLine1','postalCode');

			$output = $crud->render();

			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

	public function employees_management()
	{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('employees');
			$crud->set_relation('officeCode','offices','city');
			$crud->display_as('officeCode','Office City');
			$crud->set_subject('Employee');

			$crud->required_fields('lastName');

			$crud->set_field_upload('file_url','assets/uploads/files');

			$output = $crud->render();

			$this->_example_output($output);
	}

	public function customers_management()
	{
			$crud = new grocery_CRUD();

			$crud->set_table('customers');
			$crud->columns('customerName','contactLastName','phone','city','country','salesRepEmployeeNumber','creditLimit');
			$crud->display_as('salesRepEmployeeNumber','from Employeer')
				 ->display_as('customerName','Name')
				 ->display_as('contactLastName','Last Name');
			$crud->set_subject('Customer');
			$crud->set_relation('salesRepEmployeeNumber','employees','lastName');

			$output = $crud->render();

			$this->_example_output($output);
	}

	public function orders_management()
	{
			$crud = new grocery_CRUD();

			$crud->set_relation('customerNumber','customers','{contactLastName} {contactFirstName}');
			$crud->display_as('customerNumber','Customer');
			$crud->set_table('orders');
			$crud->set_subject('Order');
			$crud->unset_add();
			$crud->unset_delete();

			$output = $crud->render();

			$this->_example_output($output);
	}

	public function products_management()
	{
			$crud = new grocery_CRUD();

			$crud->set_table('products');
			$crud->set_subject('Product');
			$crud->unset_columns('productDescription');
			$crud->callback_column('buyPrice',array($this,'valueToEuro'));

			$output = $crud->render();

			$this->_example_output($output);
	}

	public function valueToEuro($value, $row)
	{
		return $value.' &euro;';
	}

	public function film_management()
	{
		$crud = new grocery_CRUD();

		$crud->set_table('film');
		$crud->set_relation_n_n('actors', 'film_actor', 'actor', 'film_id', 'actor_id', 'fullname','priority');
		$crud->set_relation_n_n('category', 'film_category', 'category', 'film_id', 'category_id', 'name');
		$crud->unset_columns('special_features','description','actors');

		$crud->fields('title', 'description', 'actors' ,  'category' ,'release_year', 'rental_duration', 'rental_rate', 'length', 'replacement_cost', 'rating', 'special_features');

		$output = $crud->render();

		$this->_example_output($output);
	}

	public function film_management_twitter_bootstrap()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('twitter-bootstrap');
			$crud->set_table('film');
			$crud->set_relation_n_n('actors', 'film_actor', 'actor', 'film_id', 'actor_id', 'fullname','priority');
			$crud->set_relation_n_n('category', 'film_category', 'category', 'film_id', 'category_id', 'name');
			$crud->unset_columns('special_features','description','actors');

			$crud->fields('title', 'description', 'actors' ,  'category' ,'release_year', 'rental_duration', 'rental_rate', 'length', 'replacement_cost', 'rating', 'special_features');

			$output = $crud->render();
			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

	function multigrids()
	{
		$this->config->load('grocery_crud');
		$this->config->set_item('grocery_crud_dialog_forms',true);
		$this->config->set_item('grocery_crud_default_per_page',10);

		$output1 = $this->offices_management2();

		$output2 = $this->employees_management2();

		$output3 = $this->customers_management2();

		$js_files = $output1->js_files + $output2->js_files + $output3->js_files;
		$css_files = $output1->css_files + $output2->css_files + $output3->css_files;
		$output = '<h1>List 1</h1>'.$output1->output.'<h1>List 2</h1>'.$output2->output.'<h1>List 3</h1>'.$output3->output;

		$this->_example_output((object)array(
				'js_files' => $js_files,
				'css_files' => $css_files,
				'output'	=> $output
		));
	}

	public function offices_management2()
	{
		$crud = new grocery_CRUD();
		$crud->set_table('offices');
		$crud->set_subject('Office');

		$crud->set_crud_url_path(site_url(strtolower(__CLASS__.'/'.__FUNCTION__)),site_url(strtolower(__CLASS__.'/multigrids')));

		$output = $crud->render();

		if($crud->getState() != 'list') {
			$this->_example_output($output);
		} else {
			return $output;
		}
	}

	public function employees_management2()
	{
		$crud = new grocery_CRUD();

		$crud->set_theme('datatables');
		$crud->set_table('employees');
		$crud->set_relation('officeCode','offices','city');
		$crud->display_as('officeCode','Office City');
		$crud->set_subject('Employee');

		$crud->required_fields('lastName');

		$crud->set_field_upload('file_url','assets/uploads/files');

		$crud->set_crud_url_path(site_url(strtolower(__CLASS__.'/'.__FUNCTION__)),site_url(strtolower(__CLASS__.'/multigrids')));

		$output = $crud->render();

		if($crud->getState() != 'list') {
			$this->_example_output($output);
		} else {
			return $output;
		}
	}

	public function customers_management2()
	{

		$crud = new grocery_CRUD();

		$crud->set_table('customers');
		$crud->columns('customerName','contactLastName','phone','city','country','salesRepEmployeeNumber','creditLimit');
		$crud->display_as('salesRepEmployeeNumber','from Employeer')
			 ->display_as('customerName','Name')
			 ->display_as('contactLastName','Last Name');
		$crud->set_subject('Customer');
		$crud->set_relation('salesRepEmployeeNumber','employees','lastName');

		$crud->set_crud_url_path(site_url(strtolower(__CLASS__.'/'.__FUNCTION__)),site_url(strtolower(__CLASS__.'/multigrids')));

		$output = $crud->render();

		if($crud->getState() != 'list') {
			$this->_example_output($output);
		} else {
			return $output;
		}
	}

}
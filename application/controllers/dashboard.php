<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CS_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
	}

	public function index()
	{
            
		$this->view("dashboard.php");
	}

}
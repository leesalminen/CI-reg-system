<?php

class Salesrep extends Application {

	
	function __construct()
	{
		parent::__construct();
		$this->load->library('grocery_CRUD'); 
		
	}
	
	function index()
	{
		 $crud = new grocery_CRUD();
 
  
    $crud->set_table('salesperson');
    $crud->set_subject('Sales Rep');

    $crud->required_fields('name');

	$crud->display_as('name','Sales Rep');
 	
   
   $output = $crud->render();
  	$this->load->view('header', $output);
    $this->load->view('salesrep_view', $output);
	$this->load->view('footer');
	
	}
	
	
}//end of extender
<?php

class Company extends CI_Controller {

	
	function __construct()
	{
		parent::__construct();
		$this->load->library('grocery_CRUD'); 
		
	}
	
	function index()
	{
		 $crud = new grocery_CRUD();
 
   // $crud->set_theme('datatables');
    $crud->set_table('company');
   $crud->set_theme('datatables');
    $crud->set_subject('Company');
 
  $crud->set_relation('salesrepid','salesperson','name');
  
  	$crud->display_as('companyname','Company Name');
 	$crud->display_as('salesrepid','Sales Rep');



   
   	$output = $crud->render();
   	$this->load->view('header',$output);
   	 $this->load->view('company_view', $output);
       	$this->load->view('footer');   	
	
	}

	




}
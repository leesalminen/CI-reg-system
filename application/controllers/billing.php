<?php

class Billing extends CI_Controller {

	
	function __construct()
	{
		parent::__construct();
		$this->load->library('grocery_CRUD'); 
		$this->load->helper('url');
		
	}
	
	function index()
	{
		 $crud = new grocery_CRUD();
 
   // $crud->set_theme('datatables');
    $crud->set_table('billing');
    $crud->set_theme('datatables');
    $crud->set_subject('Billing Contact');
 
    $crud->set_relation('companyid','company','companyname');
 	
 	$crud->display_as('companyid','Company Name');
 	$crud->display_as('attentionto','Attention To');
 	$crud->display_as('billingcontact','Billing Contact');
 	$crud->display_as('billingaddress','Billing Address');
 	$crud->display_as('billingaddress2','Billing Address 2');
 	$crud->display_as('billingcity','Billing City');
 	$crud->display_as('billingstate','Billing State');
 	$crud->display_as('billingzip','Billing Zip');
	
	$crud->required_fields('billingcontact');
	$crud->required_fields('billingaddress');
	$crud->required_fields('billingcity');
	$crud->required_fields('billingstate');
	$crud->required_fields('billingzip');



   
   $output = $crud->render();
  	$this->load->view('header',$output);
    $this->load->view('billing_view', $output);
    	$this->load->view('footer');   
	
	
	}

	




}
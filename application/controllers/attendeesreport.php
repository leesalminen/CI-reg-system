<?php

class AttendeesReport extends CI_Controller {

	
	function __construct()
	{
		parent::__construct();
		$this->load->library('grocery_CRUD'); 
		
	}
	
	function index()
	{
		 $crud = new grocery_CRUD();
		//  $crud->where('status','active');
 
   // $crud->set_theme('datatables');
    $crud->set_table('enrollment');
   	$crud->set_theme('datatables');
    $crud->set_subject('Attendees');
    
   
    $crud->set_relation('companyid','company','companyname');
    $crud->set_relation('billingid','billing','billingcontact');
    
   
    
    
  	$crud->display_as('companyid','Company');
	$crud->display_as('billingid','Billing Contact');
 	$crud->display_as('firstname','First Name');
 	$crud->display_as('lastname','Last Name');
 	$crud->display_as('middleinitial','Middle Initial');
 	$crud->display_as('ccemail','CC-Email');



   
   	$output = $crud->render();
   	
      	
   	//load views
   	$this->load->view('header',$output);
   	 $this->load->view('attendees_view', $output);
       	$this->load->view('footer');   	
	
	}





}
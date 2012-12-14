<?php

class Classschedule extends Application {

	
	function __construct()
	{
		parent::__construct();
		$this->load->library('grocery_CRUD'); 
		$this->load->library('ag_auth');

		
	}
	
	function index()
	{
	if(logged_in()) {
		 $crud = new grocery_CRUD();
		 
		 
   // $crud->set_theme('datatables');
    $crud->set_table('class_schedule');
    $crud->set_theme('datatables');
    $crud->set_subject('Dates');
 
    $crud->set_relation('classtitleid','class_titles','classname');
    $crud->set_relation('instructor','instructors','instructor_name');
    
    $crud->required_fields(array('classtitleid','startdate','enddate','duration','laptops','type','cancelled','location','instructor'));
    
    	$crud->display_as('classtitleid','Class');
    	$crud->display_as('startdate','Start Date');
 	   $crud->display_as('enddate','End Date');
 	   $crud->display_as('howmanylaptops','Number of Laptops');
 	   $crud->display_as('laptops','Laptops Needed?');
 	   $crud->display_as('cancelled','Class Cancelled?');
 	   
 	   $crud->order_by('startdate');
   	$output = $crud->render();
   	

   	
   	$this->load->view('header', $output);
    $this->load->view('classschedule_view', $output);
   	$this->load->view('footer');
 	} else { $this->login();}
	}
	
	
	
	
	
}

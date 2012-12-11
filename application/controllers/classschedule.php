<?php

class Classschedule extends CI_Controller {

	
	function __construct()
	{
		parent::__construct();
		$this->load->library('grocery_CRUD'); 
		
	}
	
	function index()
	{
		 $crud = new grocery_CRUD();
 
   // $crud->set_theme('datatables');
    $crud->set_table('class_schedule');
    $crud->set_theme('datatables');
    $crud->set_subject('Dates');
 
    $crud->set_relation('classtitleid','class_titles','classname');
    
    	$crud->display_as('classtitleid','Class');
    	$crud->display_as('startdate','Start Date');
 	   $crud->display_as('enddate','End Date');
 	   $crud->display_as('howmanylaptops','Number of Laptops');
 	   
 	   
 	   
   	$output = $crud->render();
   	
   	$this->load->view('header', $output);
    $this->load->view('classschedule_view', $output);
   	$this->load->view('footer');
 		
	}
	
	
	
	
	
}

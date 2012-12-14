<?php

class Transcript extends Application {

	
	function __construct()
	{
		parent::__construct();
		$this->load->library('grocery_CRUD'); 
				$this->load->library('ag_auth');

	}
	
	function index()
	{
	if(logged_in())
		{
		 $crud = new grocery_CRUD();
 
   // $crud->set_theme('datatables');
    $crud->set_table('enrollment');
   $crud->set_theme('datatables');
    $crud->set_subject('');
    //hide add, edit, delete buttons
            $crud->unset_add();
            $crud->unset_edit();
            $crud->unset_delete();
            
                 
   //set student relation with concatenated first and last name
    $crud->set_relation('studentid','student','{firstname} {lastname}');
    $crud->set_relation('companyid','company','companyname');
   //set relation to class titles
    $crud->set_relation('classid','class_titles','classname');
    //set relation to class dates
    $crud->set_relation('datesid','class_schedule','startdate');
 
 //hide billingid column
      $crud->unset_columns('billingid', 'po','status');
   
  
	$crud->display_as('studentid','Student Name');
 	//$crud->display_as('billingid','Company');
 	$crud->display_as('classid','Course Title');
 	$crud->display_as('datesid','Class Date');
 	//$crud->display_as('po','CC-Email');
		$crud->display_as('studentid','Student Name');
		$crud->display_as('checkedIn','Checked In?');
		$crud->display_as('userCancel','Student Cancel?');

   		$crud->display_as('noshow','No Show?');

   	$output = $crud->render();
   	$this->load->view('header',$output);
   	 $this->load->view('transcript_view', $output);
       	$this->load->view('footer');   	
       	
       	} else {
       	
       	$this->login();
       	}
	
	}

	




}
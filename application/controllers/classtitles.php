<?php

class Classtitles extends CI_Controller {

	
	function __construct()
	{
		parent::__construct();
		$this->load->library('grocery_CRUD'); 
		
	}
	
	function index()
	{
		 $crud = new grocery_CRUD();
 
  
    $crud->set_table('class_titles');
    $crud->set_theme('datatables');
    $crud->set_subject('Course Title');
    
    $crud->display_as('classname','Course Title');



   
   $output = $crud->render();
  	$this->load->view('header', $output);
    $this->load->view('coursetitle_view', $output);
	$this->load->view('footer');
	
	}
	
	
}//end of extender

<?php

class Instructors extends Application {

	
	function __construct()
	{
		parent::__construct();
		$this->load->library('grocery_CRUD'); 
		
	}
	
	function index()
	{
		 $crud = new grocery_CRUD();
 
    //$crud->set_theme('datatables');
    $crud->set_table('instructors');
    $crud->set_subject('Instructor');
     
    
    	$crud->display_as('instructor_name','Instructor Name');
 	   $crud->display_as('status','Instructor Status');
 	   $crud->required_fields('instructor_name','status');
 	   
   	$output = $crud->render();

   	
   	$this->load->view('header',$output);
    $this->load->view('instructors_view', $output);
   	$this->load->view('footer');
 		
	}
	

//get billing contact for sub dropdown
	function getInstructors() {
	//$billingid = $this->uri->segment(3);
		
		$this->db->select("*")
				 ->from('instructors')
				 ->where('status', '1');
		$db = $this->db->get();
		
		$array = array();
		foreach($db->result() as $row):
			$array[] = array("value" => $row->instructor_name, "property" => $row->instructor_name);
		endforeach;
		
		echo json_encode($array);
		exit;     
	
	}
	
	
	
	
}

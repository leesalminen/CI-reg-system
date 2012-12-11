<?php

class Enrollment extends CI_Controller {

	
	function __construct()
	{
		parent::__construct();
		$this->load->library('grocery_CRUD'); 
		
	}
	
	function index()
	{
		 $crud = new grocery_CRUD();
 
  
    $crud->set_table('enrollment');
    $crud->set_theme('datatables');
    $crud->set_subject('Enrollment');
    $name = 'firstname' . 'lastname';
    $crud->set_relation('companyid','company','companyname');
    $crud->set_relation('studentid','student','{firstname} {lastname}');
    $crud->set_relation('billingid','billing', 'billingcontact');
    $crud->set_relation('classid','class_titles', 'classname');
    $crud->set_relation('datesid','class_schedule', 'startdate');
    

   
    //$crud->display_as('classname','Course Title', ");



   
  	 $output = $crud->render();
  	 
  	 //start dependent dropdown
  	 //DEPENDENT DROPDOWN SETUP
	$dd_data = array(
    //GET THE STATE OF THE CURRENT PAGE - E.G LIST | ADD
    'dd_state' =>  $crud->getState(),
    //SETUP YOUR DROPDOWNS
    //Parent field item always listed first in array, in this case countryID
    //Child field items need to follow in order, e.g stateID then cityID
    'dd_dropdowns' => array('companyid','studentid','billingid'), array('classid', 'datesid'),
        //SETUP URL POST FOR EACH CHILD
    //List in order as per above
    'dd_url' => array('', site_url().'/enrollment/getStudent/', site_url().'/enrollment/getBillingContact/', site_url().'/enrollment/getdates/'),
    //LOADER THAT GETS DISPLAYED NEXT TO THE PARENT DROPDOWN WHILE THE CHILD LOADS
    'dd_ajax_loader' => base_url().'ajax-loader.gif',
	
	//$output->dropdown_setup = $dd_data;
  	 
  	 
  	 //end dependent dropdown 1
  	 
  	 
  	  //start dependent dropdown 2
  	 //DEPENDENT DROPDOWN SETUP
	$dd_data2 = array(
    //GET THE STATE OF THE CURRENT PAGE - E.G LIST | ADD
    'dd_state' =>  $crud->getState(),
    //SETUP YOUR DROPDOWNS
    //Parent field item always listed first in array, in this case countryID
    //Child field items need to follow in order, e.g stateID then cityID
    'dd_dropdowns' => array('classid', 'datesid'),
        //SETUP URL POST FOR EACH CHILD
    //List in order as per above
    'dd_url' => array('', site_url(). '/enrollment/getdates/'),
    //LOADER THAT GETS DISPLAYED NEXT TO THE PARENT DROPDOWN WHILE THE CHILD LOADS
    'dd_ajax_loader' => base_url().'ajax-loader.gif'
	));
	
	
	$output->dropdown_setup = $dd_data;
	$output2->dropdown_setup = $dd_data2;
	
	
	

  	 
  	 //end of dropdown2

	//$this->output->enable_profiler(TRUE);
  	$this->load->view('header', $output);
    $this->load->view('enrollment_view', $output);
   //$this->load->view('enrollment_view', $output2);
	$this->load->view('footer');
	
	}
	
	//get dependent student dropdown
	function getStudent() {
	$studentid = $this->uri->segment(3);
		
		$this->db->select("*")
				 ->from('student')
				 ->where('companyid', $studentid);
		$db = $this->db->get();
		
		$array = array();
		foreach($db->result() as $row):
			$array[] = array("value" => $row->id, "property" => $row->firstname);
			
		endforeach;
		
		echo json_encode($array);
		exit;     
	
	}
	
	//get billing contact for sub dropdown
	function getBillingContact() {
	$billingid = $this->uri->segment(3);
		
		$this->db->select("*")
				 ->from('student')
				 ->where('id', $billingid);
		$db = $this->db->get();
		
		$array = array();
		foreach($db->result() as $row):
			$array[] = array("value" => $row->id, "property" => $row->billingid);
		endforeach;
		
		echo json_encode($array);
		exit;     
	
	}
	
	function getdates() {
	$classtitleid = $this->uri->segment(3);
		
		$this->db->select("*")
				 ->from('class_schedule')
				 ->where('classtitleid', $classtitleid);
		$db = $this->db->get();
		
		$array = array();
		foreach($db->result() as $row):
			$array[] = array("value" => $row->id, "property" => $row->startdate);
		endforeach;
		
		echo json_encode($array);
		exit;     
	
	}

	
	
}//end of extender

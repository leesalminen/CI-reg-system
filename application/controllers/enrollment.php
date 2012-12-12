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
    
	$crud->unset_add_fields('checkedIn');
	$crud->unset_columns('checkedIn');
	
	 $crud->display_as('companyid','Company');
	$crud->display_as('studentid','Student Name');
 	$crud->display_as('classid','Class Name');
 	$crud->display_as('datesid','Class Date');
 	$crud->display_as('status','Class Active?');
 	$crud->display_as('billingid','Billing Contact');
 	$crud->display_as('po','Purchase Order #');


   
    //$crud->display_as('classname','Course Title', ");



   
  	 $output = $crud->render();
  	 
  	$dd_data = array(
    //GET THE STATE OF THE CURRENT PAGE - E.G LIST | ADD
    'dd_state' =>  $crud->getState(),
    //SETUP YOUR DROPDOWNS
    //Parent field item always listed first in array, in this case countryID
    //Child field items need to follow in order, e.g stateID then cityID
    'dd_dropdowns' => array('companyid','studentid','billingid'),
        //SETUP URL POST FOR EACH CHILD
    //List in order as per above
    'dd_url' => array('', site_url().'/enrollment/getStudent/', site_url().'/enrollment/getBillingContact/'),
    //LOADER THAT GETS DISPLAYED NEXT TO THE PARENT DROPDOWN WHILE THE CHILD LOADS
    'dd_ajax_loader' => base_url().'ajax-loader.gif');
	
	$output->dropdown_setup = $dd_data;
	
	
	//print_r($dd_data);
	

	//$this->output->enable_profiler(TRUE);
  	$this->load->view('header', $output);
    $this->load->view('enrollment_view', $output);
  // $this->load->view('enrollment_view', $output2);
  // $this->load->view('enrollment_view', $finalOutput);
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
			$fullName = $row->lastname. ', ' .$row->firstname;
			$array[] = array("value" => $row->id, "property" => $fullName);
			
		endforeach;
		
		echo json_encode($array);
		exit;     
	
	}
	
	//get billing contact for sub dropdown
	function getBillingContact() {
	$billingid = $this->uri->segment(3);
		
		/* $this->db->select("*")
				 ->from('student')
				 ->where('id', $billingid); */
				 
		$sql = "SELECT * FROM `student` LEFT JOIN `billing` as billing ON `billing`.`id` = `student`.`billingid` WHERE `student`.`id` = '" .$billingid. "'";
 
		$db = $this->db->query($sql);
		
		$array = array();
		foreach($db->result() as $row):
			$array[] = array("value" => $row->id, "property" => $row->billingcontact);
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

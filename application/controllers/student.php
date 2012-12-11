<?php

class Student extends CI_Controller {

	
	function __construct()
	{
		parent::__construct();
		$this->load->library('grocery_CRUD'); 
		
	}
	
	function index()
	{
		 $crud = new grocery_CRUD();
 
   // $crud->set_theme('datatables');
    $crud->set_table('student');
   $crud->set_theme('datatables');
    $crud->set_subject('Student');
    
   
    $crud->set_relation('companyid','company','companyname');
    $crud->set_relation('billingid','billing','billingcontact');
    
   
    
    
  	$crud->display_as('companyid','Company');
	$crud->display_as('billingid','Billing Contact');
 	$crud->display_as('firstname','First Name');
 	$crud->display_as('lastname','Last Name');
 	$crud->display_as('middleinitial','Middle Initial');
 	$crud->display_as('ccemail','CC-Email');



   
   	$output = $crud->render();
   	
   	 //start dependent dropdown
  	 //DEPENDENT DROPDOWN SETUP
	$dd_data = array(
    //GET THE STATE OF THE CURRENT PAGE - E.G LIST | ADD
    'dd_state' =>  $crud->getState(),
    //SETUP YOUR DROPDOWNS
    //Parent field item always listed first in array, in this case countryID
    //Child field items need to follow in order, e.g stateID then cityID
    'dd_dropdowns' => array('companyid','billingid'),
    //SETUP URL POST FOR EACH CHILD
    //List in order as per above
    'dd_url' => array('', site_url().'/student/getBillingContact/', site_url().'/student/getdates/'),
    //LOADER THAT GETS DISPLAYED NEXT TO THE PARENT DROPDOWN WHILE THE CHILD LOADS
    'dd_ajax_loader' => base_url().'ajax-loader.gif'
	);
	$output->dropdown_setup = $dd_data;
  	 
  	 
  	 //end dependent dropdown
   	
   	
   	//load views
   	$this->load->view('header',$output);
   	 $this->load->view('student_view', $output);
       	$this->load->view('footer');   	
	
	}

//get billing contact for sub dropdown
	function getBillingContact() {
	$billingid = $this->uri->segment(3);
		
		$this->db->select("*")
				 ->from('billing')
				 ->where('companyid', $billingid);
		$db = $this->db->get();
		
		$array = array();
		foreach($db->result() as $row):
			$array[] = array("value" => $row->id, "property" => $row->billingcontact);
		endforeach;
		
		echo json_encode($array);
		exit;     
	
	}
	
/* this would be if you want another dependent dropdown

function get_company()
	{
		$countryID = $this->uri->segment(3);
		
		$this->db->select("*")
				 ->from('company')
				 ->where('ID', $ID);
		$db = $this->db->get();
		
		$array = array();
		foreach($db->result() as $row):
			$array[] = array("value" => $row->id, "property" => $row->companyname);
		endforeach;
		
		echo json_encode($array);
		exit;
	}
	*/





}
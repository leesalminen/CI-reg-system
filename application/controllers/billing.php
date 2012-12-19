<?php

class Billing extends Application {

	
	function __construct()
	{
		parent::__construct();
		$this->load->library('grocery_CRUD'); 
		$this->load->helper('url');
		$this->load->library('ag_auth');
		
	}
	
	function index()
	{
	
	if($this->ag_auth->logged_in()) {
		$crud = new grocery_CRUD();
 		$state_list = array('AL'=>"Alabama",
                'AK'=>"Alaska",  
                'AZ'=>"Arizona",  
                'AR'=>"Arkansas",  
                'CA'=>"California",  
                'CO'=>"Colorado",  
                'CT'=>"Connecticut",  
                'DE'=>"Delaware",  
                'DC'=>"District Of Columbia",  
                'FL'=>"Florida",  
                'GA'=>"Georgia",  
                'HI'=>"Hawaii",  
                'ID'=>"Idaho",  
                'IL'=>"Illinois",  
                'IN'=>"Indiana",  
                'IA'=>"Iowa",  
                'KS'=>"Kansas",  
                'KY'=>"Kentucky",  
                'LA'=>"Louisiana",  
                'ME'=>"Maine",  
                'MD'=>"Maryland",  
                'MA'=>"Massachusetts",  
                'MI'=>"Michigan",  
                'MN'=>"Minnesota",  
                'MS'=>"Mississippi",  
                'MO'=>"Missouri",  
                'MT'=>"Montana",
                'NE'=>"Nebraska",
                'NV'=>"Nevada",
                'NH'=>"New Hampshire",
                'NJ'=>"New Jersey",
                'NM'=>"New Mexico",
                'NY'=>"New York",
                'NC'=>"North Carolina",
                'ND'=>"North Dakota",
                'OH'=>"Ohio",  
                'OK'=>"Oklahoma",  
                'OR'=>"Oregon",  
                'PA'=>"Pennsylvania",  
                'RI'=>"Rhode Island",  
                'SC'=>"South Carolina",  
                'SD'=>"South Dakota",
                'TN'=>"Tennessee",  
                'TX'=>"Texas",  
                'UT'=>"Utah",  
                'VT'=>"Vermont",  
                'VA'=>"Virginia",  
                'WA'=>"Washington",  
                'WV'=>"West Virginia",  
                'WI'=>"Wisconsin",  
                'WY'=>"Wyoming");
                
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
 //	$crud->display_as('billingzip','Billing Zip');
 	
 	$crud->field_type('billingstate','dropdown',$state_list);
	
	$crud->required_fields(array('billingcontact','billingaddress','billingcity','billingstate','billingzip','billingemail'));

   
   $output = $crud->render();
  	$this->load->view('header',$output);
    $this->load->view('billing_view', $output);
    	$this->load->view('footer');   
	
	} else {  $this->login(); }
	
	}

	




}
<?php

class Company extends CI_Controller {

function __construct()
	{
 		parent::__construct();
		$this->load->library('form_validation');
		$this->load->database();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->model('company_model');
	}

	public function index()   
	{
	$this->load->model('Company_model');
		
		$data['stuff'] = $this->Company_model->getCompany();
		
		$this->load->view('companyview', $data);	
		
	}

    public function insertCompany()
    {
   	$this->form_validation->set_rules('company', 'company', 'required');
		if ($this->form_validation->run() === FALSE)
	{
		$this->load->view('newcompany');	
		
	}
	else
	{
		$this->load->model('Company_model');
		$this->Company_model->insertCompany();
		$this->load->view('companysuccess');
	}
    
    
    }
    
    public function insertMore()
    {
    $this->form_validation->set_rules('company', 'company', 'required');
		if ($this->form_validation->run() === FALSE)
	{
		$this->load->view('companymore');	
		
	}
	else
	{
		$this->load->model('Company_model');
		
		$this->Company_model->insertMore();
		$this->load->view('companysuccess');
	}
    
    }

	public function moreTables()
	{
		$this->load->model('Company_model');
		$data['two'] = $this->Company_model->moreTables();
		$this->load->view('moretablesview', $data);
	}


}/*end of class extender*/
?>
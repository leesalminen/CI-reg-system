<?php
class Company_model extends CI_Model {

	var $companyName = '';

	public function __construct()
		{
		$this->load->database();
		}


	function getCompany()
		{
		$query = $this->db->get('company');
		return $query->result_array();

		}
		
	public function insertCompany()
		{
		
			$data = array(
				
				'companyname' => $this->input->post('company')

	   		);
			
				return $this->db->insert('company', $data);
		
		
		}
		
	public function moreTables()
	{
		$this->db->from('salesperson');
		$this->db->join('company', 'company.salespersonid = salesperson.id');
		$this->db->order_by('salesperson.id', 'asc');
		$query = $this->db->get(); 
		return $query->result_array();
	}
	
	
	public function insertMore()
	{			
				$company['companyname'] = $this->input->post('company');    
    			
    			$sales = array(
    			'name' => $this->input->post('salesrep')
    			);
       
       			$this->db->insert('salesperson', $sales);
      			$company['salespersonid'] = $this->db->insert_id();
      		 	$this->db->insert('company', $company);
	}
	   

	
	

}//end of model close
?>
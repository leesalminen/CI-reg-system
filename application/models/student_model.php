<?php
class Student_model extends CI_Model {

	public function getDropDown()
	{
		$this->db->select('id, companyname');
		$this->db->from('company');
		
		$company = $this->db->get();
		return $company;
	}
		
		
	public function insertStudent()
	{
		
	$data = array(
		'stFirstName' => $this->input->post('fname_post')
	
	   );
	
	return $this->db->insert('table_name', $data);
				
		
		
	}	
		



}//end of model close
?>
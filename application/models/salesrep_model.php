<?php
class Salesrep_model extends CI_Model {

	//gets all reps
	public function getReps()
	{
	   		$query = $this->db->get('salesperson');       
			return $query->result_array();   
	
	}


	//insert new reps
	public function newRep()
	{	
		$data = array(
		'name' => $this->input->post('repname_post')
	
	   		);
	
	    return $this->db->insert('salesperson', $data);
	
	}
	
	//update reps
	public function updaterep()
	{
		$data = array(
               'title' => $title,
               'name' => $name,
               'date' => $date
            );

		$this->db->where('id', $id);
		$this->db->update('mytable', $data); 
	
	
	
	
	}



}//end of model close
?>
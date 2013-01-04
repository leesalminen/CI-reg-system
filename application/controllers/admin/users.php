<?php

class Users extends Application
{
	
	public function __construct()
	{
		parent::__construct();
		$this->ag_auth->restrict('admin'); // restrict this controller to admins only
	}
	
	public function manage()
	{
	    $this->load->library('table');		
			
		$data = $this->db->get($this->ag_auth->config['auth_user_table']);
		$result = $data->result_array();
		$this->table->set_heading('Username', 'Email', 'Actions'); // Setting headings for the table
		
		foreach($result as $value => $key)
		{
			$actions = anchor("admin/users/delete/".$key['id']."/", "Delete"); // Build actions links
			$this->table->add_row($key['username'], $key['email'], $actions); // Adding row to table
		}
		
		$this->ag_auth->view('users/manage'); // Load the view
	}
	
	public function delete($id)
	{
		$this->db->where('id', $id)->delete($this->ag_auth->config['auth_user_table']);
		$this->ag_auth->view('users/delete_success');
	}
	
	public function changepassword() {
	
	$output['js_files'] = array('//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js','/css/jquery.pnotify.min.js');
		$output['css_files'] = array('http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css','/css/jquery.pnotify.default.css','/css/jquery.pnotify.default.icons.css');
	
	$this->load->helper('ag_auth');
	$output['username'] = username();
	$this->load->view('header',$output);
	$this->load->view('changepassword',$output);
	$this->load->view('footer');
	}
	
	public function doChangePassword() {
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	$passwordConfirm = $_POST['confirmPassword'];
	$email = $_POST['email'];
	
	if($password === $passwordConfirm) {
		
		$this->load->model('ag_auth_model');
	
		return json_encode($this->ag_auth_model->changepassword($username, $password, $email));
	
	} else {
	
		echo json_encode('error1');
	
	}
	
	}
	
	// WOKRING ON PROPER IMPLEMENTATION OF ADDING & EDITING USER ACCOUNTS
}

?>
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
		
				$tmpl = array ( 'table_open'  => '<style type="text/css">body{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;}#upcomingClasses{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size:12px;background:#fff;width:50%;border-collapse:collapse;text-align:left;}#upcomingClasses th{font-size:14px;font-weight:normal;color:#039;border-bottom:2px solid #6678b1;padding:10px 8px;}#upcomingClasses td{border-left:1px solid #ccc; border-right:1px solid #ccc;border-bottom:1px solid #ccc;color:#669;padding:6px 8px;}#upcomingClasses tbody tr:hover td{color:#009;}.signature{width:250px;}.largeCheckBox{width:25px;height:25px;margin:0 auto;}</style><table id="upcomingClasses">', 'table_close' => '</table>' );
				
						$this->table->set_template($tmpl);


		$result = $data->result_array();
		$this->table->set_heading('Username', 'Email', 'Actions'); // Setting headings for the table
		
		foreach($result as $value => $key)
		{
			//CUSTOM FOR CAMPUS LINC
			if($key['id'] === '1' || $key['id'] === '12') { $actions = ''; } else {
			$actions = anchor("admin/users/delete/".$key['id']."/", "Delete"); // Build actions links	
			}
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
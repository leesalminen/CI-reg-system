<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends Application {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	
	function __construct()
	{
		parent::__construct();		
		$this->load->helper('html');
		$this->load->library('ag_auth');

	}
	
	public function index()
	{
		if(logged_in()) {
			
			redirect('/checkin', 'location', 301);
			
		} else {
		
		$this->login();
		}
	}
	
	public function checkLoginStatus() {
		
		$diff = time() - $this->session->userdata('last_activity');
		
		if($diff > 7040) {
			
			echo '0';				
			
		} else {
			
			echo '1';
			
		}

			
	}
		

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
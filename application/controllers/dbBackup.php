<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class dbBackup extends Application {
	
	function __construct()
	{
		parent::__construct();		
		$this->load->helper('html');
		$this->load->library('ag_auth');
	}
	
	public function index()
	{
		if(logged_in()) {
			
			$this->load->view('header');
			$this->load->view('dbBackup');
			$this->load->view('footer');
			
		} else {
		
		$this->login();
		}
	}
	
	public function doBackup() {
		
		if(logged_in()) {
		
		$this->load->helper('ag_auth');
			
		$this->load->dbutil();
		
		$prefs = array(
                'format'      => 'zip',             // gzip, zip, txt
                'filename'    => 'regSystemBackup.sql',    // File name - NEEDED ONLY WITH ZIP FILES
                'add_drop'    => TRUE,              // Whether to add DROP TABLE statements to backup file
                'add_insert'  => TRUE,              // Whether to add INSERT data to backup file
                'newline'     => "\n"               // Newline character used in backup file
              );

		$backup =& $this->dbutil->backup($prefs); 

		$this->load->helper('file');
		$fileName = '/tmp/dbBackup' . date('Y-m-d-H-i-s') . '.zip';
		write_file($fileName, $backup); 
		
		log_message('error', 'dB Backup Performed by ' . username() . ' on ' . date('m-d-Y H:i:s') . '.');
		$this->load->library('email');
		
		$this->email->from('shaune@campuslinc.com', 'Shaune Dwyer');
		$this->email->to('shaune@campuslinc.com'); 
		$this->email->bcc('leesalminen@gmail.com'); 
		
		$this->email->subject('DB Backup Performed');
		$this->email->message('A DB Backup was performed by ' . username() . ' on ' . date('m-d-Y H:i:s') . '.');	

		$this->email->send();
		
		$this->load->helper('download');
		force_download('/dbBackup' . date('Y-m-d-H-i-s') . '.zip', $backup);
			
			
		} else {
			
			$this->login();
		}
		
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
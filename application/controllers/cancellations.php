<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cancellations extends Application {

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
	if(logged_in())
		{
		
		
		$output['js_files'] = array('//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js','/css/jquery.pnotify.min.js');
		$output['css_files'] = array('/assets/jquery-ui-1.9.2.custom.min.css','/css/jquery.pnotify.default.css','/css/jquery.pnotify.default.icons.css');

		
		$this->load->view('header',$output);
   	    $this->load->view('cancellations');
		$this->load->view('footer');

		}
		else
		{
			$this->login();
		}		
		//$this->login();
	}
	
		public function getEnrollmentsForClass() {
	
	$date = $_POST['datepicker'];
	$course = $_POST['courses'];	
	$this->load->database();
	$this->load->library('table');

	
	$sql = "SELECT student.firstname,student.lastname,enrollment.checkedIn,enrollment.noshow,enrollment.userCancel, enrollment.id as enrollmentid, company.companyname, class_schedule.startdate FROM enrollment
LEFT JOIN student as student on student.id = enrollment.studentid
LEFT JOIN class_schedule as class_schedule on class_schedule.id = enrollment.datesid
LEFT JOIN company as company on company.id = enrollment.companyid
WHERE class_schedule.id = \"" .$course. "\"
AND userCancel = '0'
AND checkedIn = '0'
AND noshow = '0'
ORDER BY lastname
";


	$query = $this->db->query($sql);
	
	$tmpl = array ( 'table_open'  => '<style type="text/css">body{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;}p.liveButton{width:100%;height:100%;line-height:26px;padding:0;margin:0;}.green{background-color:#CFC;}.liveButton{text-align:center;margin:0;padding:0;}#checkIn{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size:12px;background:#fff;width:100%;border-collapse:collapse;text-align:left;}#checkIn th{font-size:14px;font-weight:normal;color:#039;border-bottom:2px solid #6678b1;padding:10px 8px;}#checkIn td{border-left:1px solid #ccc; border-right:1px solid #ccc;border-bottom:1px solid #ccc;color:#669;padding:5px 4px;}#checkIn tbody tr:hover{background-color:#eee;}#checkIn tbody tr:hover td{color:#009;}.signature{width:250px;}.largeCheckBox{width:25px;height:25px;margin:0 auto;}</style><div style="width:100%;height:100%;"><table id="checkIn">', 'table_close' => '</table></div>' );

	$this->table->set_template($tmpl);


	
	$this->table->set_heading('Cancel Enrollment','Full Name', 'Checked In?', 'Student Cancel?', 'No Show?');	

	$array = array();
		foreach($query->result() as $row){
			$array[] = $row;	
		
		}	
	foreach($array as $row) {
		
		if($row->checkedIn == '1') { $checkedIn = 'Yes'; } else { $checkedIn = 'No'; }
	  	if($row->noshow == '1') { $noShow = 'Yes';} else { $noShow = 'No'; }
	  	if($row->userCancel == '1') { $studentCancel = 'Yes';} else { $studentCancel = 'No'; }

	    $fullname = $row->lastname. ', ' .$row->firstname;
	   // $this->table->add_row('<input type="checkbox" id="checkbox' .$row->enrollmentid. '" value="' .$row->enrollmentid. '" name="checkbox' .$row->enrollmentid. '" class="checkbox" />',$fullname, $checkedIn, $studentCancel, $noShow);
	   
	   $this->table->add_row('<p style="text-align:center;margin:0;padding:0;"><a href="#" id="' .$row->enrollmentid. '" onclick="cancelEnrollment(' .$row->enrollmentid. ');return false;">Cancel Enrollment</a></p>',$fullname, $checkedIn, $studentCancel, $noShow);

	    
	}
	
	$table = $this->table->generate();
	
	echo json_encode($table);

	}
	
	public function cancelEnrollment() {
		$this->load->database();

		$id = $_POST['id'];
		
		$sql = 'UPDATE enrollment SET checkedIn = "0", noshow = "0", userCancel = "1" WHERE id = "' .$id. '" LIMIT 1';
		
		if($this->db->query($sql)) {
		
		echo json_encode('ok');
		
		} else { echo json_encode('error'); }
	
	}
	
	
		
		

	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
<?php

class Checkin extends Application {

	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url'); 
		$this->load->library('ag_auth');
		$this->load->helper('ag_auth');
		
	}
	
	function index()
	{
	if(logged_in()) {
		$today = date('Y-m-d');
		$this->load->database();
		$this->load->helper('html');
		$this->load->library('table');
		//CHANGE SQL FOR LIVE DATE
		

$sql = 'SELECT student.firstname,student.lastname,class_titles.classname, enrollment.id AS enrollmentid, enrollment.checkedIn, enrollment.userCancel,enrollment.noshow,class_schedule.startdate,company.companyname AS companyname,enrollment.companyid,salesperson.name as salesrepname FROM enrollment
LEFT JOIN student as student ON student.id = enrollment.studentid
LEFT JOIN class_titles as class_titles ON class_titles.id = enrollment.classid
LEFT JOIN class_schedule as class_schedule ON class_schedule.id = enrollment.datesid
LEFT JOIN company as company ON company.id = enrollment.companyid
LEFT JOIN salesperson as salesperson on salesperson.id = company.salesrepid
WHERE class_schedule.cancelled = "No"
AND startdate = "' .$today. '"
ORDER BY student.lastname
';

	//WHERE class_schedule.cancelled = "No" AND enrollment.userCancel = "0"
		$query = $this->db->query($sql);
		
				
		$this->table->set_heading('Full Name', 'Class Name', 'Company Name', 'Account Executive', 'Checked In?', 'Cancelled?', 'No Show?');

		$tmpl = array ( 'table_open'  => '<style type="text/css">body{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;}p.liveButton{width:100%;height:100%;line-height:26px;padding:0;margin:0;}.green{background-color:#CFC;}.liveButton{text-align:center;margin:0;padding:0;}#checkIn{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size:12px;background:#fff;width:100%;border-collapse:collapse;text-align:left;}#checkIn th{font-size:14px;font-weight:normal;color:#039;border-bottom:2px solid #6678b1;padding:10px 8px;}#checkIn td{border-left:1px solid #ccc; border-right:1px solid #ccc;border-bottom:1px solid #ccc;color:#669;padding:5px 4px;}#checkIn tbody tr:hover{background-color:#eee;}#checkIn tbody tr:hover td{color:#009;}.signature{width:250px;}.largeCheckBox{width:25px;height:25px;margin:0 auto;}</style><div style="width:100%;height:100%;"><table id="checkIn">', 'table_close' => '</table></div>' );

		$this->table->set_template($tmpl);

		
		if ($query->num_rows() > 0)
			{
				$numRows = $query->num_rows();
	   			foreach ($query->result() as $row)
	  			{
	  				$fullname = $row->lastname. ', ' .$row->firstname;
				//var_dump($row);
	  				if($row->checkedIn == '1') {
	      			
	      			$this->table->add_row(array($fullname, $row->classname, $row->companyname,  $row->salesrepname, '<p class="liveButton green" id="checkInP' .$row->enrollmentid. '"><a href="#" class="liveButton" onclick="checkInChange(' .$row->enrollmentid. ');return false;" id="checkIn' .$row->enrollmentid. '">Check In</a></p>', '<p class="liveButton" id="cancelP' .$row->enrollmentid. '"><a href="#" class="liveButton" onclick="cancelChange(' .$row->enrollmentid. ');return false;" id="cancel' .$row->enrollmentid. '">Cancel</a></p>', '<p class="liveButton" id="noShowP' .$row->enrollmentid. '"><a href="#" class="liveButton" onclick="noShowChange(' .$row->enrollmentid. ');return false;" id="noShow' .$row->enrollmentid. '">No Show</a></p>'));
	      			} else if ($row->userCancel == '1') {
	      				
	      			$this->table->add_row(array($fullname, $row->classname, $row->companyname,  $row->salesrepname, '<p class="liveButton" id="checkInP' .$row->enrollmentid. '"><a href="#" class="liveButton" onclick="checkInChange(' .$row->enrollmentid. ');return false;" id="checkIn' .$row->enrollmentid. '">Check In</a></p>', '<p class="liveButton green" id="cancelP' .$row->enrollmentid. '"><a href="#" class="liveButton" onclick="cancelChange(' .$row->enrollmentid. ');return false;" id="cancel' .$row->enrollmentid. '">Cancel</a></p>', '<p class="liveButton" id="noShowP' .$row->enrollmentid. '"><a href="#" class="liveButton" onclick="noShowChange(' .$row->enrollmentid. ');return false;" id="noShow' .$row->enrollmentid. '">No Show</a></p>'));

	      				
	      			} else if ($row->noshow == '1') {
	      			
	      			$this->table->add_row(array($fullname, $row->classname, $row->companyname,  $row->salesrepname, '<p class="liveButton" id="checkInP' .$row->enrollmentid. '"><a href="#" class="liveButton" onclick="checkInChange(' .$row->enrollmentid. ');return false;" id="checkIn' .$row->enrollmentid. '">Check In</a></p>', '<p class="liveButton" id="cancelP' .$row->enrollmentid. '"><a href="#" class="liveButton" onclick="cancelChange(' .$row->enrollmentid. ');return false;" id="cancel' .$row->enrollmentid. '">Cancel</a></p>', '<p class="liveButton green" id="noShowP' .$row->enrollmentid. '"><a href="#" class="liveButton" onclick="noShowChange(' .$row->enrollmentid. ');return false;" id="noShow' .$row->enrollmentid. '">No Show</a></p>'));

	      			} else {
	      			
	      			$this->table->add_row(array($fullname, $row->classname, $row->companyname,  $row->salesrepname, '<p class="liveButton" id="checkInP' .$row->enrollmentid. '"><a href="#" class="liveButton" onclick="checkInChange(' .$row->enrollmentid. ');return false;" id="checkIn' .$row->enrollmentid. '">Check In</a></p>', '<p class="liveButton" id="cancelP' .$row->enrollmentid. '"><a href="#" class="liveButton" onclick="cancelChange(' .$row->enrollmentid. ');return false;" id="cancel' .$row->enrollmentid. '">Cancel</a></p>', '<p class="liveButton" id="noShowP' .$row->enrollmentid. '"><a href="#" class="liveButton" onclick="noShowChange(' .$row->enrollmentid. ');return false;" id="noShow' .$row->enrollmentid. '">No Show</a></p>'));

	      			
	      			}
	
	      			
	   			}
	   			
	   
			 	

		$table =  $this->table->generate();
	   			
	   	$output['table'] = $table;
		
		
		$output['js_files'] = array('//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js','/css/jquery.pnotify.min.js');
		$output['css_files'] = array('http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css','/css/jquery.pnotify.default.css','/css/jquery.pnotify.default.icons.css');
		$output['username'] = username();
		$output['numRows'] = $numRows;
 
 		$this->load->view('header',$output);
 		$this->load->view('checkin_view',$output);
 		$this->load->view('footer'); 	
 		
 	} else { $output['js_files'] = array();
		$output['css_files'] = array() ;$output['username'] = username();$output['noRows'] = '1'; $this->load->view('header',$output);
 		$this->load->view('checkin_view',$output);
 		$this->load->view('footer');  }	} else { $this->login(); }
 		
 		
 		
	
	}
	
	
	
	function getClassesForDate() {
	
	if($_POST['datepicker']) { $date = $_POST['datepicker']; } else { die; }
		
	$query = $this->db->query('SELECT * FROM enrollment LEFT JOIN class_titles as jd45e51a1 ON jd45e51a1.id = enrollment.classid LEFT JOIN class_schedule as jdd77bf35 ON jdd77bf35.id = enrollment.datesid
 WHERE startdate = "' .$date. '" AND cancelled = "No"');
 	
	$output = array();

	if ($query->num_rows() > 0)
		{

   			foreach ($query->result() as $row)
  			{
      			if($row->classname) 
      			{
      				$output[]= '<option value="' .$row->classid. '">' .$row->classname. '</option>';
      			}
   			}
   			
   			$unique = array_unique($output);
   			echo json_encode($unique);
   
		} else {
		
			echo json_encode('<option value="null">No Classes Scheduled</option>');
		
		}
	}
	
	function generateCheckinSheet() {
		$this->load->library('table');
		$this->load->helper('file');
		
		$today = date("Y-m-d");
//		$output = '<table>';
		if(isset($_POST['courses'])) {
			$class = $_POST['courses']; 
		} else if($_POST['courses'] == 'null') { 
			die('No Class Chosen');
		}
		
		$date = $_POST['datepicker'];
		//$this->load->library('Pdf');
		$this->load->database();
		
		
		$query = $this->db->query("SELECT *
FROM (`enrollment`)
LEFT JOIN `billing` as jde77bf36 ON `jde77bf36`.`id` = `enrollment`.`billingid` 
LEFT JOIN `company` as j480e8462 ON `j480e8462`.`id` = `enrollment`.`companyid`
LEFT JOIN `student` as jc6e86205 ON `jc6e86205`.`id` = `enrollment`.`studentid`
LEFT JOIN `class_titles` as jd45e51a1 ON `jd45e51a1`.`id` = `enrollment`.`classid`
LEFT JOIN `class_schedule` as jdd77bf35 ON `jdd77bf35`.`id` = `enrollment`.`datesid`
WHERE `startdate` = '" .$date. "' AND `classid` = '" .$class. "' AND `status` =  '1'  ");
$numRows = $query->num_rows();

$query2 = $this->db->query("SELECT * FROM `class_titles` LEFT JOIN `class_schedule` as `schedule` ON `schedule`.`classtitleid` = `class_titles`.`id` WHERE `class_titles`.`id` = '" .$class. "' AND `startdate` = '" .$date. "'");
$row2 = $query2->row();

		$this->table->set_heading('Full Name', 'Email', 'Company Name', 'Signature', 'Day 2', 'Day 3', 'Day 4', 'Day 5');

		$tmpl = array ( 'table_open'  => '<html><head><style type="text/css">body{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;}#checkIn{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size:12px;background:#fff;width:100%;border-collapse:collapse;text-align:left;}#checkIn th{font-size:14px;font-weight:normal;color:#039;border-bottom:2px solid #6678b1;padding:10px 8px;}#checkIn td{border-left:1px solid #ccc; border-right:1px solid #ccc;border-bottom:1px solid #ccc;color:#669;padding:6px 8px;}#checkIn tbody tr:hover td{color:#009;}.signature{width:250px;}.largeCheckBox{width:25px;height:25px;margin:0 auto;}</style></head><body><div style="width:100%;height:100%;"><div style="width:100%;height:400px;margin:0 auto;"><img src="../images/logo.png" /><h1>Campus Linc - Check In Sheet</h1><h3>Start Date: ' .$date. '  |  Length: ' .$row2->length. '  |  Class: ' .$row2->classname. '  |  Instructor:  ' .$row2->instructor. '  |  Location:  ' .$row2->location. '  |  Cancelled?:  ' .$row2->cancelled. '</h3><h4>Student Instructions</h4><ul><li>Please review the spelling of your name and company name to ensure that your certificate is printed with the correct information on it.<br /><strong>Make any necessary corrections on this form.</strong></li><li>Attendance will be taken daily; please initial with ink each day of attendance.</li><li><strong>Note:</strong> This instructor will note late arrivals and early departures. If you need to withdraw from the class, please notify the instructor and your account executive.</li></ul></div><span style="font-weight:bold;">If your name and email are not printed below, please PRINT them</span><table id="checkIn">', 'table_close' => '</table><h4>Total # of Students: ' .$numRows. '</h4><div style="width:100%;height:120px;"><h4>Instructor Verification:</h4></div><div style="width:100%;height:120px;"><h4>Instructor Comments:</h4></div><p>I do depose an say that I am a duly licensed teacher and that the Attendance Record is correct to the best of my knowledge and that I have fully and truly made all entries above.</p><h4>Instructor Signature: _________________________________________</h4><p style="font-size:10px;">Campus Linc, Inc.<br />25 John Glenn Drive<br />Suite 102<br />Amherst, NY 14228<br />716.688.8688</p></div></body></html>' );

		$this->table->set_template($tmpl);

		if ($query->num_rows() > 0)
			{
				$numRows = $query->num_rows();
	   			foreach ($query->result() as $row)
	  			{
	      			$fullname = $row->firstname. ' ' .$row->lastname;
	      			$this->table->add_row(array($fullname, $row->email,  $row->companyname, '<div class="signature"></div>', '<div class="largeCheckbox"></div>', '<div class="largeCheckbox"></div>', '<div class="largeCheckbox"></div>', '<div class="largeCheckbox"></div>'));
	
	      			
	   			}
	   			
	   			
	   			$table =  $this->table->generate();
	   			$filename = '/tmp/' .$today. '-' .$class. '-' .rand(1,100). '.html';
	   			if ( ! write_file('.' .$filename, $table))
				{
     				echo 'Unable to write the file';
				} else {
     				//echo json_encode($table);
     				echo json_encode('<h2 style="color:red;"><a href="' .$filename. '" target="_blank">Click Here to Download CheckIn Sheet</a></h2>');
				}
	   
			} 	
		}
		
		
		
		function checkInChange(){
			
			$enrollmentID = $_POST['id'];
			
			$this->load->database();
			
			$query = $this->db->query("SELECT * FROM enrollment WHERE id =\"" .$enrollmentID. "\" LIMIT 1");
			
			$row = $query->row();
			
			if ($row->checkedIn == '0')
			{
	   			
	   			$sql = 'UPDATE enrollment SET checkedIn = "1" WHERE id = "' .$enrollmentID. '"';
	   			
	   			if($this->db->query($sql)) { echo json_encode('1'); } else { echo json_encode('0'); }	   			
	   			
	   		} 	else if ($row->checkedIn == '1') {
	   		
	   			$sql2 = 'UPDATE enrollment SET checkedIn = "0" WHERE id = "' .$enrollmentID. '"';
	   			
	   			if($this->db->query($sql2)) { echo json_encode('1'); } else { echo json_encode('0'); }	
	   		
	   		 }

			exit;		
		
		}
		
		function cancelChange(){
			
			$enrollmentID = $_POST['id'];
			
			$this->load->database();
			
			$query = $this->db->query("SELECT * FROM enrollment WHERE id =\"" .$enrollmentID. "\" LIMIT 1");
			
			$row = $query->row();
			
			if ($row->userCancel == '0')
			{
	   			
	   			$sql = 'UPDATE enrollment SET userCancel = "1" WHERE id = "' .$enrollmentID. '"';
	   			
	   			if($this->db->query($sql)) { echo json_encode('1'); } else { echo json_encode('0'); }	   			
	   			
	   		} 	else if ($row->userCancel == '1') {
	   		
	   			$sql2 = 'UPDATE enrollment SET userCancel = "0" WHERE id = "' .$enrollmentID. '"';
	   			
	   			if($this->db->query($sql2)) { echo json_encode('1'); } else { echo json_encode('0'); }	
	   		
	   		 }

			exit;		
		
		}
		
		function noShowChange(){
			
			$enrollmentID = $_POST['id'];
			
			$this->load->database();
			
			$query = $this->db->query("SELECT * FROM enrollment WHERE id =\"" .$enrollmentID. "\" LIMIT 1");
			
			$row = $query->row();
			
			if ($row->noshow == '0')
			{
	   			
	   			$sql = 'UPDATE enrollment SET noshow = "1" WHERE id = "' .$enrollmentID. '"';
	   			
	   			if($this->db->query($sql)) { echo json_encode('1'); } else { echo json_encode('0'); }	   			
	   			
	   		} 	else if ($row->noshow == '1') {
	   		
	   			$sql2 = 'UPDATE enrollment SET noshow = "0" WHERE id = "' .$enrollmentID. '"';
	   			
	   			if($this->db->query($sql2)) { echo json_encode('1'); } else { echo json_encode('0'); }	
	   		
	   		 }

			exit;		
		
		}
		
		function checkForNewEnrollments() {
		$existingRows = $_POST['numRows'];
		$today = date('Y-m-d');
		$this->load->database();
		
		$sql = 'SELECT enrollment.id FROM enrollment
LEFT JOIN class_schedule as class_schedule ON class_schedule.id = enrollment.datesid
WHERE class_schedule.cancelled = "No"
AND startdate = "' .$today. '"
';
		
		$query = $this->db->query($sql);
		
		$numRows = $query->num_rows();
		
		if($numRows > $existingRows) { echo '1'; } else { echo '0'; }


		
		
		}

}
<?php

class Classrosterreport extends CI_Controller {

	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url'); 
		
	}
	
	function index()
	{
			
		
		$output['js_files'] = array('//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js');
		$output['css_files'] = array('/assets/jquery-ui-1.9.2.custom.min.css');
 
 		$this->load->view('header',$output);
 		$this->load->view('classrosterreport');
 		$this->load->view('footer'); 	
 		
 		
 		
 		
	
	}
	
	
	
	function getClassesForDate() {
	
	if($_POST['datepicker']) { $date = $_POST['datepicker']; } else { die; }
		
	$query = $this->db->query('SELECT * FROM enrollment LEFT JOIN class_titles as jd45e51a1 ON jd45e51a1.id = enrollment.classid LEFT JOIN class_schedule as jdd77bf35 ON jdd77bf35.id = enrollment.datesid
 WHERE startdate = "' .$date. '" AND status = "1"');
 	
	$output = '';

	if ($query->num_rows() > 0)
		{

   			foreach ($query->result() as $row)
  			{
      			if($row->classname) 
      			{
      				$output .= '<option value="' .$row->classid. '">' .$row->classname. '</option>';
      			}
   			}
   			
   			echo json_encode($output);
   
		} else {
		
			echo json_encode('<option value="null">No Classes Scheduled</option>');
		
		}
	}
	
	function generateClassRosterReport() {
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

		$this->table->set_heading('Full Name', 'Email', 'Company Name', 'Billing Contact',  'Attended?', 'Cancel?', 'No Show?');

		$tmpl = array ( 'table_open'  => '<html><head><style type="text/css">body{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;}#checkIn{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size:12px;background:#fff;width:100%;border-collapse:collapse;text-align:left;}#checkIn th{font-size:14px;font-weight:normal;color:#039;border-bottom:2px solid #6678b1;padding:10px 8px;}#checkIn td{border-left:1px solid #ccc; border-right:1px solid #ccc;border-bottom:1px solid #ccc;color:#669;padding:6px 8px;}#checkIn tbody tr:hover td{color:#009;}.signature{width:250px;}.largeCheckBox{width:25px;height:25px;margin:0 auto;}</style></head><body><div style="width:100%;height:100%;"><div style="width:100%;height:375px;margin:0 auto;"><img src="../images/logo.png" /><h1>Campus Linc - Class Roster Report</h1><h3>Start Date: ' .$date. '  |  Length: ' .$row2->length. '  |  Class: ' .$row2->classname. '  |  Instructor:  ' .$row2->instructor. '  |  Location:  ' .$row2->location. '  |  Cancelled?:  ' .$row2->cancelled. '</h3><table id="checkIn">', 'table_close' => '</table><p style="font-size:10px;">Campus Linc, Inc.<br />25 John Glenn Drive<br />Suite 102<br />Amherst, NY 14228<br />716.688.8688</p></div></body></html>' );

		$this->table->set_template($tmpl);

		if ($query->num_rows() > 0)
			{
				$numRows = $query->num_rows();
	   			foreach ($query->result() as $row)
	  			{
	  	if($row->checkedIn == '1') { $checkedIn = 'Yes'; } else { $checkedIn = 'No'; }
	   if($row->userCancel == '1') { $cancelled = 'Yes';} else { $cancelled = 'No'; }
	   if($row->noshow == '1') { $noShow = 'Yes';} else { $noShow = 'No'; }
	      			$fullname = $row->firstname. ' ' .$row->lastname;
	      			$this->table->add_row(array($fullname, $row->email,  $row->companyname, $row->billingcontact,$checkedIn, $cancelled, $noShow));
	
	      			
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
}
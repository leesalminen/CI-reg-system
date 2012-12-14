<?php

class Companytranscript extends Application {

	
	function __construct()
	{
		parent::__construct();		
		$this->load->helper('html');
		$this->load->library('ag_auth');

	}
	
	function index()
	{	
		if(logged_in())
		{
		$output['js_files'] = array('//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js','/css/jquery.pnotify.min.js');
		$output['css_files'] = array('http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css','/css/jquery.pnotify.default.css','/css/jquery.pnotify.default.icons.css');

   		$this->load->view('header',$output);
   	    $this->load->view('company_transcript');
		$this->load->view('footer');
		} else {
		
			$this->login();
		}
	}
	
	function notuition() {
	if(logged_in())
		{
		$output['js_files'] = array('//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js','/css/jquery.pnotify.min.js');
		$output['css_files'] = array('http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css','/css/jquery.pnotify.default.css','/css/jquery.pnotify.default.icons.css');

   		$this->load->view('header',$output);
   	    $this->load->view('company_transcript_no_tuition');
		$this->load->view('footer');
		} else {
		
			$this->login();
		}
	}
	
	
	function getCompanies() {
		
		$this->load->database();
		$sql = "SELECT companyname,id FROM company ORDER BY companyname";
		$query = $this->db->query($sql);
		$output = '';	
		if ($query->num_rows() > 0)
		{

   			foreach ($query->result() as $row)
  			{
      			if($row->companyname) 
      			{
      				$output .= '<option value="' .$row->id. '">' .$row->companyname. '</option>';
      			}
   			}
   			
   			echo json_encode($output);
   			exit;
   
		} else {
		exit;
		
			//echo json_encode('<option value="null">No Available Companies</option>');
		
		}
	
	
	
	}
	
	
	function getStudent() {
	$studentid = $_POST['companyid'];
		
		$this->db->select("*")
				 ->from('student')
				 ->where('companyid', $studentid);
		$db = $this->db->get();
		
		$output = '';	
		if ($db->num_rows() > 0)
		{

   			foreach ($db->result() as $row)
  			{
      			if($row->id) 
      			{
      				$output .= '<option value="' .$row->id. '">' .$row->lastname. ', ' .$row->firstname. '</option>';
      			}
   			}
   			
   			echo json_encode($output);
   
		} else {
		
		
			echo json_encode('<option value="null">No Students</option>');
		
		}
	

		exit;     
	
	}
	
	
	function generateCompanyTranscriptReport() {
	
	
		$this->load->library('table');
		$this->load->helper('file');
		
		$today = date("Y-m-d");
//		$output = '<table>';
		
		$company = $_POST['companies'];		
		$this->load->database();
		
//$sql = 'SELECT class_schedule.id,class_schedule.classtitleid, class_schedule.startdate,class_schedule.notes,class_schedule.location,class_schedule.instructor, class_titles.classname FROM `class_schedule` LEFT JOIN `class_titles` as class_titles ON `class_titles`.`id` = `class_schedule`.`classtitleid`  WHERE `startdate` >= \'' .$from. '\' AND `startdate` <= \'' .$to. '\' AND `cancelled` = \'NO\'';


		//$sql = "SELECT * FROM enrollment WHERE studentid = '" .$student. "' AND companyid = '" .$company. "' AND status = '1' AND checkedin='1'";
		
		$sql = "SELECT enrollment.companyid,enrollment.studentid,enrollment.billingid,enrollment.classid,enrollment.datesid,enrollment.checkedIn,enrollment.userCancel,enrollment.noshow,enrollment.po,class_schedule.startdate,class_schedule.enddate,class_titles.tuition,class_titles.classname,student.billingid,student.firstname,student.lastname,billing.billingcontact
FROM enrollment
LEFT JOIN class_schedule ON ( enrollment.classid = class_schedule.classtitleid ) 
LEFT JOIN class_titles ON ( enrollment.classid = class_titles.id ) 
LEFT JOIN student ON (enrollment.studentid = student.id)
LEFT JOIN billing ON ( enrollment.billingid = billing.id )
WHERE enrollment.companyid = '" .$company. "'
AND cancelled = 'No'
";

$sql2 = 'SELECT companyname from company where id = \'' .$company. '\'';
$result = $this->db->query($sql2);
$companyName = $result->row();
			
		$query = $this->db->query($sql);
		if($query->num_rows > 0) {
		$array = array();
		foreach($query->result() as $row){
			$array[] = $row;	
		
		}	
		
		//var_dump($array);
		$numberOfClasses = count($array);
		$today = date('Y-m-d');
		$this->table->set_heading('Full Name', 'Class Name', 'Start Date', 'End Date', 'Purchase Order', 'Billing Contact', 'Attended?', 'Cancelled?', 'No Show?', 'Tuition');

		$tmpl = array ( 'table_open'  => '<html><head><style type="text/css">body{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;}#upcomingClasses{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size:12px;background:#fff;width:100%;border-collapse:collapse;text-align:left;}#upcomingClasses th{font-size:14px;font-weight:normal;color:#039;border-bottom:2px solid #6678b1;padding:10px 8px;}#upcomingClasses td{border-left:1px solid #ccc; border-right:1px solid #ccc;border-bottom:1px solid #ccc;color:#669;padding:6px 8px;}#upcomingClasses tbody tr:hover td{color:#009;}.signature{width:250px;}.largeCheckBox{width:25px;height:25px;margin:0 auto;}</style></head><body><div style="width:100%;height:100%;"><div style="width:100%;height:250px;margin:0 auto;"><img src="../images/logo.png" /><h2> Company Transcript Report For: ' .$companyName->companyname. '</h2><h4>This report was generated on: ' .$today. '</h4><table id="upcomingClasses">', 'table_close' => '</table><h4>Total # of Classes: ' .$numberOfClasses. '</h4><p style="font-size:10px;">Campus Linc, Inc.<br />25 John Glenn Drive<br />Suite 102<br />Amherst, NY 14228<br />716.688.8688</p></div></body></html>' );

		$this->table->set_template($tmpl);
		   
	   foreach($array as $arr)
	   {
	   if($arr->checkedIn == '1') { $checkedIn = 'Yes'; } else { $checkedIn = 'No'; }
	   if($arr->userCancel == '1') { $cancelled = 'Yes';} else { $cancelled = 'No'; }
	   if($arr->noshow == '1') { $noShow = 'Yes';} else { $noShow = 'No'; }

	   $this->table->add_row(array($arr->lastname. ', ' .$arr->firstname, $arr->classname, $arr->startdate, $arr->enddate, $arr->po, $arr->billingcontact, $checkedIn, $cancelled, $noShow, $arr->tuition));
	   
	   }
	   			$table =  $this->table->generate();
				
	   			$filename = '/tmp/' .$today. '-companyTranscriptReport-' .rand(1,1000). '.html';
	   			if ( ! write_file('.' .$filename, $table))
				{
     				echo 'Unable to write the file';
				} else {
     				//echo json_encode($table);
     				$output = array('<h2 style="color:red;"><a href="' .$filename. '" target="_blank">Click Here to Download Individual Student Transcript Report</a></h2>',$filename);
     				//echo json_encode('<h2 style="color:red;"><a href="' .$filename. '" target="_blank">Click Here to Download Individual Student Transcript Report</a></h2>');
     				echo json_encode($output);
				}
				

//echo json_encode($array);
exit;
			
		} else { echo json_encode('<p style="color:red;font-weight:bold;">No Classes Found.</p>');}
		
		}
	
	
	function searchForStudent() {
		$lastName = $_POST['studentLastName'];
		$this->load->database();
		$sql = "SELECT student.id, student.firstname, student.lastname, student.email, company.companyname, company.id AS companyid FROM student LEFT JOIN company ON ( student.companyid = company.id )  WHERE lastname LIKE '%" .$lastName. "%'";
		
		//echo $sql;
		
		$query = $this->db->query($sql);
		if($query->num_rows > 0) {
		$output = '';
		//$array = array();
		foreach($query->result() as $row){
			//$array[] = $row;	 
			//var_dump($row);
			$output .= '<div><span style="font-weight:bold;">' .$row->lastname. ', ' .$row->firstname. '</span> - ' .$row->companyname. '<form action="/studenttranscript/generateStudentTranscriptReport" method="post" class="studentName" style="display:inline;"><input type="hidden" name="companies" value="' .$row->companyid. '" /><input type="hidden" name="students" value="' .$row->id. '" /> <button class="studentSubmit" type="submit" onclick="generateReportByName();return false;">Generate Report</button></form></div>';
		
		}	
		
		echo json_encode($output);
		
		} else { echo json_encode('No Student Found'); }
	
	
	
	
	
	}
	
	function generateCompanyTranscriptReportNoTuition() {
	
	
		$this->load->library('table');
		$this->load->helper('file');
		
		$today = date("Y-m-d");
//		$output = '<table>';
		
		$company = $_POST['companies'];		
		$this->load->database();
		
//$sql = 'SELECT class_schedule.id,class_schedule.classtitleid, class_schedule.startdate,class_schedule.notes,class_schedule.location,class_schedule.instructor, class_titles.classname FROM `class_schedule` LEFT JOIN `class_titles` as class_titles ON `class_titles`.`id` = `class_schedule`.`classtitleid`  WHERE `startdate` >= \'' .$from. '\' AND `startdate` <= \'' .$to. '\' AND `cancelled` = \'NO\'';


		//$sql = "SELECT * FROM enrollment WHERE studentid = '" .$student. "' AND companyid = '" .$company. "' AND status = '1' AND checkedin='1'";
		
		$sql = "SELECT enrollment.companyid,enrollment.studentid,enrollment.billingid,enrollment.classid,enrollment.datesid,enrollment.checkedIn,enrollment.userCancel,enrollment.noshow,class_schedule.startdate,class_schedule.enddate,class_titles.classname,student.billingid,student.firstname,student.lastname
FROM enrollment
LEFT JOIN class_schedule ON ( enrollment.classid = class_schedule.classtitleid ) 
LEFT JOIN class_titles ON ( enrollment.classid = class_titles.id ) 
LEFT JOIN student ON (enrollment.studentid = student.id)
WHERE enrollment.companyid = '" .$company. "'
AND cancelled = 'No'
";

$sql2 = 'SELECT companyname from company where id = \'' .$company. '\'';
$result = $this->db->query($sql2);
$companyName = $result->row();
			
		$query = $this->db->query($sql);
		if($query->num_rows > 0) {
		$array = array();
		foreach($query->result() as $row){
			$array[] = $row;	
		
		}	
		
		//var_dump($array);
		$numberOfClasses = count($array);
		$today = date('Y-m-d');
		$this->table->set_heading('Full Name', 'Class Name', 'Start Date', 'End Date', 'Attended?', 'Cancelled?', 'No Show?');

		$tmpl = array ( 'table_open'  => '<html><head><style type="text/css">body{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;}#upcomingClasses{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size:12px;background:#fff;width:100%;border-collapse:collapse;text-align:left;}#upcomingClasses th{font-size:14px;font-weight:normal;color:#039;border-bottom:2px solid #6678b1;padding:10px 8px;}#upcomingClasses td{border-left:1px solid #ccc; border-right:1px solid #ccc;border-bottom:1px solid #ccc;color:#669;padding:6px 8px;}#upcomingClasses tbody tr:hover td{color:#009;}.signature{width:250px;}.largeCheckBox{width:25px;height:25px;margin:0 auto;}</style></head><body><div style="width:100%;height:100%;"><div style="width:100%;height:250px;margin:0 auto;"><img src="../images/logo.png" /><h2> Company Transcript Report For: ' .$companyName->companyname. '</h2><h4>This report was generated on: ' .$today. '</h4><table id="upcomingClasses">', 'table_close' => '</table><h4>Total # of Classes: ' .$numberOfClasses. '</h4><p style="font-size:10px;">Campus Linc, Inc.<br />25 John Glenn Drive<br />Suite 102<br />Amherst, NY 14228<br />716.688.8688</p></div></body></html>' );

		$this->table->set_template($tmpl);
		   
	   foreach($array as $arr)
	   {
	   if($arr->checkedIn == '1') { $checkedIn = 'Yes'; } else { $checkedIn = 'No'; }
	   if($arr->userCancel == '1') { $cancelled = 'Yes';} else { $cancelled = 'No'; }
	   if($arr->noshow == '1') { $noShow = 'Yes';} else { $noShow = 'No'; }

	   $this->table->add_row(array($arr->lastname. ', ' .$arr->firstname, $arr->classname, $arr->startdate, $arr->enddate, $checkedIn, $cancelled, $noShow));
	   
	   }
	   			$table =  $this->table->generate();
				
	   			$filename = '/tmp/' .$today. '-companyTranscriptReport-' .rand(1,1000). '.html';
	   			if ( ! write_file('.' .$filename, $table))
				{
     				echo 'Unable to write the file';
				} else {
     				//echo json_encode($table);
     				$output = array('<h2 style="color:red;"><a href="' .$filename. '" target="_blank">Click Here to Download Individual Student Transcript Report</a></h2>',$filename);
     				//echo json_encode('<h2 style="color:red;"><a href="' .$filename. '" target="_blank">Click Here to Download Individual Student Transcript Report</a></h2>');
     				echo json_encode($output);
				}
				

//echo json_encode($array);
exit;
			
		} else { echo json_encode('<p style="color:red;font-weight:bold;">No Classes Found.</p>');}
		
		}
	
	
	
	



}
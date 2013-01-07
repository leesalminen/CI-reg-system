<?php

class aeReport extends Application {

	
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
		
		$this->load->database();
		
		$sql = 'SELECT * from salesperson';
		$query = $this->db->query($sql);
		
		
		$output['salesrepid'] = '<select id="salesrepid" name="salesrepid">';
		foreach($query->result() as $row) {
			
			$output['salesrepid'] .= '<option value="' .$row->id. '">' .$row->name. '</option>';
			
		
		}
		
		$output['salesrepid'] .= '</select>';
		$output['js_files'] = array('//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js','/css/jquery.pnotify.min.js');
		$output['css_files'] = array('/assets/jquery-ui-1.9.2.custom.min.css','http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css','/css/jquery.pnotify.default.css','/css/jquery.pnotify.default.icons.css');

   		$this->load->view('header',$output);
   	    $this->load->view('ae_report',$output);
		$this->load->view('footer');
		} else {
		
		$this->login();
		}
	}
	
	function enrollmentReport()
	{	
   		if(logged_in())
		{
		
		$this->load->database();
		
		$sql = 'SELECT * from salesperson';
		$query = $this->db->query($sql);
		
		
		$output['salesrepid'] = '<select id="salesrepid" name="salesrepid">';
		foreach($query->result() as $row) {
			
			$output['salesrepid'] .= '<option value="' .$row->id. '">' .$row->name. '</option>';
			
		
		}
		
		$output['salesrepid'] .= '</select>';
		$output['js_files'] = array('//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js','/css/jquery.pnotify.min.js');
		$output['css_files'] = array('/assets/jquery-ui-1.9.2.custom.min.css','http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css','/css/jquery.pnotify.default.css','/css/jquery.pnotify.default.icons.css');

   		$this->load->view('header',$output);
   	    $this->load->view('enrollment_report',$output);
		$this->load->view('footer');
		} else {
		
		$this->login();
		}
	}
	
	
	function generateAEReport() {
	
	
		$this->load->library('table');
		$this->load->helper('file');
		
		$today = date("m-d-Y");
//		$output = '<table>';
		
		if($_POST['datepickerFrom'] == '') {echo json_encode("<p style=\"font-weight:bold;color:red;\">Choose a From Date</p>");exit;} else {
		$from = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $_POST['datepickerFrom'])));
		//$from = date('Y-m-d',strtotime($_POST['datepickerFrom']));
		
		}
		if($_POST['datepickerTo'] != '') {
			$to = date('Y-m-d H:i:s',strtotime(str_replace('-', '/', $_POST['datepickerTo'])));
		} else {
			$to = '2050-12-31 00:00:00';
		}
		
	//	$this->load->library('Pdf');
		$this->load->database();
		
$sql = 'SELECT student.firstname,student.lastname,class_titles.classname,class_schedule.startdate,salesperson.name,company.companyname as companyname, company.salesrepid, salesperson.name, enrollment.tuition, enrollment.courseware
FROM enrollment
INNER JOIN student ON student.id = enrollment.studentid
INNER JOIN class_titles ON class_titles.id = enrollment.classid
INNER JOIN class_schedule ON class_schedule.id = enrollment.datesid
INNER JOIN company ON company.id = enrollment.companyid
INNER JOIN salesperson ON salesperson.id = company.salesrepid
WHERE salesperson.id = "' .$_POST['salesrepid']. '"
AND `startdate` >= \'' .$from. '\' AND `startdate` <= \'' .$to. '\'
AND `cancelled` = \'NO\'
AND `enrollment`.`checkedIn` = "1"
ORDER BY startdate';
			
		$query = $this->db->query($sql);
		$array = array();
		if($query->num_rows() > 0) {
		foreach($query->result() as $row){
			$array[] = $row;
		
		
		}	
		
		$numberOfClasses = $query->num_rows();
		$today = date('m-d-Y');
		$this->table->set_heading('Class Name', 'Start Date', 'First Name', 'Last Name', 'Company', 'Start Date','Net Sales');

		$costArray = array();

	   foreach($array as $arr)
	   {
	   
	 	$netSale = $arr->tuition - $arr->courseware;
	   $netSale = money_format('$%i',$netSale);
	  
	   
	   $this->table->add_row(array($arr->classname, date('m-d-Y H:i:s',strtotime($arr->startdate)),  $arr->firstname, $arr->lastname, $arr->companyname, $arr->startdate, $netSale));
	   
	   $costArray[] = $arr->tuition - $arr->courseware;
	 	   
	   }
	   
	   setlocale(LC_MONETARY, 'en_US');
		$grossCost = array_sum($costArray);
		$grossCost = money_format('%(#2n', $grossCost);
				
				$tmpl = array ( 'table_open'  => '<html><head><style type="text/css">body{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;}#upcomingClasses{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size:12px;background:#fff;width:100%;border-collapse:collapse;text-align:left;}#upcomingClasses th{font-size:14px;font-weight:normal;color:#039;border-bottom:2px solid #6678b1;padding:10px 8px;}#upcomingClasses td{border-left:1px solid #ccc; border-right:1px solid #ccc;border-bottom:1px solid #ccc;color:#669;padding:6px 8px;}#upcomingClasses tbody tr:hover td{color:#009;}.signature{width:250px;}.largeCheckBox{width:25px;height:25px;margin:0 auto;}</style></head><body><div style="width:100%;height:100%;"><div style="width:100%;height:375px;margin:0 auto;"><img src="../images/logo.jpg" /><h1>Account Executive Report</h1><h3>This report was generated on: ' .$today. ' for ' .$array[0]->name. '</h3><table id="upcomingClasses">', 'table_close' => '</table><h4>Net Revenue for Period (Tuition - Courseware, Checked In ONLY): ' .$grossCost. '</h4><p style="font-size:10px;">Campus Linc, Inc.<br />25 John Glenn Drive<br />Suite 102<br />Amherst, NY 14228<br />716.688.8688</p></div></body></html>' );

		$this->table->set_template($tmpl);

		
		
	   			$table =  $this->table->generate();
				
	   			$filename = '/tmp/' .$today. '-aeReport-' .rand(1,1000). '.html';
	   			if ( ! write_file('.' .$filename, $table))
				{
     				echo 'Unable to write the file';
				} else {
     				//echo json_encode($table);
     				echo json_encode('<h2 style="color:red;"><a href="' .$filename. '" target="_blank">Click Here to Download Account Executive Report</a></h2>');
				}	
				} else { echo json_encode('<div class="alert alert-error">No Enrollments Found.</div>'); }

//echo json_encode($array);
exit;
			
		}
		
	function generateEnrollmentReport() {
	
	
		$this->load->library('table');
		$this->load->helper('file');
		
		$today = date("m-d-Y");
//		$output = '<table>';
		
		if($_POST['datepickerFrom'] == '') {echo json_encode("<p style=\"font-weight:bold;color:red;\">Choose a From Date</p>");exit;} else {
		$from = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $_POST['datepickerFrom'])));
		//$from = date('Y-m-d',strtotime($_POST['datepickerFrom']));
		
		}
		if($_POST['datepickerTo'] != '') {
			$to = date('Y-m-d H:i:s',strtotime(str_replace('-', '/', $_POST['datepickerTo'])));
		} else {
			$to = '2050-12-31 00:00:00';
		}
		
	//	$this->load->library('Pdf');
		$this->load->database();
		
$sql = 'SELECT student.firstname,student.lastname,class_titles.classname,class_schedule.startdate,salesperson.name,company.companyname as companyname, company.salesrepid, salesperson.name, enrollment.tuition, enrollment.courseware,enrollment.userCancel,enrollment.noshow,enrollment.checkedIn
FROM enrollment
INNER JOIN student ON student.id = enrollment.studentid
INNER JOIN class_titles ON class_titles.id = enrollment.classid
INNER JOIN class_schedule ON class_schedule.id = enrollment.datesid
INNER JOIN company ON company.id = enrollment.companyid
INNER JOIN salesperson ON salesperson.id = company.salesrepid
WHERE salesperson.id = "' .$_POST['salesrepid']. '"
AND `startdate` >= \'' .$from. '\' AND `startdate` <= \'' .$to. '\'
AND `cancelled` = \'NO\'
ORDER BY startdate';
			
		$query = $this->db->query($sql);
		$array = array();
		foreach($query->result() as $row){
			$array[] = $row;
		
		
		}	
		
		$numberOfClasses = $query->num_rows();
		$today = date('m-d-Y');
		$this->table->set_heading('Class Name', 'Start Date', 'First Name', 'Last Name', 'Company', 'Start Date','Cancelled/NoShow?','Net Sales');

		$costArray = array();
		$costArray2 = array();

	   foreach($array as $arr)
	   {
	   
	   if($arr->checkedIn == '1') {
	   $netSale = $arr->tuition - $arr->courseware;
	   $netSale = money_format('$%i',$netSale);
	   } else { $netSale = '$0.00'; }

	   
	   if($arr->userCancel == '1') {$cxl = 'Yes';} elseif($arr->noshow == '1') {$cxl = 'Yes';} else {$cxl = 'No';}
	   $this->table->add_row(array($arr->classname, date('m-d-Y H:i:s',strtotime($arr->startdate)),  $arr->firstname, $arr->lastname, $arr->companyname, $arr->startdate, $cxl, $netSale));
	   
	    if($arr->checkedIn == '1') {
	   $costArray[] = $arr->tuition - $arr->courseware;
	   } else { $costArray2[] = $arr->tuition - $arr->courseware;  }
	   	   
	   }
	   
	   
	   
	    setlocale(LC_MONETARY, 'en_US');
		$grossCost = array_sum($costArray);
		$grossCost = money_format('%(#2n', $grossCost);
		$grossCost2 = array_sum($costArray);
		$grossCost2 = $grossCost2 + array_sum($costArray2);
		$grossCost2 = money_format('%(#2n', $grossCost2);
		
				$tmpl = array ( 'table_open'  => '<html><head><style type="text/css">body{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;}#upcomingClasses{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size:12px;background:#fff;width:100%;border-collapse:collapse;text-align:left;}#upcomingClasses th{font-size:14px;font-weight:normal;color:#039;border-bottom:2px solid #6678b1;padding:10px 8px;}#upcomingClasses td{border-left:1px solid #ccc; border-right:1px solid #ccc;border-bottom:1px solid #ccc;color:#669;padding:6px 8px;}#upcomingClasses tbody tr:hover td{color:#009;}.signature{width:250px;}.largeCheckBox{width:25px;height:25px;margin:0 auto;}</style></head><body><div style="width:100%;height:100%;"><div style="width:100%;height:375px;margin:0 auto;"><img src="../images/logo.jpg" /><h1>Enrollment Report</h1><h3>This report was generated on: ' .$today. ' for ' .$array[0]->name. '</h3><table id="upcomingClasses">', 'table_close' => '</table><h4>Net Revenue for Period (Tuition - Courseware): ' .$grossCost. '</h4><h4>Net Revenue for Period (Including CXL/No Show): ' .$grossCost2. '</h4><p style="font-size:10px;">Campus Linc, Inc.<br />25 John Glenn Drive<br />Suite 102<br />Amherst, NY 14228<br />716.688.8688</p></div></body></html>' );

		$this->table->set_template($tmpl);

		
		
	   			$table =  $this->table->generate();
				
	   			$filename = '/tmp/' .$today. '-aeReport-' .rand(1,1000). '.html';
	   			if ( ! write_file('.' .$filename, $table))
				{
     				echo 'Unable to write the file';
				} else {
     				//echo json_encode($table);
     				echo json_encode('<h2 style="color:red;"><a href="' .$filename. '" target="_blank">Click Here to Download Enrollment Report</a></h2>');
				}

//echo json_encode($array);
exit;
			
		}
		
		
	
	
	
	

	


}
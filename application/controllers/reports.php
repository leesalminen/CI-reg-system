<?php

class Reports extends Application {

	
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
		$output->username = username();
   		$this->load->view('header',$output);

   	    $this->load->view('reports_view');
		$this->load->view('footer');
		} else {
		
		$this->login();
		}
	}
	
	function upcomingClasses() {
	
		if(logged_in())
		{
		$output['js_files'] = array('//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js');
		$output['css_files'] = array('/assets/jquery-ui-1.9.2.custom.min.css');
		$this->load->view('header',$output);

   	    $this->load->view('upcoming_classes');
		$this->load->view('footer');
		
		} else {
		
		$this->login();
		
		}
	
	}
	
	function generateUpcomingClassesReport() {
	
	
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
		
$sql = 'select class_schedule.id as datesid, class_schedule.classtitleid,class_schedule.startdate,class_schedule.notes,class_schedule.location,class_schedule.instructor,class_titles.classname FROM class_schedule LEFT JOIN class_titles as class_titles ON class_titles.id = class_schedule.classtitleid WHERE `startdate` >= \'' .$from. '\' AND `startdate` <= \'' .$to. '\' AND `cancelled` = \'NO\' ORDER BY startdate'; 
			
		$query = $this->db->query($sql);
		$array = array();
		$array2 = array();
		foreach($query->result() as $row){
			$array[] = $row;
		
		
		}
		
			$numberOfClasses = $query->num_rows();
		$today = date('m-d-Y');
		$this->table->set_heading('Class Name', 'Start Date', 'Location', 'Instructor', 'Notes', '# of Students');

		$tmpl = array ( 'table_open'  => '<html><head><style type="text/css">body{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;}#upcomingClasses{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size:12px;background:#fff;width:100%;border-collapse:collapse;text-align:left;}#upcomingClasses th{font-size:14px;font-weight:normal;color:#039;border-bottom:2px solid #6678b1;padding:10px 8px;}#upcomingClasses td{border-left:1px solid #ccc; border-right:1px solid #ccc;border-bottom:1px solid #ccc;color:#669;padding:6px 8px;}#upcomingClasses tbody tr:hover td{color:#009;}.signature{width:250px;}.largeCheckBox{width:25px;height:25px;margin:0 auto;}</style></head><body><div style="width:100%;height:100%;"><div style="width:100%;height:375px;margin:0 auto;"><img src="../images/logo.jpg" /><h1>Upcoming Classes Report</h1><h3>This report was generated on: ' .$today. '</h3><table id="upcomingClasses">', 'table_close' => '</table><h4>Total # of Classes: ' .$numberOfClasses. '</h4><p style="font-size:10px;">Campus Linc, Inc.<br />25 John Glenn Drive<br />Suite 102<br />Amherst, NY 14228<br />716.688.8688</p></div></body></html>' );

		$this->table->set_template($tmpl);
		
		foreach($array as $arr){
			$sql2 = 'SELECT id from enrollment where datesid = \'' .$arr->datesid. '\'';
			
			
			$query2 = $this->db->query($sql2);
			$num[$arr->datesid] = $query2->num_rows();

	   $value = $num[$arr->datesid];
	   $this->table->add_row(array($arr->classname, date('m-d-Y H:i:s',strtotime($arr->startdate)),  $arr->location, $arr->instructor, $arr->notes, $value));
	   
	   $classID = '';
	   }
	   			$table =  $this->table->generate();
				
	   			$filename = '/tmp/' .$today. '-upComingClassesReport-' .rand(1,1000). '.html';
	   			if ( ! write_file('.' .$filename, $table))
				{
     				echo 'Unable to write the file';
				} else {
     				//echo json_encode($table);
     				echo json_encode('<div class="alert alert-success span6"><i class=" icon-arrow-right"></i> <a href="' .$filename. '" target="_blank"><b>Download Ready!</b> Click Here to Download Upcoming Classes Sheet</a></div>');
				}

//echo json_encode($array);
exit;
			
		}
		
		
	
	
	
	

	


}
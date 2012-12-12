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
   	$this->load->view('header');

   	    $this->load->view('reports_view');
		$this->load->view('footer');
	}
	
	function upcomingClasses() {
	
		$this->load->view('header');

   	    $this->load->view('upcoming_classes');
		$this->load->view('footer');

	
	}

	function generateUpcomingClassesReport() {
	
	
		$this->load->library('table');
		$this->load->helper('file');
		
		$today = date("Y-m-d");
//		$output = '<table>';
		
		$from = $_POST['datepickerFrom'];
		$to = $_POST['datepickerTo'];
		
		$this->load->library('Pdf');
		$this->load->database();
		
$sql = 'SELECT class_schedule.classtitleid, class_schedule.startdate,class_schedule.notes,class_schedule.location,class_schedule.instructor, class_titles.classname FROM `class_schedule` LEFT JOIN `class_titles` as class_titles ON `class_titles`.`id` = `class_schedule`.`classtitleid`  WHERE `startdate` >= \'' .$from. '\' AND `startdate` <= \'' .$to. '\'';
			
		$query = $this->db->query($sql);
		
		$numRows = $query->num_rows();
		
		$this->table->set_heading('Class Name', 'Start Date', 'Location', 'Instructor', 'Notes');

		$tmpl = array ( 'table_open'  => '<html><head><style type="text/css">body{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;}#upcomingClasses{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size:12px;background:#fff;width:100%;border-collapse:collapse;text-align:left;}#upcomingClasses th{font-size:14px;font-weight:normal;color:#039;border-bottom:2px solid #6678b1;padding:10px 8px;}#upcomingClasses td{border-left:1px solid #ccc; border-right:1px solid #ccc;border-bottom:1px solid #ccc;color:#669;padding:6px 8px;}#upcomingClasses tbody tr:hover td{color:#009;}.signature{width:250px;}.largeCheckBox{width:25px;height:25px;margin:0 auto;}</style></head><body><div style="width:100%;height:100%;"><div style="width:100%;height:250px;margin:0 auto;"><table id="upcomingClasses">', 'table_close' => '</table><h4>Total # of Classes: ' .$numRows. '</h4><p style="font-size:10px;">Campus Linc, Inc.<br />25 John Glenn Drive<br />Suite 102<br />Amherst, NY 14228<br />716.688.8688</p></div></body></html>' );

		$this->table->set_template($tmpl);

		
		if ($numRows > 0)
			{
				$array = array();
				$i = 0;
				$i2 = 0;
	   			foreach ($query->result() as $row)
	  			{
	  				//var_dump($row);
	  				$array[$i]= $row;
	      			
	      			
	   			while($i < $numRows)
	   			{
	   				
	   				$sql2 = 'SELECT * FROM `enrollment` WHERE `classid` = \'' .$row->classtitleid. '\' AND `status` = \'1\'';	
	   				echo $sql2;
	      			$query2 = $this->db->query($sql2);
	      			$array[$i]['numRows'] = $query2->num_rows();
	      			$i++;
	      				
	      		}
	   		}
	   	}
	   	
	   //	$table =  $this->table->generate();
	   
	   foreach($array as $arr)
	   {
	   $this->table->add_row(array($arr->classname, $arr->startdate,  $arr->location, $arr->instructor, $arr->notes));
	   
	   }
	   			$filename = '/tmp/' .'upComingClassesReport-' .rand(1,1000). '.html';
	   			if ( ! write_file('.' .$filename, $table))
				{
     				echo 'Unable to write the file';
				} else {
     				//echo json_encode($table);
     				echo json_encode('<h2 style="color:red;"><a href="' .$filename. '" target="_blank">Click Here to Download Upcoming Classes Sheet</a></h2>');
				}

//echo json_encode($array);
exit;
			
		}
		
		
	
	
	
	

	


}
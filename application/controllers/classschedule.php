<?php

class Classschedule extends Application {

	
	function __construct()
	{
		parent::__construct();
		$this->load->library('grocery_CRUD'); 
		$this->load->library('ag_auth');

		
	}
	
	function index()
	{
	if(logged_in()) {
		 $crud = new grocery_CRUD();
		 
    $crud->where('startdate >=',date('Y-m-d 00:00:00'));
   // $crud->set_theme('datatables');
    $crud->set_table('class_schedule');
   // $crud->set_theme('datatables');
    $crud->set_subject('Dates');
  	
  	
  	 $crud->set_relation('classtitleid','class_titles','classname');
    $crud->set_relation('instructor','instructors','instructor_name');
    
    $crud->required_fields(array('classtitleid','startdate','enddate','duration','laptops','type','location','instructor'));
    
    	$crud->display_as('classtitleid','Class');
    	$crud->display_as('startdate','Start Date');
 	   $crud->display_as('enddate','End Date');
 	   $crud->display_as('howmanylaptops','Number of Laptops');
 	   $crud->display_as('laptops','Laptops Needed?');
 	   $crud->display_as('cancelled','Class Cancelled?');
 	   $crud->display_as('duration','Duration (in Hours)');
 	   $crud->display_as('numStudents','Active/CXL');
		    $crud->callback_before_delete(array($this,'checkEnrollmentsBeforeDelete'));

 	   
 	   $crud->unset_add_fields('cancelled');
 	   $crud->order_by('startdate');
  	
// $crud->callback_column('startdate',array($this,'_callback_class_page'));

    $crud->add_action('Roster', '/assets/grocery_crud/themes/flexigrid/css/images/magnifier.png', '/classschedule/classroster',array($this,'_callback_class_page'));

	$crud->callback_add_field('startdate',array($this,'_add_default_date_value'));
	
	 $crud->callback_column('numStudents',array($this,'_get_enrolled_students'));

		
		$crud->columns('classtitleid','startdate','enddate','cancelled','location','type','instructor','numStudents');

   	$output = $crud->render();
   	

   	
   	$this->load->view('header', $output);
    $this->load->view('classschedule_view', $output);
   	$this->load->view('footer');
 	} else { $this->login();}
	}
	
	public function checkEnrollmentsBeforeDelete($primary_key) {
		
		$this->load->database();
		
		$sql = "SELECT id FROM enrollment WHERE datesid = '" .$primary_key. "'";
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0) {
			
			return false;
			
		} else {
		
			return true;
		}
		
	}


	
	public function _callback_class_page($value, $row) {
	
	  return "<a href='".site_url('classschedule/classroster/'.$row->id)."'>" .$value. "</a>";
		
	}
	
	function _add_default_date_value(){
        $value = !empty($value) ? $value : date("m-d-Y 09:00:00");
        $return = '<input type="text" name="startdate" value="'.$value.'" id="field-startdate" class="datetime-input" maxlength="19" /> ';
        $return .= '<a class="datetime-input-clear ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" tabindex="-1" role="button" aria-disabled="false">Clear</a> (mm/dd/yyyy) hh:mm:ss
';
        return $return;
}

	function _get_enrolled_students($value,$row) {
		$this->load->database();
	
	$sql = "SELECT id FROM enrollment where datesid = \"" .$row->id. "\" AND userCancel = '0' AND noshow = '0'";
	$query = $this->db->query($sql);
	
	$sql2 = "SELECT id FROM enrollment where datesid = \"" .$row->id. "\" AND userCancel = '1'";
	$query2 = $this->db->query($sql2);
	
	return '<span class="totalStudents"><b>' .$query->num_rows(). '</b> / ' .$query2->num_rows(). '</span>';		
	}
	
	public function classroster() {
	
	$dateid = $this->uri->segment(3);
	
		$this->load->library('table');
		$this->load->helper('file');
		
		$today = date("m-d-Y");
			
		$this->load->database();
		
		$query = $this->db->query("SELECT startdate,enddate,classtitleid,id FROM class_schedule WHERE id = \"" .$dateid. "\" LIMIT 1");
		
		$row1 = $query->row();
		
		
		$query = $this->db->query('SELECT student.firstname, student.lastname, student.email, company.companyname,billing.billingcontact,enrollment.checkedIn,enrollment.userCancel,enrollment.noshow,enrollment.tuition,class_titles.classname,class_schedule.startdate,class_schedule.enddate,class_schedule.duration,class_schedule.instructor,class_schedule.location,class_schedule.laptops,class_schedule.howmanylaptops,class_schedule.notes,class_titles.url,enrollment.id,class_schedule.type as classType, enrollment.courseware FROM enrollment
LEFT JOIN billing as billing on billing.id = enrollment.billingid
LEFT JOIN company as company on company.id = enrollment.companyid
LEFT JOIN student as student on student.id = enrollment.studentid
LEFT JOIN class_titles as class_titles on class_titles.id = enrollment.classid
LEFT JOIN class_schedule as class_schedule on class_schedule.id = enrollment.datesid
WHERE class_schedule.id = "' .$row1->id. '"'
);

$numRows = $query->num_rows();


		$this->table->set_heading('Cancel Enrollment','Full Name', 'Email', 'Company Name', 'Billing Contact',  'Attended?', 'Cancel?', 'No Show?','Total Cost');

		$tmpl = array ( 'table_open'  => '<style type="text/css">body{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;}#checkIn{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size:12px;background:#fff;width:100%;border-collapse:collapse;text-align:left;}#checkIn th{font-size:14px;font-weight:normal;color:#039;border-bottom:2px solid #6678b1;padding:10px 8px;}#checkIn td{border-left:1px solid #ccc; border-right:1px solid #ccc;border-bottom:1px solid #ccc;color:#669;padding:6px 8px;}#checkIn tbody tr:hover td{color:#009;}.signature{width:250px;}.largeCheckBox{width:25px;height:25px;margin:0 auto;}</style><div style="width:100%;height:100%;"><table id="checkIn">', 'table_close' => '</table>' );

		$this->table->set_template($tmpl);
$grossCost = array();
$grossCourseware = array();
		if ($query->num_rows() > 0)
			{
				$numRows = $query->num_rows();
	   			foreach ($query->result() as $row)
	  			{
	  	if($row->checkedIn == '1') { $checkedIn = 'Yes'; } else { $checkedIn = 'No'; }
	   if($row->userCancel == '1') { $cancelled = 'Yes';} else { $cancelled = 'No'; }
	   if($row->noshow == '1') { $noShow = 'Yes';} else { $noShow = 'No'; }
	   $totalCost = money_format('$%i',$row->tuition);
	   
	   if($row->userCancel != '1' && $row->noshow != '1') {
	  	 $grossCost[] = $row->tuition; 
	  	 $grossCourseware[] = $row->courseware;
	  	  	 
	  	}

	  	
	  	
	  	if($row->userCancel == '1' || $row->noshow == '1') {
	  		
	  		$cxlTxt = '<p style="text-align:center;margin:0;padding:0;">Enrollment CXL or NoShow</p>';

	  	} else {
		  	
		  	$cxlTxt = '<p style="text-align:center;margin:0;padding:0;"><a href="#" id="' .$row->id. '" onclick="cancelEnrollment(' .$row->id. ');return false;">Cancel Enrollment</a></p>';		  	
	  	}
	  	
	  	
	   
	   
	      			$fullname = $row->firstname. ' ' .$row->lastname;
	      			$this->table->add_row(array($cxlTxt,$fullname, $row->email,  $row->companyname, $row->billingcontact,$checkedIn, $cancelled, $noShow, $totalCost));
	      		$output['url'] = $row->url;
	      		$output['classname'] = $row->classname;
	      		$output['length'] = $row->duration. ' Hours';
	      		$output['startdate'] = date('F j, Y - g:i a',strtotime($row->startdate));
	      		$output['instructor'] = $row->instructor;
	      		$output['laptops'] = $row->laptops;
	      		$output['numStudents'] = $numRows;
	      		$output['location'] = $row->location;
	      		$output['duration'] = $row->duration;
	      		$output['notes'] = $row->notes;
	      		$output['laptops'] = $row->laptops;
	      		$output['enddate'] = date('F j, Y - g:i a',strtotime($row->enddate));
	      		$output['url'] = $row->url;
	      		$output['classType'] = $row->classType;
	      		
	      		if($output['laptops'] == 'Yes') { $output['numLaptops'] = $row->howmanylaptops; }
	      		
	      		}	
	      			$netRevenue = array_sum($grossCost) - array_sum($grossCourseware);
	      			$output['grossCost'] = money_format('$%i',array_sum($grossCost));
	      			$output['grossCourseware'] = money_format('$%i',array_sum($grossCourseware));
	      			$output['netRevenue'] = money_format('$%i', $netRevenue);
	   						
	   			
	   			$output['output'] =  $this->table->generate();
	   			
	   				$output['js_files'] = array('//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js','/css/jquery.pnotify.min.js');
		$output['css_files'] = array('/assets/jquery-ui-1.9.2.custom.min.css','/css/jquery.pnotify.default.css','/css/jquery.pnotify.default.icons.css');


	   			$this->load->view('header',$output);
   				$this->load->view('class_roster', $output);
   				$this->load->view('footer');



	   
			} 	else {
	   					$output['output'] = '<div class="alert alert-error">No Students Enrolled For Course. <a href="/classschedule">Click Here to Go Back</a></div>';
	   					$this->load->view('header');
   						$this->load->view('class_roster_empty', $output);
   						$this->load->view('footer');
	   			
	   			}	   
	
	
	
	}
	
	function getLength() {
	
	$this->load->database();
	
		$sql = 'select length from class_titles where id = "' .$_POST['classid']. '"';
		
		
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0) {
		$row = $query->row();
		
		//$result = array('tuition'=>$row->tuition,'courseware'=>$row->courseware);
		
		echo json_encode($row->length);
		
		} else {
		
		echo json_encode('null');
		
		}
		
		
		

	
	
	}
	
	
	
	
	
	
}

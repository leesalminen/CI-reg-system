<?php

class Enrollment extends Application {

	
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

  	$crud->unset_add_fields(array('status','cancelNotes','checkedIn','userCancel','noshow','invoiceID','reminderEmailSent','enrollmentTimestamp','enrollmentUser'));
  	$crud->unset_columns(array('status','cancelNotes','invoiceStatus','emailStudent','reminderEmailSent','po','checkedIn','noshow','courseware','regType'));
  	$crud->unset_edit_fields('status','reminderEmailSent','companyid','billingid','classid','datesid','enrollmentTimestamp','enrollmentUser');

    $crud->set_table('enrollment');
   // $crud->set_theme('datatables');
    $crud->set_subject('Enrollment');
    $name = 'firstname' . 'lastname';
    $crud->set_relation('companyid','company','companyname');
    $crud->set_relation('studentid','student','{firstname} {lastname}');
    $crud->set_relation('billingid','billing', 'billingcontact');
    $crud->set_relation('classid','class_titles', 'classname');
    $crud->set_relation('datesid','class_schedule', 'startdate');
    
	
	$crud->display_as('companyid','Company');
	$crud->display_as('studentid','Student Name');
 	$crud->display_as('classid','Class Name');
 	$crud->display_as('datesid','Class Date');
 	$crud->display_as('status','Enrollment Active?');
 	$crud->display_as('billingid','Billing Contact');
 	$crud->display_as('po','Purchase Order #');
 	$crud->display_as('checkedIn','Checked In?');
 	 $crud->display_as('userCancel','Student Cancel?');
 	$crud->display_as('noshow','No Show?');
 	$crud->display_as('emailStudent','Email Student?');
 	 	$crud->display_as('tuition','List Price');
 	 	 	 	$crud->display_as('regType','Reg. Type');


 	$crud->display_as('cancelNotes','Cancellation Notes');
 	 	$crud->display_as('invoiceStatus','Invoice Status (mark as paid if free re-take)');
 	 	$crud->display_as('invoiceID','Invoice #');
 	 		$crud->display_as('enrollmentUser','User');
 	 	$crud->display_as('enrollmentTimestamp','Timestamp');



	  $crud->required_fields(array('companyid','studentid','billingid','classid','datesid','tuition','courseware'));

    $crud->add_action('Cancel Enrollment', '/assets/grocery_crud/themes/flexigrid/css/images/error.png', '/enrollment/cancelEnrollment',array($this,'cancelEnrollment'));
    
    //$crud->display_as('classname','Course Title', ");

	 $crud->callback_after_insert(array($this, 'emailUserOnRegister'));
	 

   
  	 $output = $crud->render();
  	 
  	$dd_data = array(
    //GET THE STATE OF THE CURRENT PAGE - E.G LIST | ADD
    'dd_state' =>  $crud->getState(),
    //SETUP YOUR DROPDOWNS
    //Parent field item always listed first in array, in this case countryID
    //Child field items need to follow in order, e.g stateID then cityID
    'dd_dropdowns' => array('companyid','studentid','billingid'),
        //SETUP URL POST FOR EACH CHILD
    //List in order as per above
    'dd_url' => array('', site_url().'/enrollment/getStudent/', site_url().'/enrollment/getBillingContact/'),
    //LOADER THAT GETS DISPLAYED NEXT TO THE PARENT DROPDOWN WHILE THE CHILD LOADS
    'dd_ajax_loader' => base_url().'ajax-loader.gif');
	
	$output->dropdown_setup = $dd_data;
	
	
	//print_r($dd_data);
	
	
	

	//$this->output->enable_profiler(TRUE);
  	$this->load->view('header', $output);
    $this->load->view('enrollment_view', $output);
  // $this->load->view('enrollment_view', $output2);
  // $this->load->view('enrollment_view', $finalOutput);
	$this->load->view('footer');
	
	} else { $this->login(); }
	
	}
	
	public function cancelEnrollment() {
	
		$id = $this->uri->segment(3);
		$this->load->database();
				
		$sql = 'UPDATE enrollment SET checkedIn = "0", noshow = "0", userCancel = "1" WHERE id = "' .$id. '" LIMIT 1';
		
		if($this->db->query($sql)) {
		
		$this->load->helper('url');
			
			redirect('/enrollment', 'refresh');
		
		} else { return false;	 }
	
	}

	
	//get dependent student dropdown
	function getStudent() {
	$studentid = $this->uri->segment(3);
		
		$this->db->select("*")
				 ->from('student')
				 ->where('companyid', $studentid);
		$db = $this->db->get();
		
		$array = array();
		foreach($db->result() as $row):
			$fullName = $row->lastname. ', ' .$row->firstname;
			$array[] = array("value" => $row->id, "property" => $fullName);
			
		endforeach;
		
		echo json_encode($array);
		exit;     
	
	}
	
	//get billing contact for sub dropdown
	function getBillingContact() {
	$billingid = $this->uri->segment(3);
		
		/* $this->db->select("*")
				 ->from('student')
				 ->where('id', $billingid); */
				 
		$sql = "SELECT * FROM `student` LEFT JOIN `billing` as billing ON `billing`.`id` = `student`.`billingid` WHERE `student`.`id` = '" .$billingid. "'";
 
		$db = $this->db->query($sql);
		
		$array = array();
		foreach($db->result() as $row):
			$array[] = array("value" => $row->id, "property" => $row->billingcontact);
		endforeach;
		
		echo json_encode($array);
		exit;     
	
	}
	
	function getdates() { 
	$classtitleid = $this->uri->segment(3);
		
		$this->db->select("*")
				 ->from('class_schedule')
				 ->where('classtitleid', $classtitleid)
				 ->where('startdate >=' , strtotime ( '-30 days' , strtotime ( date('Y-m-d 00:00:00'))))
				 ->order_by("startdate","asc");
		$db = $this->db->get();
		
		$array = array();
		foreach($db->result() as $row):
			$array[] = array("value" => $row->id, "property" => date("m-d-Y",strtotime($row->startdate)));
		endforeach;
		 
		echo json_encode($array);
		exit;     
	
	}


	function emailUserOnRegister($post_array,$primary_key) {
		$this->load->database();
		$this->load->helper('ag_auth');
		date_default_timezone_set('America/New_York');
		$now = date('m-d-Y H:i:s');
		
		$sql = "UPDATE enrollment SET enrollmentTimestamp = \"" .$now. "\" , enrollmentUser = \"" .username(). "\" WHERE id = \"" .$primary_key. "\"";
		$this->db->query($sql);

		
	
	if($post_array['emailStudent'] == '1') {
	
		$sql = 'select firstname,lastname,email,ccemail,class_titles.classname,class_titles.url,class_schedule.location,class_schedule.duration,class_schedule.startdate,class_schedule.enddate from enrollment
left join student as student on student.id = enrollment.studentid
left join class_titles as class_titles on class_titles.id = enrollment.classid
left join class_schedule as class_schedule on class_schedule.id = enrollment.datesid
where enrollment.id = "' .$primary_key. '"
LIMIT 1';
		
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0) {
		
		$row = $query->row();
		
		$userEmail = $row->email;
		$ccEmail = $row->ccemail;
		//$ccEmail = 'leesalminen@gmail.com';
	
		$this->load->library('email');

$this->email->from('mary@campuslinc.com', 'Campus Linc Class Confirmation');
$this->email->to($userEmail); 
if($ccEmail != '') { $this->email->cc($ccEmail); }
$this->email->bcc('jason@campuslinc.com');

$this->email->subject('New Enrollment For ' .$row->classname);

if($row->location == 'Campus Linc') {

$this->email->message("Greetings " .$row->firstname. ",\n\nYou are now registered for " .$row->classname. ". This course starts on " .date('m-d-Y H:i:s',strtotime($row->startdate)). " and ends on " .date('m-d-Y H:i:s',strtotime($row->enddate)). ".You can view more information about the course here: " .$row->url. "\n\nClass will be held at Campus Linc's offices which are located at 25 John Glenn Drive in Amherst, NY. A map to our location can be found here - http://www.campuslinc.com/Directions.asp.  You can click on the red marker for directions.\n\n*** PARKING IS BEHIND THE BUILDING.  If you’re coming from the thruway and Sweet Home Road, turn left on N. French Road.  Turn into the driveway on the left after John Glenn Drive; you’ll see the Campus Linc Parking sign.\n\nThere is a sidewalk to the right of the building that will bring you to the front. Campus Linc is the first entrance you come to at the front of the building.  There is handicapped parking in the front lot.\n\nCourseware will be provided to take with you after class.  You may want to bring a pen and notebook.\n\nIf you have additional questions prior to class, please feel free to call me at 716-688-8688.  Thank you for your registration.\n\nCANCELLATION POLICY:\nStudents needing to cancel a class must provide at least five business days advance notice for desktop applications and project management courses, ten business days for technical computer courses. Students who fail to attend a class for which they are enrolled will be charged full price. If the registered participant is unable to attend the course, a substitute is welcome to take their place.\n\nCampus Linc Inc. reserves the right to cancel a course due to low enrollment or circumstances beyond our control.  Every effort will be made to reschedule a cancelled class or transfer enrollment to a later date.\n\n-- Campus Linc\n716-688-8688\nwww.campuslinc.com\n");

} else if($row->location == 'Canisius') {

$this->email->message("Greetings " .$row->firstname. ",\n\nWe are confirming your registration for " .$row->classname. " which starts on " .date('m-d-Y H:i:s',strtotime($row->startdate)). " and ends on " .date('m-d-Y H:i:s',strtotime($row->enddate)). " at Canisius College Professional Center.You can view more information about the course here: " .$row->url. "\n\nPlease reply to this e-mail so that I know you will be heading to Canisius Center and not the Campus Linc facility.  Thank you.\n\nCanisius Center is located at University Corporate Center, 300 Corporate Parkway, North Suite 130, Amherst, NY 14226. University Corporate Center is located just off of Maple Road near Sweet Home Road. Their phone number is (716)888-8490.\n\nWhen you drive into the complex, yield right and 300 Corporate Parkway is on your left.  Parking is on the right.  The entrance door is behind the Visitor Parking and has North 300 above the door.  Once you enter, Canisius Center will be the third door on the right.\n\nCourseware will be provided to take with you after class.  You may want to bring a pen and notebook.\n\nIf you have additional questions prior to class, please feel free to call me at 716-688-8688.  Thank you for your attendance.\n\n-- Campus Linc\n716-688-8688\nwww.campuslinc.com");


} else if($row->location == 'Holiday Inn Rochester Airport') {


$this->email->message("Greetings " .$row->firstname. ",\n\nYou are now registered for " .$row->classname. ". This course starts on " .date('m-d-Y H:i:s',strtotime($row->startdate)). " and ends on " .date('m-d-Y H:i:s',strtotime($row->enddate)). ".You can view more information about the course here: " .$row->url. "\n\nClass will be held at Holiday Inn Rochester Airport, 911 Brooks Avenue, Rochester, NY.  Their phone number is (585) 328-6000.\n\nCourseware will be provided to take with you after class.  You may want to bring a pen and notebook.\n\nIf you have additional questions prior to class, please feel free to call me at 716-688-8688.  Thank you for your registration.\n\nCANCELLATION POLICY:\nStudents needing to cancel a class must provide at least five business days advance notice for desktop applications and project management courses, ten business days for technical computer courses.\nStudents who fail to attend a class for which they are enrolled will be charged full price.\nIf the registered participant is unable to attend the course, a substitute is welcome to take their place.\n\nCampus Linc Inc. reserves the right to cancel a course due to low enrollment or circumstances beyond our control.  Every effort will be made to reschedule a cancelled class or transfer enrollment to a later date.\n\n-- Campus Linc\n716-688-8688\nwww.campuslinc.com");


} else if($row->location == 'Customer Location') {

return true;

} else { return true; }

$this->email->send();
	}
	
	return true;
	} else { return true; }
	}
	
	function getMSRP() {
	
	$this->load->database();
	
		$sql = 'select tuition,courseware from class_titles where id = "' .$_POST['classid']. '"';
		
		
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0) {
		$row = $query->row();
		
		$result = array('tuition'=>$row->tuition,'courseware'=>$row->courseware);
		
		echo json_encode($result);
		
		} else {
		
		echo json_encode('null');
		
		}
		
		
		

	
	
	}
		
	
}//end of extender

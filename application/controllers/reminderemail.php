<?php

class Reminderemail extends Application {

	
	function __construct()
	{
		parent::__construct();
		$this->load->library('grocery_CRUD'); 
		$this->load->library('ag_auth');

		
	}
	
	function index()
	{
	if(logged_in()) {
	
	
	
		$array['js_files'] = array('//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js','/css/jquery.pnotify.min.js');
		$array['css_files'] = array('http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css','/css/jquery.pnotify.default.css','/css/jquery.pnotify.default.icons.css');

   	
   	$this->load->view('header',$array);
    $this->load->view('reminder_email');
   	$this->load->view('footer');
 	
 	
 	
 	
 	
 	} else { $this->login();}
	}
	
	
	
		public function getEnrollments() {
	//$company = $_POST['companyid'];
	$fromDate = $_POST['datepickerFrom'];
	if($_POST['datepickerTo'] != '') {
		$toDate = $_POST['datepickerTo'];
	} else {
		$toDate = '2050-12-31';
	}
	
	$this->load->database();
	$this->load->library('table');

	
	$sql = "SELECT student.firstname,student.lastname,class_titles.classname,class_titles.tuition,class_titles.courseware,class_titles.length,class_schedule.startdate,class_schedule.location,billing.id as billingid,billing.attentionto,billing.billingcontact,billing.billingaddress,billing.billingaddress2,billing.billingcity,billing.billingstate,billing.billingzip,enrollment.checkedIn,enrollment.noshow,enrollment.id as enrollmentid FROM enrollment
LEFT JOIN student as student on student.id = enrollment.studentid
LEFT JOIN class_titles as class_titles on class_titles.id = enrollment.classid
LEFT JOIN class_schedule as class_schedule on class_schedule.id = enrollment.datesid
LEFT JOIN billing as billing on billing.id = enrollment.billingid
WHERE startdate >= \"" .$fromDate. "%\"
AND enddate <= \"" .$toDate. "%\"
AND emailStudent = '1'
AND userCancel = '0'
AND enrollment.reminderEmailSent = '0'
";

	$query = $this->db->query($sql);
	
	$tmpl = array ( 'table_open'  => '<style type="text/css">body{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;}p.liveButton{width:100%;height:100%;line-height:26px;padding:0;margin:0;}.green{background-color:#CFC;}.liveButton{text-align:center;margin:0;padding:0;}#checkIn{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size:12px;background:#fff;width:100%;border-collapse:collapse;text-align:left;}#checkIn th{font-size:14px;font-weight:normal;color:#039;border-bottom:2px solid #6678b1;padding:10px 8px;}#checkIn td{border-left:1px solid #ccc; border-right:1px solid #ccc;border-bottom:1px solid #ccc;color:#669;padding:5px 4px;}#checkIn tbody tr:hover{background-color:#eee;}#checkIn tbody tr:hover td{color:#009;}.signature{width:250px;}.largeCheckBox{width:25px;height:25px;margin:0 auto;}</style><div style="width:100%;height:100%;"><table id="checkIn">', 'table_close' => '</table></div>' );

	$this->table->set_template($tmpl);


	
	$this->table->set_heading('Select','Full Name', 'Service Offered', 'Start Date', 'Length','Location');	

	$array = array();
		foreach($query->result() as $row){
			$array[] = $row;	
		
		}	
	foreach($array as $row) {
		
	    $fullname = $row->firstname. ' ' .$row->lastname;
	    
	    $this->table->add_row('<input type="checkbox" id="checkbox' .$row->enrollmentid. '" value="' .$row->enrollmentid. '" name="checkbox' .$row->enrollmentid. '" class="checkbox" />',$fullname, $row->classname, date('m-d-Y H:i:s',strtotime($row->startdate)), $row->length,$row->location);
	    
	}
	
	$table = $this->table->generate();
	
	echo json_encode($table);

	}
	
	
	
	function sendReminderEmail() {
	
	$this->load->database();
		
		$values = array();
		foreach($_POST as $k=>$v) {
			$values[] = $v;
		}
		
		foreach($values as $value) {
		
		$sql = 'select firstname,lastname,email,ccemail,class_titles.classname,class_titles.url,class_schedule.location,class_schedule.duration,class_schedule.startdate from enrollment
left join student as student on student.id = enrollment.studentid
left join class_titles as class_titles on class_titles.id = enrollment.classid
left join class_schedule as class_schedule on class_schedule.id = enrollment.datesid
where enrollment.id = "' .$value. '"
LIMIT 1';
		
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0) {
		
		$row = $query->row();
		
		$userEmail = $row->email;
		$ccEmail = $row->ccemail;
		//$ccEmail = 'leesalminen@gmail.com';
	
		$this->load->library('email');

$this->email->from('enrollment@campuslinc.com', 'Campus Linc Online Registration');
$this->email->to($userEmail); 
if($ccEmail != '') { $this->email->cc($ccEmail); }
$this->email->bcc('leesalminen@gmail.com');

$this->email->subject('Reminder Email For ' .$row->classname);

if($row->location == 'Campus Linc') {

$this->email->message("Greetings,\n\nYou are now registered for " .$row->classname. " on " .date('m-d-Y H:i:s',strtotime($row->startdate)). " at " .$row->location. ". This class lasts for " .$row->duration. " Hours.\n\nClass will be held at 25 John Glenn Drive in Amherst, NY. A map to our location can be found here - http://www.campuslinc.com/Directions.asp.  You can click on the red marker for directions.\n\n*** Parking is behind the building.  If you’re coming from the thruway and Sweet Home Road, turn left on N. French Road.  Turn into the driveway on the left after John Glenn Drive; you’ll see the Campus Linc Parking sign.  There is a sidewalk to the right of the building that will bring you to the front. Campus Linc is the first entrance you come to at the front of the building.  There is handicapped parking in the front lot.\n\nCourseware will be provided to take with you after class.  You may want to bring a pen and notebook.\n\nIf you have additional questions prior to class, please feel free to call me at 716-688-8688.  Thank you for your registration.\n\nYou can view more information about the course here: " .$row->url. "\n\nCancellation Policy:\nStudents needing to cancel a class must provide at least five business days advance notice for desktop applications and project management courses, ten business days for technical computer courses.\nStudents who fail to attend a class for which they are enrolled will be charged full price.\nIf the registered participant is unable to attend the course, a substitute is welcome to take their place.\n\nCampus Linc Inc. reserves the right to cancel a course due to low enrollment or circumstances beyond our control.  Every effort will be made to reschedule a cancelled class or transfer enrollment to a later date.\n\n-- Campus Linc\n716-688-8688\nwww.campuslinc.com");

} else if($row->location == 'Canisius') {

$this->email->message("Greetings,\n\nWe are confirming your registration for " .$row->classname. " on " .date('m-d-Y H:i:s',strtotime($row->startdate)). " at Canisius College Professional Center. This class lasts for " .$row->duration. " Hours.\n\nPlease reply to this e-mail so that I know you will be heading to Canisius Center and not the Campus Linc facility.  Thank you.\n\nCanisius Center is located at University Corporate Center, 300 Corporate Parkway, North Suite 130, Amherst, NY 14226. University Corporate Center is located just off of Maple Road near Sweet Home Road. Their phone number is (716)888-8490.\n\nWhen you drive into the complex, yield right and 300 Corporate Parkway is on your left.  Parking is on the right.  The entrance door is behind the Visitor Parking and has North 300 above the door.  Once you enter, Canisius Center will be the third door on the right.\n\nCourseware will be provided to take with you after class.\n\nYou can view more information about the course here: " .$row->url. "\n\nYou may want to bring a pen and notebook.\n\nIf you have additional questions prior to class, please feel free to call me at 716-688-8688.  Thank you for your attendance.\n\n-- Campus Linc\n716-688-8688\nwww.campuslinc.com");


} else if($row->location == 'Holiday Inn Rochester Airport') {


$this->email->message("Greetings,\n\nYou are now registered for " .$row->classname. " on " .date('m-d-Y H:i:s',strtotime($row->startdate)). " at " .$row->location. ". This class lasts for " .$row->duration. " Hours.\n\nClass will be held at Holiday Inn Rochester Airport, 911 Brooks Avenue, Rochester, NY.  Their phone number is (585) 328-6000.\n\nCourseware will be provided to take with you after class.  You may want to bring a pen and notebook.\n\nIf you have additional questions prior to class, please feel free to call me at 716-688-8688.  Thank you for your registration.\n\nYou can view more information about the course here: " .$row->url. "\n\nCancellation Policy:\nStudents needing to cancel a class must provide at least five business days advance notice for desktop applications and project management courses, ten business days for technical computer courses.\nStudents who fail to attend a class for which they are enrolled will be charged full price.\nIf the registered participant is unable to attend the course, a substitute is welcome to take their place.\n\nCampus Linc Inc. reserves the right to cancel a course due to low enrollment or circumstances beyond our control.  Every effort will be made to reschedule a cancelled class or transfer enrollment to a later date.\n\n-- Campus Linc\n716-688-8688\nwww.campuslinc.com");


} else if($row->location == 'Customer Location') {

echo '1';

} else { echo '0'; }


$this->email->send();
$this->email->clear();

$sql2 = "UPDATE enrollment SET reminderEmailSent = \"1\" WHERE id = \"" .$value. "\"";
$this->db->query($sql2);

}
	
}

echo '1';	

	
	
	
	
	///end
	}	
}
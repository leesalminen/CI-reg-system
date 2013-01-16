<?php

class Student extends Application {

	
	function __construct()
	{
		parent::__construct();
		$this->load->library('grocery_CRUD'); 
		$this->load->library('ag_auth');

	}
	
	function index()
	{
	if(logged_in()){
		 $crud = new grocery_CRUD();
 
   // $crud->set_theme('datatables');
    $crud->set_table('student');
   //$crud->set_theme('datatables');
    $crud->set_subject('Student');
    
   
    $crud->set_relation('companyid','company','companyname');
    $crud->set_relation('billingid','billing','billingcontact');
    
     $crud->required_fields(array('companyid','billingid','firstname','lastname','email','telephone'));
    
    $crud->unset_columns('ccemail','middleinitial');	
  	$crud->display_as('companyid','Company');
	$crud->display_as('billingid','Billing Contact');
 	$crud->display_as('firstname','First Name');
 	$crud->display_as('lastname','Last Name');
 	$crud->display_as('middleinitial','Middle Initial');
 	$crud->display_as('ccemail','CC-Email');

 // $crud->add_action('Student Transcript Report', '/assets/grocery_crud/themes/flexigrid/css/images/magnifier.png', '/student/generateStudentTranscriptReportByID',array($this,'_callback_class_page'));


       $crud->add_action('Student Transcript Report', '/assets/grocery_crud/themes/flexigrid/css/images/magnifier.png', '','',array($this,'_callback_class_page'));
       
              $crud->set_rules('telephone','10 Digit Phone Number (XXXXXXXXXX)','integer');


   	$output = $crud->render();
   	
   	 //start dependent dropdown
  	 //DEPENDENT DROPDOWN SETUP
	$dd_data = array(
    //GET THE STATE OF THE CURRENT PAGE - E.G LIST | ADD
    'dd_state' =>  $crud->getState(),
    //SETUP YOUR DROPDOWNS
    //Parent field item always listed first in array, in this case countryID
    //Child field items need to follow in order, e.g stateID then cityID
    'dd_dropdowns' => array('companyid','billingid'),
    //SETUP URL POST FOR EACH CHILD
    //List in order as per above
    'dd_url' => array('', site_url().'/student/getBillingContact/', site_url().'/student/getdates/'),
    //LOADER THAT GETS DISPLAYED NEXT TO THE PARENT DROPDOWN WHILE THE CHILD LOADS
    'dd_ajax_loader' => base_url().'ajax-loader.gif'
	);
	$output->dropdown_setup = $dd_data;
  	 
  	 
  	 //end dependent dropdown
   	
   	
   	//load views
   	$this->load->helper('ag_auth');
   	$output->username = username();
   	$this->load->view('header',$output);
   	 $this->load->view('student_view', $output);
       	$this->load->view('footer');   	
	} else { $this->login(); }
	}

//get billing contact for sub dropdown
	function getBillingContact() {
	$billingid = $this->uri->segment(3);
		
		$this->db->select("*")
				 ->from('billing')
				 ->where('companyid', $billingid);
		$db = $this->db->get();
		
		$array = array();
		foreach($db->result() as $row):
			$array[] = array("value" => $row->id, "property" => $row->billingcontact);
		endforeach;
		
		echo json_encode($array);
		exit;     
	
	}
public function _callback_class_page($value, $row) {
	
	  return '/student/generateStudentTranscriptReportByID/'.$row->id. '/' .$row->companyid;
		
	}
/* this would be if you want another dependent dropdown

function get_company()
	{
		$countryID = $this->uri->segment(3);
		
		$this->db->select("*")
				 ->from('company')
				 ->where('ID', $ID);
		$db = $this->db->get();
		
		$array = array();
		foreach($db->result() as $row):
			$array[] = array("value" => $row->id, "property" => $row->companyname);
		endforeach;
		
		echo json_encode($array);
		exit;
	}
	*/

	function generateStudentTranscriptReportByID() {
	
	
		$this->load->library('table');
		$this->load->helper('file');
		
		$today = date("m-d-Y");
//		$output = '<table>';
			$student = $this->uri->segment(3);
			$company = $this->uri->segment(4);
		
		//$this->load->library('Pdf');
		$this->load->database();
		
//$sql = 'SELECT class_schedule.id,class_schedule.classtitleid, class_schedule.startdate,class_schedule.notes,class_schedule.location,class_schedule.instructor, class_titles.classname FROM `class_schedule` LEFT JOIN `class_titles` as class_titles ON `class_titles`.`id` = `class_schedule`.`classtitleid`  WHERE `startdate` >= \'' .$from. '\' AND `startdate` <= \'' .$to. '\' AND `cancelled` = \'NO\'';


		//$sql = "SELECT * FROM enrollment WHERE studentid = '" .$student. "' AND companyid = '" .$company. "' AND status = '1' AND checkedin='1'";
		
		$sql = "SELECT * 
FROM enrollment
LEFT JOIN class_schedule ON ( enrollment.datesid = class_schedule.id ) 
LEFT JOIN class_titles ON ( enrollment.classid = class_titles.id ) 
LEFT JOIN student ON (enrollment.studentid = student.id)
LEFT JOIN company ON company.id = enrollment.companyid
WHERE enrollment.studentid =  '" .$student. "'
AND cancelled = 'No'
ORDER BY startdate
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
		$fullName = $array[0]->lastname. ', ' .$array[0]->firstname;
		$numberOfClasses = count($array);
		$today = date('m-d-Y');
		$this->table->set_heading('Class Name', 'Start Date', 'End Date', 'Attended?', 'Cancelled?', 'No Show?');

		$tmpl = array ( 'table_open'  => '<style type="text/css">body{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;}#upcomingClasses{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size:12px;background:#fff;width:100%;border-collapse:collapse;text-align:left;}#upcomingClasses th{font-size:14px;font-weight:normal;color:#039;border-bottom:2px solid #6678b1;padding:10px 8px;}#upcomingClasses td{border-left:1px solid #ccc; border-right:1px solid #ccc;border-bottom:1px solid #ccc;color:#669;padding:6px 8px;}#upcomingClasses tbody tr:hover td{color:#009;}.signature{width:250px;}.largeCheckBox{width:25px;height:25px;margin:0 auto;}</style><table id="upcomingClasses">', 'table_close' => '</table>' );

		$this->table->set_template($tmpl);
		   
	   foreach($array as $arr)
	   {
	   if($arr->checkedIn == '1') { $checkedIn = 'Yes'; } else { $checkedIn = 'No'; }
	   if($arr->userCancel == '1') { $cancelled = 'Yes';} else { $cancelled = 'No'; }
	   if($arr->noshow == '1') { $noShow = 'Yes';} else { $noShow = 'No'; }

	   $this->table->add_row(array($arr->classname, date('m-d-Y H:i:s',strtotime($arr->startdate)),  date('m-d-Y H:i:s',strtotime($arr->enddate)), $checkedIn, $cancelled, $noShow));
	   
	   }
	   			$output['output'] =  $this->table->generate();
				
	   			$output['fullname'] = $row->firstname. ' ' .$row->lastname;
	      		$output['company'] = $row->companyname;
	      		$output['today'] = date('m-d-Y');
	      		$output['total'] = $numberOfClasses;
	      		
	      		$this->load->view('header',$output);
   				$this->load->view('student_transcript_report_view', $output);
   				$this->load->view('footer');
		
		} else {	
		
				$output['output'] = "<div class='alert alert-error'>No Classes Found For Student. <a href='/student'>Click Here</a> to go back</div>";
			
				$this->load->view('header',$output);
   				$this->load->view('student_transcript_report_view_empty', $output);
   				$this->load->view('footer');
		

			
			
		}
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
			$output .= '<div><span style="font-weight:bold;">' .$row->lastname. ', ' .$row->firstname. '</span> - ' .$row->companyname.' <button class="studentSubmit" type="submit" onclick="generateReportByName('.$row->id.','.$row->companyid.');return false;">Generate Report</button></form></div>';
		
		}	
		
		echo json_encode($output);
		
		} else { echo json_encode('No Student Found'); }
	
	
	
	
	
	}



}
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
 	   
 	   $crud->unset_add_fields('cancelled');
 	   $crud->order_by('startdate');
  	
// $crud->callback_column('startdate',array($this,'_callback_class_page'));

    $crud->add_action('Roster', '/assets/grocery_crud/themes/flexigrid/css/images/magnifier.png', '/classschedule/classroster',array($this,'_callback_class_page'));

	$crud->callback_add_field('startdate',array($this,'_add_default_date_value'));

   
   	$output = $crud->render();
   	

   	
   	$this->load->view('header', $output);
    $this->load->view('classschedule_view', $output);
   	$this->load->view('footer');
 	} else { $this->login();}
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
	
	public function classroster() {
	
	$dateid = $this->uri->segment(3);
	
		$this->load->library('table');
		$this->load->helper('file');
		
		$today = date("m-d-Y");
			
		$this->load->database();
		
		$query = $this->db->query("SELECT classtitleid FROM class_schedule WHERE id = \"" .$dateid. "\" LIMIT 1");
		
		$row = $query->row();
		
		
		$query = $this->db->query("SELECT * 
FROM (`enrollment`)
LEFT JOIN `billing` as jde77bf36 ON `jde77bf36`.`id` = `enrollment`.`billingid` 
LEFT JOIN `company` as j480e8462 ON `j480e8462`.`id` = `enrollment`.`companyid`
LEFT JOIN `student` as jc6e86205 ON `jc6e86205`.`id` = `enrollment`.`studentid`
LEFT JOIN `class_titles` as jd45e51a1 ON `jd45e51a1`.`id` = `enrollment`.`classid`
LEFT JOIN `class_schedule` as jdd77bf35 ON `jdd77bf35`.`id` = `enrollment`.`datesid`
WHERE `jd45e51a1`.`id` = '" .$row->classtitleid. "'  ");


$numRows = $query->num_rows();


		$this->table->set_heading('Cancel Enrollment','Full Name', 'Email', 'Company Name', 'Billing Contact',  'Attended?', 'Cancel?', 'No Show?','Total Cost');

		$tmpl = array ( 'table_open'  => '<style type="text/css">body{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;}#checkIn{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size:12px;background:#fff;width:100%;border-collapse:collapse;text-align:left;}#checkIn th{font-size:14px;font-weight:normal;color:#039;border-bottom:2px solid #6678b1;padding:10px 8px;}#checkIn td{border-left:1px solid #ccc; border-right:1px solid #ccc;border-bottom:1px solid #ccc;color:#669;padding:6px 8px;}#checkIn tbody tr:hover td{color:#009;}.signature{width:250px;}.largeCheckBox{width:25px;height:25px;margin:0 auto;}</style><div style="width:100%;height:100%;"><table id="checkIn">', 'table_close' => '</table>' );

		$this->table->set_template($tmpl);

		if ($query->num_rows() > 0)
			{
				$numRows = $query->num_rows();
	   			foreach ($query->result() as $row)
	  			{
	  	if($row->checkedIn == '1') { $checkedIn = 'Yes'; } else { $checkedIn = 'No'; }
	   if($row->userCancel == '1') { $cancelled = 'Yes';} else { $cancelled = 'No'; }
	   if($row->noshow == '1') { $noShow = 'Yes';} else { $noShow = 'No'; }
	   $totalCost = money_format('$%i',$row->tuition);
	      			$fullname = $row->firstname. ' ' .$row->lastname;
	      			$this->table->add_row(array('<p style="text-align:center;margin:0;padding:0;"><a href="#" id="' .$row->id. '" onclick="cancelEnrollment(' .$row->id. ');return false;">Cancel Enrollment</a></p>',$fullname, $row->email,  $row->companyname, $row->billingcontact,$checkedIn, $cancelled, $noShow, $totalCost));
	      		$output['url'] = $row->url;
	      		$output['classname'] = $row->classname;
	      		$output['length'] = $row->duration. ' Hours';
	      		$output['startdate'] = date('F j, Y - g:i a',strtotime($row->startdate));
	      		$output['instructor'] = $row->instructor;
	      		$output['laptops'] = $row->laptops;
	      		$output['numStudents'] = $numRows;
	      		$output['location'] = $row->location;
	      			
	      			
	   			}			
	   			
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

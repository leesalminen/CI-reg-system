<?php

class Checkin extends CI_Controller {

	
	function __construct()
	{
		parent::__construct();
		$this->load->library('grocery_CRUD'); 
		
	}
	
	function index()
	{
		 $crud = new grocery_CRUD();
		  
	
 
   // $crud->set_theme('datatables');
    $crud->set_table('enrollment');
    
    //set where clause set to today. Only shows courses with students enrolled that are running today
    //set variable to today
    $today = date("Y-m-d");
   //Where clause
   echo $today;
    $crud->where('startdate', $today);
    //LEE TEST -- seems to work
    $crud->where('status','1');
    
   $crud->set_theme('datatables');
    $crud->set_subject('');
      //hide add, edit, delete buttons
            $crud->unset_add();
           
            

    //set database relationships
   $crud->set_relation('companyid','company','companyname');
    $crud->set_relation('studentid','student','{firstname} {lastname}');
   $crud->set_relation('classid','class_titles','classname');
   $crud->set_relation('datesid','class_schedule','startdate');
      
      
       //hide column
      $crud->unset_columns('billingid', 'po');
   
    
    //$crud->display_as('companyid','Company Name');
  	

$this->output->enable_profiler(TRUE);

   
   	$output = $crud->render();
   	$this->load->view('header',$output);
   	 $this->load->view('checkin_view', $output);
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
	
	function generateCheckinSheet() {
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
		$this->load->library('Pdf');
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

$query2 = $this->db->query("SELECT classname, length FROM class_titles WHERE id = '" .$class. "'" );
$row2 = $query2->row();

		$this->table->set_heading('Full Name', 'Email', 'Company Name', 'Billing Contact', 'Attended', 'N/S', 'CXL', 'Tuition');

		$tmpl = array ( 'table_open'  => '<html><head><style type="text/css">body{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;}#checkIn{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size:12px;background:#fff;width:100%;border-collapse:collapse;text-align:left;}#checkIn th{font-size:14px;font-weight:normal;color:#039;border-bottom:2px solid #6678b1;padding:10px 8px;}#checkIn td{border-bottom:1px solid #ccc;color:#669;padding:6px 8px;}#checkIn tbody tr:hover td{color:#009;}.largeCheckBox{width:25px;height:25px;border:2px solid black;margin:0 auto;}</style></head><body><div style="width:100%;height:100%;"><div style="width:100%;height:100px;margin:0 auto;"><h1>Campus Linc - Check In Sheet</h1><h3>Start Date: ' .$date. '  |  Length: ' .$row2->length. '  |  Class: ' .$row2->classname. '</h3></div><table border="1" cellpadding="2" cellspacing="1" id="checkIn">', 'table_close' => '</table><h4>Total # of Students: ' .$numRows. '</div></body></html>' );

		$this->table->set_template($tmpl);

		if ($query->num_rows() > 0)
			{
				$numRows = $query->num_rows();
	   			foreach ($query->result() as $row)
	  			{
	      			$fullname = $row->firstname. ' ' .$row->lastname;
	      			$this->table->add_row(array($fullname, $row->email,  $row->companyname, $row->billingcontact, '<div class="largeCheckbox"></div>', '<div class="largeCheckbox"></div>', '<div class="largeCheckbox"></div>', $row->tuition));
	
	      			
	   			}
	   			
	   			
	   			$table =  $this->table->generate();
	   			$filename = '/tmp/' .$today. '-' .$class. '-' .rand(1,2). '.html';
	   			if ( ! write_file('.' .$filename, $table))
				{
     				echo 'Unable to write the file';
				} else {
     				//echo json_encode($table);
     				echo json_encode('<h2 style="color:red;"><a href="' .$filename. '">Click Here to Download CheckIn Sheet</a></h2>');
				}
	   
			} 	
		}

}
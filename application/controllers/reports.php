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

	function generateUserReport()
	{
		
		if(logged_in())
		{
		error_reporting(0);  //suppress some error message
		$parameters=array(
			'paper'=>'letter',   //paper size
			'orientation'=>'landscape',  //portrait or lanscape
			'type'=>'color',   //paper type: none|color|colour|image
			'options'=>array(1.0, 1.0, 1.0) //I specified the paper as color paper, so, here's the paper color (RGB)
		);
		$this->load->library('pdf', $parameters);  //load ezPdf library with above parameters
		$this->pdf->selectFont(APPPATH.'/third_party/pdf-php/fonts/Helvetica.afm');  //choose font, watch out for the dont location!
		$this->pdf->ezText('Campus Linc - User Report',20);  //insert text with size
 
		//get data from database (note: this should be on 'models' but mehhh..), we'll try creating table using ezPdf
		$q=$this->db->query('SELECT id, username, email, group_id FROM users');
                //this data will be presented as table in PDF
		$data_table=array();
		foreach ($q->result_array() as $row) {
			$data_table[]=$row;
		}
                //this one is for table header
		$column_header=array(
			'id'=>'User ID',
			'username'=>'User Name',
			'email'=>'Email Address',
			'group_id'=>'Group'
		);
		$this->pdf->ezTable($data_table, $column_header); //generate table
		$this->pdf->ezSetY(480);  //set vertical position
		$this->pdf->ezStream(array('Content-Disposition'=>'UserReport.pdf'));
		}
		else
		{
			$this->login();
		}
	}

	function generateStudentReport()
	{
		
		if(logged_in())
		{
		error_reporting(0);  //suppress some error message
		$parameters=array(
			'paper'=>'letter',   //paper size
			'orientation'=>'landscape',  //portrait or lanscape
			'type'=>'color',   //paper type: none|color|colour|image
			'options'=>array(1.0, 1.0, 1.0) //I specified the paper as color paper, so, here's the paper color (RGB)
		);
		$this->load->library('pdf', $parameters);  //load ezPdf library with above parameters
		$this->pdf->selectFont(APPPATH.'/third_party/pdf-php/fonts/Helvetica.afm');  //choose font, watch out for the dont location!
		$this->pdf->ezText('Campus Linc - Student Report',20);  //insert text with size
 
		//get data from database (note: this should be on 'models' but mehhh..), we'll try creating table using ezPdf
		$q=$this->db->query('SELECT id, classname, tuition, courseware, length FROM class_titles');
                //this data will be presented as table in PDF
		$data_table=array();
		foreach ($q->result_array() as $row) {
			$data_table[]=$row;
		}
                //this one is for table header
		$column_header=array(
			'id'=>'Class ID',
			'classname'=>'Class Name',
			'tuition'=>'Tuition',
			'courseware'=>'Courseware',
			'length'=>'Class Length'
		);
		$options = array(
			'font-size'=>'8',
			'width'=>'700',
			'max-width'=>'700'
		);
		$this->pdf->ezTable($data_table, $column_header,'Student Report',$options); //generate table
		$this->pdf->ezSetY(0);  //set vertical position
		$this->pdf->ezStream(array('Content-Disposition'=>'just_random_filename.pdf'));
		}
		else
		{
			$this->login();
		}
	}


	


}
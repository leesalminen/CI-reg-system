<?php

class aBComparison extends Application {

	
	function __construct()
	{
		parent::__construct();
		$this->load->library('grocery_CRUD'); 
		$this->load->library('ag_auth');

		
	}
	
	function index()
	{
	if(logged_in()) {
	
	$this->load->database();
	$sql = "SELECT classname,id from class_titles ORDER BY classname";
	$query = $this->db->query($sql);
	
	$output['classnames'] = array();
	
	foreach ($query->result() as $row)
  			{
      			if($row->classname) 
      			{
      				$output['classname'][] = '<option value="' .$row->id. '">' .$row->classname. '</option>';
      			}
   			}

	
	
	
		$array['js_files'] = array('//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js','/css/jquery.pnotify.min.js');
		$array['css_files'] = array('http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css','/css/jquery.pnotify.default.css','/css/jquery.pnotify.default.icons.css');

   	
   	$this->load->view('header',$array);
    $this->load->view('ab_comparison',$output);
   	$this->load->view('footer');
 	
 	
 	
 	
 	
 	} else { $this->login();}
	}
	
	
	
public function do_compare() {
	
	$classA = $_POST['classA'];
	$classB = $_POST['classB'];
	
	$this->load->database();
	$this->load->library('table');

	$sql = "SELECT studentid from enrollment where classid = \"" .$classA. "\"";

	$query = $this->db->query($sql);
	$array1 = array();
	foreach($query->result() as $row) {
		$array1[] = $row->studentid;
	}
	
	$sql = "SELECT studentid from enrollment where classid = \"" .$classB. "\"";

	$query = $this->db->query($sql);
	
	$array2 = array();
	foreach($query->result() as $row) {
		$array2[] = $row->studentid;
	}
	
	$compare = array_diff($array1, $array2);
		if(!array_key_exists('0',$compare)) { echo json_encode('<h3 style="color:red;">No Students Found. Try again!</h3>'); exit; } else {

		
	//$data = array();
	foreach($compare as $comp) {
		$sql = "SELECT firstname,lastname,billingcontact,companyname,email from student LEFT JOIN billing as billing on billing.id = student.billingid LEFT JOIN company as company on company.id = student.companyid where student.id = \"" .$comp. "\"";
		$query = $this->db->query($sql);
		
	
	foreach($query->result() as $row) {
		$data[] = $row;
	}	
		
	}
	
	
	
	
	$tmpl = array ( 'table_open'  => '<style type="text/css">body{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;}p.liveButton{width:100%;height:100%;line-height:26px;padding:0;margin:0;}.green{background-color:#CFC;}.liveButton{text-align:center;margin:0;padding:0;}#checkIn{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size:12px;background:#fff;width:100%;border-collapse:collapse;text-align:left;}#checkIn th{font-size:14px;font-weight:normal;color:#039;border-bottom:2px solid #6678b1;padding:10px 8px;}#checkIn td{border-left:1px solid #ccc; border-right:1px solid #ccc;border-bottom:1px solid #ccc;color:#669;padding:5px 4px;}#checkIn tbody tr:hover{background-color:#eee;}#checkIn tbody tr:hover td{color:#009;}.signature{width:250px;}.largeCheckBox{width:25px;height:25px;margin:0 auto;}</style><div style="width:100%;height:100%;"><table id="checkIn">', 'table_close' => '</table></div>' );

	$this->table->set_template($tmpl);


	
	$this->table->set_heading('Full Name','Billing Contact','Company Name','Email Address');	

	foreach($data as $row) {
		
	    $fullName = $row->lastname. ', ' .$row->firstname;
	    $this->table->add_row($fullName,$row->billingcontact,$row->companyname,$row->email);
	    
	}
	
	$table = $this->table->generate();
	
	echo json_encode($table);

	}
	}
	
	
}
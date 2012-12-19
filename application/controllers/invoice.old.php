<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoice extends Application {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	
	function __construct()
	{
		parent::__construct();		
		$this->load->helper('html');
		$this->load->library('ag_auth');

	}
	
	public function index()
	{
	if(logged_in())
		{
		
		$this->load->view('header');
   	    $this->load->view('invoice');
		$this->load->view('footer');

		}
		else
		{
			$this->login();
		}		
		//$this->login();
	}
	
	public function batchinvoice() {
		if(logged_in())
		{
		$output['js_files'] = array('//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js');
		$output['css_files'] = array('/assets/jquery-ui-1.9.2.custom.min.css');
		$this->load->view('header',$output);
   	    $this->load->view('batch_invoice');
		$this->load->view('footer');

		}
		else
		{
			$this->login();
		}		
	
	}
	
		
	public function generateBatchInvoice() {
		
		if($_POST['datepickerFrom'] == '') {echo json_encode("<p style=\"font-weight:bold;color:red;\">Choose a From Date</p>");exit;} else {
		$fromDate = $_POST['datepickerFrom'];
		}
		if($_POST['datepickerTo'] != '') {
			$toDate = $_POST['datepickerTo'];
		} else {
			$toDate = '2050-12-31';
		}
		
		$this->load->library('table');
		$this->load->helper('file');
		$this->load->helper('url');
		$this->load->library('Pdf');
		$this->load->database();
		
		$today = date("Y-m-d");

		$sql = "SELECT billingid from enrollment";
		$query = $this->db->query($sql);
		$billingIDs = array();
		foreach ($query->result() as $row) {
			$billingIDs[] = $row->billingid;
		}
		
		$uniqueIDs = array_values(array_unique($billingIDs));
		
		foreach($uniqueIDs as $id) {

			$sql = "SELECT student.firstname,student.lastname,class_titles.classname,class_titles.tuition,class_titles.courseware,class_titles.length,class_schedule.startdate,billing.id as billingid,billing.attentionto,billing.billingcontact,billing.billingaddress,billing.billingaddress2,billing.billingcity,billing.billingstate,billing.billingzip,enrollment.checkedIn,enrollment.noshow FROM enrollment
LEFT JOIN student as student on student.id = enrollment.studentid
LEFT JOIN class_titles as class_titles on class_titles.id = enrollment.classid
LEFT JOIN class_schedule as class_schedule on class_schedule.id = enrollment.datesid
LEFT JOIN billing as billing on billing.id = enrollment.billingid
WHERE startdate >= \"" .$fromDate. "\"
AND enddate <= \"" .$toDate. "\"
AND (checkedIn = 1 OR noshow= 1)
AND enrollment.billingid = \"" .$id. "\"
";

			$enrollData = array();
			$query = $this->db->query($sql);
			
			foreach($query->result() as $row){
				$enrollData[] = $row;
			}
		}
			
			$count = count($uniqueIDs);
			for($i=0;$i<$count;$i++) {
				foreach($enrollData as $row) {
					//var_dump($data);
					//echo '<br>' .$uniqueIDs[$i];
					while($uniqueIDs[$i] == $row->billingid) { 					
				
				
			
			
			
			//var_dump($enrollData);

			
			
			
			$this->table->set_heading('Full Name', 'Class Name', 'Total Cost', 'Start Date',  'Length', 'Attended?', 'No Show?');	
	  				 
	  		if($row->checkedIn == '1') { $checkedIn = 'Yes'; } else { $checkedIn = 'No'; }
	  		if($row->noshow == '1') { $noShow = 'Yes';} else { $noShow = 'No'; }
	      	$fullname = $row->firstname. ' ' .$row->lastname;
	      	$totalCost = $row->tuition + $row->courseware;
	      	$invoiceID = rand(1,99999);
	      			
	      			
	      				$tmpl = array(
		'table_open' => '<html><head>
		<meta charset="utf-8">
		<title>Invoice</title>
		<style type="text/css">
		/* reset */

*
{
	border: 0;
	box-sizing: content-box;
	color: inherit;
	font-family: inherit;
	font-size: inherit;
	font-style: inherit;
	font-weight: inherit;
	line-height: inherit;
	list-style: none;
	margin: 0;
	padding: 0;
	text-decoration: none;
	vertical-align: top;
}

/* heading */

h1 { font: bold 100% sans-serif; letter-spacing: 0.5em; text-align: center; text-transform: uppercase; }

/* table */

table { font-size: 75%; table-layout: fixed; width: 100%; }
table { border-collapse: separate; border-spacing: 2px; }
th, td { border-width: 1px; padding: 0.5em; position: relative; text-align: left; }
th, td { border-radius: 0.25em; border-style: solid; }
th { background: #EEE; border-color: #BBB; }
td { border-color: #DDD; }

/* page */

html { font: 16px/1 \'Open Sans\', sans-serif; overflow: auto; padding: 0.5in; }
html { background: #999; cursor: default; }

body { box-sizing: border-box; height: 11in; margin: 0 auto; overflow: hidden; padding: 0.5in; width: 8.5in; }
body { background: #FFF; border-radius: 1px; box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5); }

/* header */

header { margin: 0 0 3em; }
header:after { clear: both; content: ""; display: table; }

header h1 { background: #000; border-radius: 0.25em; color: #FFF; margin: 0 0 1em; padding: 0.5em 0; }
header address { float: left; font-size: 75%; font-style: normal; line-height: 1.25; margin: 0 1em 1em 0; }
header address p { margin: 0 0 0.25em; }
header span, header img { display: block; float: right; }
header span { margin: 0 0 1em 1em; max-height: 25%; max-width: 60%; position: relative; }
header img { max-height: 100%; max-width: 100%; }
header input { cursor: pointer; -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)"; height: 100%; left: 0; opacity: 0; position: absolute; top: 0; width: 100%; }

/* article */

article, article address, table.meta, table.inventory { margin: 0 0 3em; }
article:after { clear: both; content: ""; display: table; }
article h1 { clip: rect(0 0 0 0); position: absolute; }

article address { float: left; font-size: 125%; font-weight: bold; }

/* table meta & balance */

table.meta, table.balance { float: right; width: 36%; }
table.meta:after, table.balance:after { clear: both; content: ""; display: table; }

/* table meta */

table.meta th { width: 40%; }
table.meta td { width: 60%; }

/* table items */

table.inventory { clear: both; width: 100%; }
table.inventory th { font-weight: bold; text-align: center; }

table.inventory td:nth-child(1) { width: 26%; }
table.inventory td:nth-child(2) { width: 38%; }
table.inventory td:nth-child(3) { text-align: right; width: 12%; }
table.inventory td:nth-child(4) { text-align: right; width: 12%; }
table.inventory td:nth-child(5) { text-align: right; width: 12%; }

/* table balance */

table.balance th, table.balance td { width: 50%; }
table.balance td { text-align: right; }

/* aside */

aside h1 { border: none; border-width: 0 0 1px; margin: 0 0 1em; }
aside h1 { border-color: #999; border-bottom-style: solid; }

@media print {
	* { -webkit-print-color-adjust: exact; }
	html { background: none; padding: 0; }
	body { box-shadow: none; margin: 0; }
	span:empty { display: none; }
	.add, .cut { display: none; }
}

@page { margin: 0; }
		</style>
	</head>
	<body>
		<header>
			<h1>Campus Linc - Invoice</h1>
			<address contenteditable>
				<p>' .$row->attentionto. '<br />' .$row->billingcontact. '</p>
				<p>' .$row->billingaddress. '<br />' .$row->billingaddress2. '<br />' .$row->billingcity. ', ' .$row->billingstate. ' ' .$row->billingzip. '</p>
			</address>
			<span><img alt="" src="' .base_url(). 'images/clLogo.jpg" width="250" height="97"></span>
		</header>
		<article>
			<table class="meta">
				<tr>
					<th><span contenteditable>Invoice #</span></th>
					<td><span contenteditable>' .$invoiceID. '</span></td>
				</tr>
				<tr>
					<th><span contenteditable>Date</span></th>
					<td><span contenteditable>' .date('M d, Y'). '</span></td>
				</tr>
				<tr>
					<th><span contenteditable>Amount Due</span></th>
					<td><span id="prefix" contenteditable>$</span><span>600.00</span></td>
				</tr>
			</table><table class="inventory">','table_close' => '</article>
		<aside>
			<h1><span contenteditable>Additional Notes</span></h1>
			<div contenteditable>
				<p>You can say whatever you want here.</p>
			</div>
		</aside>
	</body>
</html>');
		
		$this->table->set_template($tmpl);
	      			
	      			
	      			$this->table->add_row(array($fullname, $row->classname, '$' .$totalCost, $row->startdate,$row->length,$checkedIn, $noShow));
	
	      			
	   			
	   			
	   			
	   			$table =  $this->table->generate();
	   			$filename = '/tmp/invoice/' .$today. '-' . $invoiceID. '-' .rand(1,100). '.html';
	   			if ( ! write_file('.' .$filename, $table))
				{
     				echo 'Unable to write the file';
				} else {
     				//echo json_encode($table);
     				echo json_encode('<h2 style="color:red;"><a href="' .$filename. '" target="_blank">Click Here to Download CheckIn Sheet</a></h2>');
				}
	   
			
		}
	
	}}
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
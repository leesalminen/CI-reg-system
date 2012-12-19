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
	
	public function viewUnBilledEnrollments() {
		if(logged_in())
		{
		$output['js_files'] = array('//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js');
		$output['css_files'] = array('/assets/jquery-ui-1.9.2.custom.min.css');
		$this->load->view('header',$output);
   	    $this->load->view('unbilled_enrollments');
		$this->load->view('footer');

		}
		else
		{
			$this->login();
		}		
	
	}
	
	public function viewUnBilledInvoices() {
		if(logged_in()){
		
		
		
		
		
		
		
		
		
		} /* Logged In If*/
	}
	
	public function getCompanies() {
		
		$this->load->database();
		$sql = "SELECT companyname,id FROM company ORDER BY companyname";
		$query = $this->db->query($sql);
		$output = '';	
		if ($query->num_rows() > 0)
		{

   			foreach ($query->result() as $row)
  			{
      			if($row->companyname) 
      			{
      				$output .= '<option value="' .$row->id. '">' .$row->companyname. '</option>';
      			}
   			}
   			
   			echo json_encode($output);
   			exit;
   
		} else {
		exit;
		
			//echo json_encode('<option value="null">No Available Companies</option>');
		
		}
	
	
	
	}
	
	
	public function getBillingContacts() {
	$company = $_POST['companyid'];
	
		$this->db->select("*")
				 ->from('billing')
				 ->where('companyid', $company)
				 ->order_by('billingcontact');
		$db = $this->db->get();
		
		$output = '';	
		if ($db->num_rows() > 0)
		{

   			foreach ($db->result() as $row)
  			{
      			if($row->id) 
      			{
      				$output .= '<option value="' .$row->id. '">' .$row->billingcontact. '</option>';
      			}
   			}
   			
   			echo json_encode($output);
   
		} else {
		
		
			echo json_encode('<option value="null">No Billing Contacts Found</option>');
		
		}
	

		exit;     
	
	}
	
	
	public function getUnBilledEnrollments() {
	//$company = $_POST['companyid'];
	$billingcontact = $_POST['billingcontact'];
	$fromDate = $_POST['datepickerFrom'];
	if($_POST['datepickerTo'] != '') {
		$toDate = $_POST['datepickerTo'];
	} else {
		$toDate = '2050-12-31';
	}
	
	$this->load->database();
	$this->load->library('table');

	
	$sql = "SELECT student.firstname,student.lastname,class_titles.classname,class_titles.tuition,class_titles.courseware,class_titles.length,class_schedule.startdate,billing.id as billingid,billing.attentionto,billing.billingcontact,billing.billingaddress,billing.billingaddress2,billing.billingcity,billing.billingstate,billing.billingzip,enrollment.checkedIn,enrollment.noshow,enrollment.id as enrollmentid FROM enrollment
LEFT JOIN student as student on student.id = enrollment.studentid
LEFT JOIN class_titles as class_titles on class_titles.id = enrollment.classid
LEFT JOIN class_schedule as class_schedule on class_schedule.id = enrollment.datesid
LEFT JOIN billing as billing on billing.id = enrollment.billingid
WHERE startdate >= \"" .$fromDate. "\"
AND enddate <= \"" .$toDate. "\"
AND (checkedIn = 1 OR noshow= 1)
AND invoiceStatus != \"Payment Pending\"
AND enrollment.billingid = \"" .$billingcontact. "\"
";

	$query = $this->db->query($sql);
	
	$tmpl = array ( 'table_open'  => '<style type="text/css">body{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;}p.liveButton{width:100%;height:100%;line-height:26px;padding:0;margin:0;}.green{background-color:#CFC;}.liveButton{text-align:center;margin:0;padding:0;}#checkIn{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size:12px;background:#fff;width:100%;border-collapse:collapse;text-align:left;}#checkIn th{font-size:14px;font-weight:normal;color:#039;border-bottom:2px solid #6678b1;padding:10px 8px;}#checkIn td{border-left:1px solid #ccc; border-right:1px solid #ccc;border-bottom:1px solid #ccc;color:#669;padding:5px 4px;}#checkIn tbody tr:hover{background-color:#eee;}#checkIn tbody tr:hover td{color:#009;}.signature{width:250px;}.largeCheckBox{width:25px;height:25px;margin:0 auto;}</style><div style="width:100%;height:100%;"><table id="checkIn">', 'table_close' => '</table></div>' );

	$this->table->set_template($tmpl);


	
	$this->table->set_heading('Select','Full Name', 'Class Name', 'Total Cost', 'Start Date',  'Length', 'Attended?', 'No Show?');	

	$array = array();
		foreach($query->result() as $row){
			$array[] = $row;	
		
		}	
	foreach($array as $row) {
		
		if($row->checkedIn == '1') { $checkedIn = 'Yes'; } else { $checkedIn = 'No'; }
	  	if($row->noshow == '1') { $noShow = 'Yes';} else { $noShow = 'No'; }
	    $fullname = $row->firstname. ' ' .$row->lastname;
	    $totalCost = $row->tuition + $row->courseware;
	    
	    $this->table->add_row('<input type="checkbox" id="checkbox' .$row->enrollmentid. '" value="' .$row->enrollmentid. '" name="checkbox' .$row->enrollmentid. '" class="checkbox" />',$fullname, $row->classname, $totalCost, $row->startdate, $row->length, $checkedIn, $noShow);
	    
	}
	
	$table = $this->table->generate();
	
	echo json_encode($table);

	}
	
	
	public function createInvoice() {
		$billingID = $this->uri->segment(3);
	
		$this->load->database();
		
		$values = array();
		foreach($_POST as $k=>$v) {
			$values[] = $v;
		
			$sql = "UPDATE enrollment SET invoiceStatus = \"Payment Pending\" WHERE id = \"" .$v. "\"";
			$this->db->query($sql);

		}
		
		$csv = implode(',', $values);
		
		$sql2 = "INSERT into invoices (enrollmentIDs,billingid) VALUES(\"" .$csv. "\",\"" .$billingID. "\")";
			
		$query = $this->db->query($sql2);
		
		if($query) {
		
			echo json_encode('<h4 style="color:red;">Invoice Created Successfully!</h4><p><a href="/invoice/viewGeneratedInvoices">Click Here</a> to view invoice.</p>');
		
		}
	}
		
		
	public function viewGeneratedInvoices() {
		if(logged_in())
		{
		
		
		$this->load->database();
		$this->load->library('table');

	
	$sql = "SELECT invoices.id as invoiceid, company.companyname, billing.billingcontact,invoices.status FROM invoices LEFT JOIN billing as billing on billing.id = invoices.billingID LEFT JOIN company as company on company.id = billing.companyid";
	
		$query = $this->db->query($sql);
		
		$tmpl = array ( 'table_open'  => '<style type="text/css">body{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;}p.liveButton{width:100%;height:100%;line-height:26px;padding:0;margin:0;}.green{background-color:#CFC;}.liveButton{text-align:center;margin:0;padding:0;}#checkIn{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size:12px;background:#fff;width:100%;border-collapse:collapse;text-align:left;}#checkIn th{font-size:14px;font-weight:normal;color:#039;border-bottom:2px solid #6678b1;padding:10px 8px;}#checkIn td{border-left:1px solid #ccc; border-right:1px solid #ccc;border-bottom:1px solid #ccc;color:#669;padding:5px 4px;}#checkIn tbody tr:hover{background-color:#eee;}#checkIn tbody tr:hover td{color:#009;}.signature{width:250px;}.largeCheckBox{width:25px;height:25px;margin:0 auto;}</style><div style="width:100%;height:100%;"><table id="checkIn">', 'table_close' => '</table></div>' );
	
		$this->table->set_template($tmpl);
	
	
		
		$this->table->set_heading('Invoice ID','Company Name','Billing Contact','Status','Send via Email','View/Print','Delete');	
	
		$array = array();
			foreach($query->result() as $row){
				$array[] = $row;	
			
			}	
		foreach($array as $row) {
					    
		    $this->table->add_row($row->invoiceid,$row->companyname, $row->billingcontact, $row->status,'<p style="text-align:center;margin:0;padding:0;"><a href="/invoice/emailInvoice/' .$row->invoiceid. '">Email Invoice</a></p>','<p style="text-align:center;margin:0;padding:0;"><a href="/invoice/printInvoice/' .$row->invoiceid. '">View/Print Invoice</a></p>','<p style="text-align:center;margin:0;padding:0;"><a href="/invoice/deleteInvoice/' .$row->invoiceid. '">Delete Invoice</a></p>');
		    
		}
		
		$table = $this->table->generate();
		
		
		$output['js_files'] = array('//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js');
		$output['css_files'] = array('/assets/jquery-ui-1.9.2.custom.min.css');
		$output['output'] = $table;
		$this->load->view('header',$output);
   	    $this->load->view('view_generated_invoices',$output);
		$this->load->view('footer');

		}
		else
		{
			$this->login();
		}		
	
	}
	
	
	public function printInvoice() {
		$invoiceID = $this->uri->segment(3);
		
		$this->load->library('table');
		$this->load->helper('file');
		$this->load->helper('url');
		$this->load->library('Pdf');
		$this->load->database();
		
		$sql = "SELECT enrollmentIDs FROM invoices WHERE id = \"" .$invoiceID. "\" LIMIT 1";
		$query = $this->db->query($sql);
		
		$row = $query->row();
		
		$enrollmentIDs = explode(',',$row->enrollmentIDs);
		
		$array = array();
		foreach($enrollmentIDs as $enrollmentID) {
		
			$sql = "SELECT student.firstname,student.lastname,class_titles.classname,class_titles.tuition,class_titles.courseware,class_titles.length,class_schedule.startdate,billing.id as billingid,billing.attentionto,billing.billingcontact,billing.billingaddress,billing.billingaddress2,billing.billingcity,billing.billingstate,billing.billingzip,enrollment.checkedIn,enrollment.noshow FROM enrollment
	LEFT JOIN student as student on student.id = enrollment.studentid
	LEFT JOIN class_titles as class_titles on class_titles.id = enrollment.classid
	LEFT JOIN class_schedule as class_schedule on class_schedule.id = enrollment.datesid
	LEFT JOIN billing as billing on billing.id = enrollment.billingid
	WHERE enrollment.id = \"" .$enrollmentID. "\"
	";
	
		$query = $this->db->query($sql);
		
		$row = $query->row();
		
		$array[] = $row;
		
	}
	
	if($row->billingaddress2 != '') {
	
		$address = $row->billingaddress. '<br />' .$row->billingaddress2;
	
	
	} else {
	
		$address = $row->billingaddress;
	
	}
	
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
			<address>
				<p><strong>Attention To: ' .$row->attentionto. '</strong><br />' .$row->billingcontact. '<br />
				' .$address. '<br />' .$row->billingcity. ', ' .$row->billingstate. ' ' .$row->billingzip. '</p>
			</address>
		</header>
		<article>
			<table class="meta">
				<tr>
					<th><span >Invoice #</span></th>
					<td><span >' .$invoiceID. '</span></td>
				</tr>
				<tr>
					<th><span >Date</span></th>
					<td><span >' .date('M d, Y'). '</span></td>
				</tr>
				<tr>
					<th><span >Amount Due</span></th>
					<td><span id="prefix" >$</span><span>600.00</span></td>
				</tr>
			</table><table class="inventory">','table_close' => '</article>
		<aside>
		<h1>&nbsp;<br /></h1>
			<h1><span >Additional Notes</span></h1>
			<div >
				<p>You can say whatever you want here.</p>
			</div>
		</aside>
	</body>
</html>');
		
		$this->table->set_template($tmpl);
	
		$this->table->set_heading('Full Name', 'Class Name', 'Total Cost', 'Start Date',  'Length', 'Attended?', 'No Show?');	
	  	
	  	foreach($array as $arr) {
	  		if($row->checkedIn == '1') { $checkedIn = 'Yes'; } else { $checkedIn = 'No'; }
	  		if($row->noshow == '1') { $noShow = 'Yes';} else { $noShow = 'No'; }
	      	$fullname = $row->firstname. ' ' .$row->lastname;
	      	$totalCost = $row->tuition + $row->courseware;	      			
	      			
	      	$this->table->add_row(array($fullname, $row->classname, '$' .$totalCost, $row->startdate,$row->length,$checkedIn, $noShow));
	
	    }
	   			
	   			
	   			
	   			$table =  $this->table->generate();
	  			
				// create new PDF document
$pdf = new TCPDF('landscape', PDF_UNIT, 'letter', true, 'UTF-8', false);

// set document information
$pdf->SetAuthor('Campus Linc');
$pdf->SetTitle('Invoice # ' .$invoiceID);

// set default header data
$pdf->SetHeaderData('clLogo.jpg',17, 'Campus Linc - Invoice','25 John Glenn Drive, Suite 102, Amherst NY 14228');

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);


// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 10);

// add a page
$pdf->AddPage();
$pdf->writeHTML($table, true, false, true, false, '');
$pdf->Output('../tmp/invoice/' .$invoiceID. '-' .rand(1,1000). '.pdf', 'I');





			
			

	
}
	
	
	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
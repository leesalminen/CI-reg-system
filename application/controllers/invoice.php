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
		$output['js_files'] = array('//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js','/css/jquery.pnotify.min.js');
		$output['css_files'] = array('http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css','/css/jquery.pnotify.default.css','/css/jquery.pnotify.default.icons.css');

		$this->load->view('header',$output);
   	    $this->load->view('unbilled_enrollments');
		$this->load->view('footer');

		}
		else
		{
			$this->login();
		}		
	
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

	
	$sql = "SELECT invoices.id as invoiceid, company.companyname, billing.billingcontact,invoices.status FROM invoices LEFT JOIN billing as billing on billing.id = invoices.billingID LEFT JOIN company as company on company.id = billing.companyid WHERE status != \"Paid\"";
	
		$query = $this->db->query($sql);
		
		$tmpl = array ( 'table_open'  => '<style type="text/css">body{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;}p.liveButton{width:100%;height:100%;line-height:26px;padding:0;margin:0;}.green{background-color:#CFC;}.liveButton{text-align:center;margin:0;padding:0;}#checkIn{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size:12px;background:#fff;width:100%;border-collapse:collapse;text-align:left;}#checkIn th{font-size:14px;font-weight:normal;color:#039;border-bottom:2px solid #6678b1;padding:10px 8px;}#checkIn td{border-left:1px solid #ccc; border-right:1px solid #ccc;border-bottom:1px solid #ccc;color:#669;padding:5px 4px;}#checkIn tbody tr:hover{background-color:#eee;}#checkIn tbody tr:hover td{color:#009;}.signature{width:250px;}.largeCheckBox{width:25px;height:25px;margin:0 auto;}</style><div style="width:100%;height:100%;"><table id="checkIn">', 'table_close' => '</table></div>' );
	
		$this->table->set_template($tmpl);
	
	
		
		$this->table->set_heading('Invoice ID','Company Name','Billing Contact','Status','Send via Email','View/Print','Delete');	
	
		$array = array();
			foreach($query->result() as $row){
				$array[] = $row;	
			
			}	
		foreach($array as $row) {
					    
		    $this->table->add_row($row->invoiceid,$row->companyname, $row->billingcontact, $row->status,'<p style="text-align:center;margin:0;padding:0;"><a href="#" onclick="emailInvoice(' .$row->invoiceid. ')">Email Invoice</a></p>','<p style="text-align:center;margin:0;padding:0;"><a href="/invoice/printInvoice/' .$row->invoiceid. '">View/Print Invoice</a></p>','<p style="text-align:center;margin:0;padding:0;"><a href="#" onclick="deleteInvoice(' .$row->invoiceid. ');">Delete Invoice</a></p>');
		    
		}
		
		$table = $this->table->generate();
		
		
		$output['js_files'] = array('//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js','/css/jquery.pnotify.min.js');
		$output['css_files'] = array('http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css','/css/jquery.pnotify.default.css','/css/jquery.pnotify.default.icons.css');

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
	if(logged_in()) {
		$invoiceID = $this->uri->segment(3);
		
		$this->load->library('table');
		$this->load->helper('file');
		$this->load->helper('url');
		$this->load->library('Pdf');
		$this->load->database();
		
		$sql = "SELECT enrollmentIDs,createdAt FROM invoices WHERE id = \"" .$invoiceID. "\" LIMIT 1";
		$query = $this->db->query($sql);
		
		$row = $query->row();
		$createdAt2 = explode('-',$row->createdAt);
		$createdAt3 = explode(' ',$createdAt2[2]);
		$createdAt = $createdAt2[1]. '-' .$createdAt3[0]. '-' .$createdAt2[0];
		
		
		$enrollmentIDs = explode(',',$row->enrollmentIDs);
		
		$array = array();
		$costArray = array();
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
		
		$totalCost = $row->tuition + $row->courseware;
		$costArray[] = $totalCost;
		
	}
	
	if($row->billingaddress2 != '') {
	
		$address = $row->billingaddress. '<br />' .$row->billingaddress2;
	
	
	} else {
	
		$address = $row->billingaddress;
	
	}
	setlocale(LC_MONETARY, 'en_US');
	$grossCost = array_sum($costArray);
		$grossCost = money_format('%(#2n', $grossCost);

	
	if($row->attentionto != '' ) {
	
		$attentionTo = '<br />Attention To: ' .$row->attentionto;
	} else {
		$attentionTo = '';
	
	}
			
	$table = '<h1 align="right">INVOICE</h1><table><tr><td><p><strong>Campus Linc</strong><br />25 John Glenn Drive<br />Suite 102<br />Amherst, NY 14228<br />716.688.8688<br /></p><p><strong>Bill To:</strong>' .$attentionTo. '<br />' .$array[0]->billingcontact. '<br />' .$address. '<br />' .$array[0]->billingcity. ', ' .$array[0]->billingstate. ' ' .$array[0]->billingzip. '</p></td><td align="right"><p>Invoice #: ' .$invoiceID. '<br />Date Created On: ' .$createdAt. '</p></td></tr><tr height="20"><td>&nbsp;</td></tr></table><table><thead><tr><th style="font-size:22px;font-weight:normal;color:#039;border-bottom:2px solid #6678b1;padding:10px 8px;">Full Name</th><th style="font-size:22px;font-weight:normal;color:#039;border-bottom:2px solid #6678b1;padding:10px 8px;" width="225">Class Name</th><th style="font-size:22px;font-weight:normal;color:#039;border-bottom:2px solid #6678b1;padding:10px 8px;">Total Cost</th><th style="font-size:22px;font-weight:normal;color:#039;border-bottom:2px solid #6678b1;padding:10px 8px;">Start Date</th><th style="font-size:22px;font-weight:normal;color:#039;border-bottom:2px solid #6678b1;padding:10px 8px;">Length</th><th style="font-size:22px;font-weight:normal;color:#039;border-bottom:2px solid #6678b1;padding:10px 8px;" width="50">Attended?</th><th style="font-size:22px;font-weight:normal;color:#039;border-bottom:2px solid #6678b1;padding:10px 8px;font-size:22px;" width="40">No Show?</th></tr></thead><tbody><tr height="2"><td>&nbsp;</td></tr>';
	
	    $count = count($array);
	   
	    for($i=0;$i<$count;$i++) {
	    
	    	if($array[$i]->checkedIn == '1') { $checkedIn = 'Yes'; } else { $checkedIn = 'No'; }
	  		if($array[$i]->noshow == '1') { $noShow = 'Yes';} else { $noShow = 'No'; }
	      	$fullname = $array[$i]->firstname. ' ' .$array[$i]->lastname;
	      	$totalCost = $array[$i]->tuition + $array[$i]->courseware;	
			
			$table .='<tr style="margin-bottom:5px;border-bottom:2px solid #CCCCCC;"><td>' .$fullname. '</td><td width="225">' .$array[$i]->classname. '</td><td>$' .$totalCost. '</td><td>' .$array[$i]->startdate. '</td><td>' .$array[$i]->length. '</td><td width="50">' .$checkedIn. '</td><td width="40">' .$noShow. '</td></tr>';  
	    
	    
	    
	    }
	    	
	   			$table .="<tr colspan=\"6\" height=\"5\"><td><br /></td></tr><tr><td colspan=\"7\" align=\"right\"><h4>Total Amount Due: " .$grossCost. "</h4><br /><br /></td></tr><tr><td colspan=\"6\" align=\"center\"><p>Please make all checks payable to Campus Linc. Payments are due within 30 days of issuance.</p><h2>Thank you for your business!</h2></td></tr></tbody></table></div>";
	   			
	  			
				// create new PDF document
$pdf = new TCPDF('landscape', PDF_UNIT, 'letter', true, 'UTF-8', false);

// set document information
$pdf->SetAuthor('Campus Linc');
$pdf->SetTitle('Invoice # ' .$invoiceID);

// set default header data
$pdf->SetHeaderData('clLogo.jpg',17, 'Campus Linc - Invoice','25 John Glenn Drive, Suite 102, Amherst NY 14228 -- 716.688.8688');

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
$pdf->Output('/home/campus/public_html/tmp/invoice/invoice' .$invoiceID. '.pdf', 'FD');


} /*Logged In*/
	
} /*printInvoice()*/


	function deleteInvoice() {
	
		$invoiceID = $this->uri->segment(3);
		$this->load->database();

		$sql = "SELECT enrollmentIDs FROM invoices WHERE id = \"" .$invoiceID. "\" LIMIT 1";
		$query = $this->db->query($sql);
		
		$row = $query->row();
		
		$enrollmentIDs = explode(',',$row->enrollmentIDs);
		
		foreach($enrollmentIDs as $enrollmentID) {
			
			$sql = "UPDATE enrollment SET invoiceStatus = \"Uninvoiced\" WHERE id = \"" .$enrollmentID. "\"";
			
			$this->db->query($sql);	
				
		}
		
		$delsql = 'DELETE FROM invoices WHERE id="' .$invoiceID. '"';
		
		$this->db->query($delsql);
		
	}
	
	
	function sendInvoice() {
	
		
	if(logged_in()) {
		$invoiceID = $this->uri->segment(3);
		
		$this->load->library('table');
		$this->load->helper('file');
		$this->load->helper('url');
		$this->load->library('Pdf');
		$this->load->database();
		
		$sql = "SELECT enrollmentIDs,createdAt FROM invoices WHERE id = \"" .$invoiceID. "\" LIMIT 1";
		$query = $this->db->query($sql);
		
		$row = $query->row();
		$createdAt2 = explode('-',$row->createdAt);
		$createdAt3 = explode(' ',$createdAt2[2]);
		$createdAt = $createdAt2[1]. '-' .$createdAt3[0]. '-' .$createdAt2[0];
		$enrollmentIDs = explode(',',$row->enrollmentIDs);
		
		$array = array();
		$costArray = array();
		foreach($enrollmentIDs as $enrollmentID) {
		
			$sql = "SELECT student.firstname,student.lastname,class_titles.classname,class_titles.tuition,class_titles.courseware,class_titles.length,class_schedule.startdate,billing.id as billingid,billing.attentionto,billing.billingcontact,billing.billingaddress,billing.billingaddress2,billing.billingcity,billing.billingstate,billing.billingzip,enrollment.checkedIn,enrollment.noshow,billing.billingemail,enrollment.id as enrollmentid FROM enrollment
	LEFT JOIN student as student on student.id = enrollment.studentid
	LEFT JOIN class_titles as class_titles on class_titles.id = enrollment.classid
	LEFT JOIN class_schedule as class_schedule on class_schedule.id = enrollment.datesid
	LEFT JOIN billing as billing on billing.id = enrollment.billingid
	WHERE enrollment.id = \"" .$enrollmentID. "\"
	";
	
		$query = $this->db->query($sql);
		
		$row = $query->row();
		
		$array[] = $row;
		
		$totalCost = $row->tuition + $row->courseware;
		$costArray[] = $totalCost;
		
	}
	
	if($row->billingaddress2 != '') {
	
		$address = $row->billingaddress. '<br />' .$row->billingaddress2;
	
	
	} else {
	
		$address = $row->billingaddress;
	
	}
	setlocale(LC_MONETARY, 'en_US');
	$grossCost = array_sum($costArray);
		$grossCost = money_format('%(#2n', $grossCost);

	
	if($row->attentionto != '' ) {
	
		$attentionTo = '<br />Attention To: ' .$row->attentionto;
	} else {
		$attentionTo = '';
	
	}
			
	$table = '<h1 align="right">INVOICE</h1><table><tr><td><p><strong>Campus Linc</strong><br />25 John Glenn Drive<br />Suite 102<br />Amherst, NY 14228<br />716.688.8688<br /></p><p><strong>Bill To:</strong>' .$attentionTo. '<br />' .$array[0]->billingcontact. '<br />' .$address. '<br />' .$array[0]->billingcity. ', ' .$array[0]->billingstate. ' ' .$array[0]->billingzip. '</p></td><td align="right"><p>Invoice #: ' .$invoiceID. '<br />Date Created On: ' .$createdAt. '</p></td></tr><tr height="20"><td>&nbsp;</td></tr></table><table><thead><tr><th style="font-size:22px;font-weight:normal;color:#039;border-bottom:2px solid #6678b1;padding:10px 8px;">Full Name</th><th style="font-size:22px;font-weight:normal;color:#039;border-bottom:2px solid #6678b1;padding:10px 8px;" width="225">Class Name</th><th style="font-size:22px;font-weight:normal;color:#039;border-bottom:2px solid #6678b1;padding:10px 8px;">Total Cost</th><th style="font-size:22px;font-weight:normal;color:#039;border-bottom:2px solid #6678b1;padding:10px 8px;">Start Date</th><th style="font-size:22px;font-weight:normal;color:#039;border-bottom:2px solid #6678b1;padding:10px 8px;">Length</th><th style="font-size:22px;font-weight:normal;color:#039;border-bottom:2px solid #6678b1;padding:10px 8px;" width="50">Attended?</th><th style="font-size:22px;font-weight:normal;color:#039;border-bottom:2px solid #6678b1;padding:10px 8px;font-size:22px;" width="40">No Show?</th></tr></thead><tbody><tr height="2"><td>&nbsp;</td></tr>';
	
	    $count = count($array);
	   
	    for($i=0;$i<$count;$i++) {
	    
	    	if($array[$i]->checkedIn == '1') { $checkedIn = 'Yes'; } else { $checkedIn = 'No'; }
	  		if($array[$i]->noshow == '1') { $noShow = 'Yes';} else { $noShow = 'No'; }
	      	$fullname = $array[$i]->firstname. ' ' .$array[$i]->lastname;
	      	$totalCost = $array[$i]->tuition + $array[$i]->courseware;	
			
			$table .='<tr style="margin-bottom:5px;border-bottom:2px solid #CCCCCC;"><td>' .$fullname. '</td><td width="225">' .$array[$i]->classname. '</td><td>$' .$totalCost. '</td><td>' .$array[$i]->startdate. '</td><td>' .$array[$i]->length. '</td><td width="50">' .$checkedIn. '</td><td width="40">' .$noShow. '</td></tr>';  
	    
	    
	    
	    }
	    	
	   			$table .="<tr colspan=\"6\" height=\"5\"><td><br /></td></tr><tr><td colspan=\"7\" align=\"right\"><h4>Total Amount Due: " .$grossCost. "</h4><br /><br /></td></tr><tr><td colspan=\"6\" align=\"center\"><p>Please make all checks payable to Campus Linc. Payments are due within 30 days of issuance.</p><h2>Thank you for your business!</h2></td></tr></tbody></table></div>";
	   			
	  			
// create new PDF document
$pdf = new TCPDF('landscape', PDF_UNIT, 'letter', true, 'UTF-8', false);

// set document information
$pdf->SetAuthor('Campus Linc');
$pdf->SetTitle('Invoice # ' .$invoiceID);

// set default header data
$pdf->SetHeaderData('clLogo.jpg',17, 'Campus Linc - Invoice','25 John Glenn Drive, Suite 102, Amherst NY 14228 -- 716.688.8688');

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
$fileName = '/home/campus/public_html/tmp/invoice/invoice' .$invoiceID. '-email.pdf';
$pdf->Output($fileName, 'F');

$this->load->library('email');

$this->email->from('invoices@campuslinc.com', 'Campus Linc');
$this->email->to($array[0]->billingemail); 
$this->email->cc('me@leesalminen.com');
$this->email->bcc('shaune@campuslinc.com'); 
$this->email->subject('A new invoice has been issued from Campus Linc.');
$this->email->message("Dear " .$array[0]->billingcontact. ",\nAttached you will find an itemized invoice for Campus Linc. If you have any questions, please feel free to contact us at 716-688-8688.");	
$this->email->attach($fileName);

if($this->email->send()) {
	$timestamp = date('m-d-Y H:i:s');
	$sql = "UPDATE invoices SET status = \"Sent\", invoiceSentAt = \"" .$timestamp. "\" WHERE id = \"" .$invoiceID. "\"";
	
	if($this->db->query($sql)) {
	
		for($i=0;$i<$count;$i++) {
    
    	if($array[$i]->checkedIn == '1') { $checkedIn = 'Yes'; } else { $checkedIn = 'No'; }
  		if($array[$i]->noshow == '1') { $noShow = 'Yes';} else { $noShow = 'No'; }
      	$fullname = $array[$i]->firstname. ' ' .$array[$i]->lastname;
      	$totalCost = $array[$i]->tuition + $array[$i]->courseware;	
      	
      	$sql2 = "UPDATE enrollment SET invoiceStatus = \"Payment Pending\" WHERE id = \"" .$array[$i]->enrollmentid. "\"";
      	
      	$this->db->query($sql2);
    
	    
	    }

	
	
	}
	
	echo json_encode('Email Sent to ' .$row->billingemail. '!');
	
	
	
}





} /*Logged In*/

	
	
	
	
	}
	
	
	public function viewUnPaidInvoices() {
		if(logged_in()) {
				
		$output['js_files'] = array('//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js','/css/jquery.pnotify.min.js');
		$output['css_files'] = array('http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css','/css/jquery.pnotify.default.css','/css/jquery.pnotify.default.icons.css');

		$this->load->view('header',$output);
   	    $this->load->view('unpaid_invoices');
		$this->load->view('footer');

		}
		else
		{
			$this->login();
		}		
	
	
	}
	
	public function reconcileInvoices() {
		if(logged_in()) {
				
		$output['js_files'] = array('//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js','/css/jquery.pnotify.min.js');
		$output['css_files'] = array('http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css','/css/jquery.pnotify.default.css','/css/jquery.pnotify.default.icons.css');

		$this->load->view('header',$output);
   	    $this->load->view('reconcile_invoices');
		$this->load->view('footer');

		}
		else
		{
			$this->login();
		}		
	
	
	}

	
	public function getUnPaidInvoices() {
	
		$filter = $_POST['reconcile'];
		if($filter == '30') {   
			$filter = strtotime ( '-30 days' , strtotime ( date('Y-m-d H:i:s') ) );
			$filter = date('m-d-Y',$filter);
		} else if ($filter == '60') {
			$filter = strtotime ( '-60 days' , strtotime ( date('Y-m-d H:i:s') ) );
			$filter = date('m-d-Y',$filter);
		} else if ($filter == '90') {
			$filter = strtotime ( '-90 days' , strtotime ( date('Y-m-d H:i:s') ) );
			$filter = date('m-d-Y',$filter);
		} else {
			echo json_encode('Error, ask Lee');
			die;
		}
		$this->load->database();
		$this->load->library('table');

	
	$sql = "SELECT invoices.id as invoiceid, company.companyname, billing.billingcontact,invoices.status FROM invoices LEFT JOIN billing as billing on billing.id = invoices.billingID LEFT JOIN company as company on company.id = billing.companyid WHERE status != \"Paid\"
AND createdAt <= \"" .$filter. "\"	
";

	
		$query = $this->db->query($sql);
		
		$tmpl = array ( 'table_open'  => '<style type="text/css">body{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;}p.liveButton{width:100%;height:100%;line-height:26px;padding:0;margin:0;}.green{background-color:#CFC;}.liveButton{text-align:center;margin:0;padding:0;}#checkIn{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size:12px;background:#fff;width:100%;border-collapse:collapse;text-align:left;}#checkIn th{font-size:14px;font-weight:normal;color:#039;border-bottom:2px solid #6678b1;padding:10px 8px;}#checkIn td{border-left:1px solid #ccc; border-right:1px solid #ccc;border-bottom:1px solid #ccc;color:#669;padding:5px 4px;}#checkIn tbody tr:hover{background-color:#eee;}#checkIn tbody tr:hover td{color:#009;}.signature{width:250px;}.largeCheckBox{width:25px;height:25px;margin:0 auto;}</style><div style="width:100%;height:100%;"><table id="checkIn">', 'table_close' => '</table></div>' );
	
		$this->table->set_template($tmpl);
	
	
		
		$this->table->set_heading('Invoice ID','Company Name','Billing Contact','Status','Send via Email','View/Print','Delete');	
	
		$array = array();
			foreach($query->result() as $row){
				$array[] = $row;	
			
			}	
		foreach($array as $row) {
					    
		    $this->table->add_row($row->invoiceid,$row->companyname, $row->billingcontact, $row->status,'<p style="text-align:center;margin:0;padding:0;"><a href="#" onclick="emailInvoice(' .$row->invoiceid. ')">Email Invoice</a></p>','<p style="text-align:center;margin:0;padding:0;"><a href="/invoice/printInvoice/' .$row->invoiceid. '">View/Print Invoice</a></p>','<p style="text-align:center;margin:0;padding:0;"><a href="#" onclick="deleteInvoice(' .$row->invoiceid. ');">Delete Invoice</a></p>');
		    
		}
		
		$table = $this->table->generate();
		
		echo json_encode($table);
	
	
	
	
	}
	
	public function doReconcileInvoice() {
		$invoiceID = $_POST['invoiceID'];
		$timestamp = date('m-d-Y H:i:s');
	$sql = "UPDATE invoices SET status = \"Sent\", invoiceSentAt = \"" .$timestamp. "\" WHERE id = \"" .$invoiceID. "\"";
	
	if($this->db->query($sql)) {
	
		for($i=0;$i<$count;$i++) {
    
    	if($array[$i]->checkedIn == '1') { $checkedIn = 'Yes'; } else { $checkedIn = 'No'; }
  		if($array[$i]->noshow == '1') { $noShow = 'Yes';} else { $noShow = 'No'; }
      	$fullname = $array[$i]->firstname. ' ' .$array[$i]->lastname;
      	$totalCost = $array[$i]->tuition + $array[$i]->courseware;	
      	
      	$sql2 = "UPDATE enrollment SET invoiceStatus = \"Payment Pending\" WHERE id = \"" .$array[$i]->enrollmentid. "\"";
      	
      	$query2 = $this->db->query($sql2);
      	
      	if($query2){ echo json_encode('OK'); }
    
	    
	    }

	}
	
	
	
	}
	
	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
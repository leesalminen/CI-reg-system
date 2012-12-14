<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="<?=base_url()?>css/main.css" type="text/css" />
 <script src="http://campus.zoodleweb.com/assets/grocery_crud/js/jquery-1.8.1.min.js"></script>

<?php 
if(isset($css_files)) { foreach($css_files as $file): ?>
    <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
 
<?php endforeach; } ?>
<?php if(isset($js_files)) { foreach($js_files as $file): ?>
 
    <script src="<?php echo $file; ?>"></script>
<?php endforeach; } ?>
 
<style type='text/css'>
body
{
    font-family: Arial;
    font-size: 14px;
}
a {
    color: blue;
    text-decoration: none;
    font-size: 14px;
}
a:hover
{
    text-decoration: underline;
}
#addNewBillingID {
	display:inline;
	margin-left:10px;
}
#addNewInstructor {
	display:inline;
	margin-left:10px;
}

#addNewClassTitle {
	display:inline;
	margin-left:10px;
}

#addNewStudent {
	display:inline;
	margin-left:10px;
}
</style>
<script type="text/javascript">
 $(document).ready(function() {

	$("#billingid_input_box").append('<div id="addNewBillingID"><a href="#" rel="#" onclick="addStudentPopup(\'<?php echo base_url(); ?>billing/index/add?popup=1\')">New Billing Contact</a></div>'); 

	$("#classtitleid_input_box").append('<div id="addNewClassTitle"><a href="#" rel="#" onclick="addStudentPopup(\'<?php echo base_url(); ?>classtitles/index/add?popup=1\')">New Class Title</a></div>'); 

$("#studentid_input_box").append('<div id="addNewStudent"><a href="#" rel="#" onclick="addStudentPopup(\'<?php echo base_url(); ?>student/index/add?popup=1\')">New Student</a></div>'); 

$("#instructor_input_box").append('<div id="addNewInstructor"><a href="#" rel="#" onclick="addStudentPopup(\'<?php echo base_url(); ?>instructors/index/add?popup=1\')">New Instructor</a></div>'); 





 });

function addStudentPopup(url) {
	window.open(url, "Add Student", "status = 1, height=600, width=800, resizable=0");
}


</script>
</head>
<body>

<!-- Beginning header -->

<div id="header">
	
	<div id="title">
		<h1>Campus Linc WebApp</h1>
	</div>
	
	
    <div id="nav">
    
    	<div class="secondary-nav">
		
			<ul class="secondary-nav">
		
				<li><a href="http://campus.zoodleweb.com/reports"><span class="icon"><img src="<?=base_url()?>images/reports.png" alt="Reports" /></span>Reports</a></li>
				<li><a href="http://campus.zoodleweb.com/invoice"><span class="icon"><img src="<?=base_url()?>images/invoicing.png" alt="Invoicing" /></span>Invoicing</a></li>
				<li><a href="http://campus.zoodleweb.com/admin/users/manage"><span class="icon"><img src="<?=base_url()?>images/dashboard.png" alt="Dashboard" /></span>Dashboard</a></li>
			
			</ul>
		
		</div><!-- /secondary-nav -->
    	
    	<div class="separator"></div>
    	
    	<div class="main-nav">   		
    		
    		<ul class="main-nav">
    	
    			<li><a href="http://campus.zoodleweb.com/checkin"><span class="icon"><img src="<?=base_url()?>images/check-in.png" alt="Check In" /></span>Check-In</a></li>
    			<li><a href="http://campus.zoodleweb.com/enrollment"><span class="icon"><img src="<?=base_url()?>images/register.png" alt="Register" /></span>Register</a></li>
    			<li><a href="http://campus.zoodleweb.com/student/"><span class="icon"><img src="<?=base_url()?>images/students.png" alt="Students" /></span>Students</a></li>
    			<li><a href="http://campus.zoodleweb.com/company/"><span class="icon"><img src="<?=base_url()?>images/companies.png" alt="Companies" /></span>Companies</a></li>
				<li><a href="http://campus.zoodleweb.com/classschedule"><span class="icon"><img src="<?=base_url()?>images/courses.png" alt="Courses" /></span>Courses</a></li>
			
			</ul>
		
		</div><!-- /main-nav -->
		
		
		<!--<ul>
		
			<li><a href="http://campus.zoodleweb.com/classtitles/index">Course Titles</a></li>
			<li><a href="http://campus.zoodleweb.com/salesrep/">Sales Reps</a></li>
			<li><a href="http://campus.zoodleweb.com/billing">Billing contact</a></li>
			
		</ul>-->
 
    </div>

</div>

<!-- End of header-->
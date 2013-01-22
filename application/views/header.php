<?php /*IMPORTANT, LEAVE THIS HERE*/ $this->load->helper('ag_auth'); $username = username(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Campus Linc Registration</title>
    <link rel="stylesheet" href="<?=base_url()?>css/main.css" type="text/css" />
    
    <!-- new bootstrap code-->
 
    <!--bootstrap-->
    <link href="<?=base_url()?>assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    

    <!-- End new bootstrap code-->
    
<script src="<?=base_url()?>assets/grocery_crud/js/jquery-1.8.2.min.js"></script>
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
.icon-white, .nav > .active > a > [class^="icon-"], .nav > .active > a > [class*=" icon-"], .dropdown-menu > li > a:hover > [class^="icon-"], .dropdown-menu > li > a:hover > [class*=" icon-"], .dropdown-menu > .active > a > [class^="icon-"], .dropdown-menu > .active > a > [class*=" icon-"] {background-image: url("<?=base_url()?>img/glyphicons-halflings-white.png") !important;}
</style>
<script>
 $(document).ready(function() {
 
 	window.setInterval(function(){checkLoginStatus()}, 60000);
	 
	 	$("#billingid_input_box").append('<div id="addNewBillingID"><a href="#" rel="#" onclick="addStudentPopup(\'<?php echo base_url(); ?>billing/index/add?popup=1\')">New Billing Contact</a></div>'); 

//	$("#classtitleid_input_box").append('<div id="addNewClassTitle"><a href="#" rel="#" onclick="addStudentPopup(\'<?php echo base_url(); ?>classtitles/index/add?popup=1\')">New Class Title</a></div>'); 

$("#studentid_input_box").append('<div id="addNewStudent"><a href="#" rel="#" onclick="addStudentPopup(\'<?php echo base_url(); ?>student/index/add?popup=1\')">New Student</a></div>'); 

// $("#instructor_input_box").append('<div id="addNewInstructor"><a href="#" rel="#" onclick="addStudentPopup(\'<?php echo base_url(); ?>instructors/index/add?popup=1\')">New Instructor</a></div>'); 

$("#field-telephone").attr('pattern','^[1-9]{2}[0-9]{8}$');




 });

function addStudentPopup(url) {
	window.open(url, "Add Student", "status = 1, height=600, width=800, resizable=0");
}

function checkLoginStatus() {
	$.get("/welcome/checkLoginStatus", function(data) {
		 		if(data === '0') {
		 		
		 			if(confirm('Your session has expired due to inactivity. Click OK to login again.')) {
			 			
			 			location.reload(true);
		 			}
		 			
		 			
			 		
		 		}
	 	});
}

</script>
<noscript><div class="alert alert-error"><h1>This application requires JavaScript to run properly. Please enable JavaScript in your browser.</h1></div></noscript>
</head>
<body>


<!--Navigation-->
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container-fluid">
                <a class="brand" href="/">
                    <img src="/assets/app/img/logo.png" height="45" alt="logo" id="logo" class="hidden-phone" /></a>
                <ul id="primary-nav" class="nav">
                    <li><a href="/checkin"><i class="nav-icon-9"></i><span>Dashboard</span></a></li>
                    <li class="dropdown"><a href="/classschedule" data-toggle="dropdown"><i class="nav-icon-14"></i><span>
                        Courses</span></a>
                        
                    </li>
                     <li class="dropdown"><a href="/company" data-toggle="dropdown"><i class="nav-icon-8"></i><span>
                        Company</span></a>
                        
                    </li>
                    <li><a href="/billing"><i class="nav-icon-12"></i><span>Billing</span></a></li>
                    <li class="dropdown"><a href="/student" data-toggle="dropdown"><i class="nav-icon-5"></i><span>
                        Student</span></a>
                        <ul class="dropdown-menu">
                            <li><a href="slideshow.html"><i class="icon-play-circle"></i>&nbsp;Fullscreen Slideshow</a></li>
                            <li><a href="/register"><i class="icon-picture"></i>&nbsp;Register</a></li>
                        </ul>
                    </li>
                    <li><a href="/enrollment"><i class="nav-icon-10"></i><span>Register</span></a></li>
                     <li><a href="/reports"><i class="nav-icon-1"></i><span>Reports</span></a></li>
                      <li><a href="/invoice"><i class="nav-icon-7"></i><span>Invoicing</span></a></li>
                </ul>
                
                <ul id="secondary-nav" class="visible-desktop nav pull-right">
                    <li><a style="color:#3fa0ee;" data-toggle="modal" href="#myModal"><i class="icon-user icon-white"></i>&nbsp;Hello, <strong><?php if(isset($username)) { echo $username; } ?></strong></a></li>
                    <li class="dropdown"><a style="color:#3fa0ee;" href="/admin" data-toggle="dropdown"><i class="icon-cog icon-white">
                    </i><span>Settings</span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#"><i class="icon-wrench"></i>&nbsp;Site Config</a></li>
                            <li><a href="#"><i class="icon-picture"></i>&nbsp;Themes</a></li>
                        </ul>
                    </li>
                    <li><a style="color:#3fa0ee;" href="/logout"><i class="icon-off icon-white"></i>&nbsp;Logout</a></li>
                </ul>
            </div>
        </div>
    <!--</div>-->
    
   
    <!--Profile Form-->
    <div class="modal hide fade" id="myModal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
                ×</button>
            <h3>
                Profile</h3>
        </div>
        <div class="modal-body">
            <form class="form-horizontal">
            <legend>Contact Info</legend>
            <div class="control-group">
                <label class="control-label" for="txtContactName">
                    Name</label>
                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-user"></i></span>
                        <input class="span4" id="txtContactName" type="text">
                    </div>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="txtPhone">
                    Phone</label>
                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-comment"></i></span>
                        <input class="span4" id="txtPhone" type="text">
                    </div>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="txtEmail">
                    E-mail</label>
                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-envelope"></i></span>
                        <input class="span4" id="txtEmail" type="text">
                    </div>
                </div>
            </div>
            <legend>Security Info</legend>
            <div class="control-group">
                <label class="control-label" for="txtLoginID">
                    Login ID</label>
                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-user"></i></span>
                        <input class="span4" id="txtLoginID" type="text" value="admin" disabled>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="txtPassword">
                    Password
                </label>
                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-lock"></i></span>
                        <input class="span4" id="txtPassword" type="password">
                    </div>
                </div>
            </div>
            </form>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-primary" data-dismiss="modal">Save changes</a> <a href="#"
                class="btn" data-dismiss="modal">Cancel</a>
        </div>
    </div>
    </div>
    <!--end of nav and header-->
    <!--start of content-->
<div class="container-fluid">

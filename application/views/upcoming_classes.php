<link type="text/css" rel="stylesheet" href="http://campus.zoodleweb.com/assets/grocery_crud/css/ui/simple/jquery-ui-1.8.23.custom.css" />
<script src="http://campus.zoodleweb.com/assets/grocery_crud/js/jquery-1.8.1.min.js"></script>
<script src="http://campus.zoodleweb.com/assets/grocery_crud/js/jquery_plugins/ui/jquery-ui-1.8.23.custom.min.js"></script>
 
<script>
$(document).ready(function(){		
	$("#upcomingClasses").submit(function(){
	var form = $(this);
	var post_url = form.attr('action');
	var post_data = form.serialize();	
			$.ajax({
				type:'POST',
				url: post_url,
				data: post_data,
				dataType: "json",
				success: function(msg) {
						$("#response").html(msg);
						$("#response").show();
						
					  //var generator=window.open('','Check In Sheet','height=800,width=1000');

					 // generator.document.write(msg);
					 // generator.document.close();

				
				}
			});
		return false;
		});
	});					
</script>



<div style='height:20px;'></div> 

<div>
<h1>Upcoming Classes Report</h1>
<p>This report will show total number of students enrolled in classes within a specified date range, not including cancelled classes and/or student registrations.</p>
  <form method="post" action="/reports/generateUpcomingClassesReport" id="upcomingClasses" name="upcomingClasses">
    	<label for="datepickerFrom">From Date</label> 
    	
    	<input type="text" id="datepickerFrom" class="datepicker" name="datepickerFrom" placeholder="Choose From Date" value="<?php echo date('Y-m-d'); ?>" /> (Required)
   		
   		<br />
   		
   		<label for="datepickerTo">To Date</label>&nbsp; &nbsp;&nbsp;
   	    <input type="text" id="datepickerTo" class="datepicker" name="datepickerTo" placeholder="Choose To Date" value="" /> (optional, if blank will show indefinitely into the future)
		
		<br /><br />
		
   		<button type="submit" id="submit" class="submit">Generate Form</button>
   		
    </form>
    
    <div id="response" style="display:none;"></div>
</div>
    
<script>
$( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
</script>

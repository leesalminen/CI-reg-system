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


<div class="row">
<div class="span12">
<h1>Upcoming Classes Report</h1>
<div class="alert alert-info">This report will show total number of students enrolled in classes within a specified date range, not including cancelled classes and/or student registrations.</div>
  <form method="post" action="/reports/generateUpcomingClassesReport" id="upcomingClasses" name="upcomingClasses">
    	<label for="datepickerFrom"><b>From Date</b></label> 
    	
    	<input type="text" id="datepickerFrom" class="datepicker" name="datepickerFrom" placeholder="Choose From Date" value="<?php echo date('m-d-Y'); ?>" /> (Required)
   		
   		<br />
   		
   		<label for="datepickerTo"><b>To Date</b></label>
   	    <input type="text" id="datepickerTo" class="datepicker" name="datepickerTo" placeholder="Choose To Date" value="" /> (optional, if blank will show indefinitely into the future)
		
		<br /><br />
		
   		<button type="submit" id="submit" class="btn btn-primary">Generate Form</button>
   		
    </form>
    
    <div id="response" style="display:none;"></div>
</div>
</div>
<script>
$( ".datepicker" ).datepicker({ dateFormat: 'mm-dd-yy' });
</script>

<script>
$(document).ready(function(){
	$("#costReport").submit(function(){
	var form = $(this);
	var post_url = form.attr('action');
	var post_data = form.serialize();	
			$.ajax({
				type:'POST',
				url: post_url,
				data: post_data,
				dataType: "json",
				success: function(msg) {
						$("#response").html(msg).show();
				}
			});
		return false;
		});
				
	});					
</script>

<div style='height:20px;'></div> 

<div style="width:100%;">
<h1>Courseware Cost Report</h1>
<p>This report will show all courseware costs for a given date range. This report will only show enrollments that have been Checked In.</p>

	<h4>Search by Date Range</h4>
  <form method="post" action="/coursewarecostreport/generateCostReport" id="costReport" name="costReport">
  		    
    	<label for="datepickerFrom">From Date</label> 
    	
    	<input type="text" id="datepickerFrom" class="datepicker" name="datepickerFrom" placeholder="Choose From Date" value="<?php echo date('m-d-Y'); ?>" /> (Required)
   		
   		<br />
   		
   		<label for="datepickerTo">To Date</label>&nbsp; &nbsp;&nbsp;
   	    <input type="text" id="datepickerTo" class="datepicker" name="datepickerTo" placeholder="Choose To Date" value="" /> (optional, if blank will show indefinitely into the future)
		
		<br /><br />
    		 
   		<button type="submit" id="submit" class="submit">Generate Form</button>
   		
    </form>
    
    <div id="response" style="display:none;"></div>

</div>
   
<script>
$( ".datepicker" ).datepicker({ dateFormat: 'mm-dd-yy' });
</script>

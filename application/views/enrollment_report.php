<script>
$(document).ready(function(){
	$("#aeReport").submit(function(){
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
<h1>Enrollment Report</h1>
<p>This report will show all enrollments for a specified date range and account executive.</p>

	<h4>Search by AE And Date Range</h4>
  <form method="post" action="/aeReport/generateEnrollmentReport" id="aeReport" name="aeReport">
  		
 <label for="salesrepid">Account Executive</label> <?php echo $salesrepid; ?>
    
    <br />
    
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

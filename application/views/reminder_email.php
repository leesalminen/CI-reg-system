 <script>
$(document).ready(function(){
	$("#unBilledEnrollments").submit(function(){
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
						$("#selectAllP").show();
						$("#ajaxLoader").hide();
						$("#createContainer").show();
				}
			});
		return false;
		});
		
	$("#createInvoice").click(function(){
	var post_url = '/reminderemail/sendReminderEmail/';
	var post_data = $('#checkIn').find('input').serialize();	
			$.ajax({
				type:'POST',
				url: post_url,
				data: post_data,
				dataType: "json",
				success: function(msg) {
					if(msg == '1') {
					
						$.pnotify({
						title: 'Reminder Email Sent!',
						text: 'Page will refresh in 3 seconds...',
						type: 'success',
						nonblock:true,
						nonblock_opacity: .4,
						delay: 3000

					});	
					
					setTimeout(function(){
                        location.reload();
                    }, 3100);  
							
					}		
				}
			});
		return false;
		});
		
});
function selectAllCheckbox() {
	$(".checkbox").each( function() {
		$(this).attr("checked",true);
	});

}
function unSelectAllCheckbox() {
$(".checkbox").each( function() {
		$(this).attr("checked",false);
	});
}		
</script>


<div>
<h1>Student Reminder Emails</h1>
<p>Send Student Reminder Emails for enrollments by date range.</p>
<div class="alert span12"><p><b>Notice! </b>This WILL NOT SHOW students that indicated they did not want to receive emails at enrollment. This WILL NOT SHOW students that have already been sent a reminder email.</p>
</div>
<div class="span12">
  <form method="post" action="/reminderemail/getEnrollments" id="unBilledEnrollments" name="unBilledEnrollments">
  		
  	  		
  		<div id="dates">	
    	<label for="datepickerFrom"><b>From Date</b></label> 
    	
    	<input type="text" id="datepickerFrom" class="datepicker" name="datepickerFrom" placeholder="Choose From Date" value="<?php echo date('Y-m-d'); ?>" /> (Required)
   		
   		<br />
   		
   		<label for="datepickerTo"><b>To Date</b></label>
   	    <input type="text" id="datepickerTo" class="datepicker" name="datepickerTo" placeholder="Choose To Date" value="" /> (optional, if blank will show indefinitely into the future)
		
		<br /><br />
		</div>
   		<button type="submit" id="submit" class="btn btn-primary">Show Enrollments</button>
   		
    </form>
</div>

<div class="clear" style="clear:both;min-height:10px;">&nbsp;</div>
    
    <p style="display:none;" id="selectAllP"><a href="#" id="selectAll" onclick="selectAllCheckbox();return false;">Select All</a>  |  <a href="#" id="unSelectAll" onclick="unSelectAllCheckbox(); return false;">UnSelect All</a></p>
    <div id="response" style="display:none;"></div>
    
    
        <div id="createContainer" style="display:none;"><br /><br /><button type="submit" id="createInvoice" name="createInvoice" class="btn btn-primary" value="submit">Email Reminder to Student</button></div>

    
</div>


    
<script>
$( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
</script>


<hr />
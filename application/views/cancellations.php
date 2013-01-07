<script>
$(document).ready(function(){

//$(".green").parent().css('background-color','#CCFFCC');
//if($(".green")) { .find(".green").parent().css('background-color','#CCFFCC'); }

	$("#datepicker").change(function(){
	var form = $(this);
	var post_url = '/checkin/getClassesForDate';
	var post_data = form.serialize();	
			$.ajax({
				type:'POST',
				url: post_url,
				data: post_data,
				dataType: "json",
				success: function(msg) {
					if(msg == '<option value="null">No Classes Scheduled</option>'){
						$("#courses").find('option').remove();
						$("#courses").append(msg).show();
						$("#submit").hide();

					} else {
						$("#courses").find('option').remove();
						$("#courses").append(msg).show();
						$("#submit").show();
					}					
				}
			});
		return false;
		});
		
	$("#generateCheckin").submit(function(){
	var form = $(this);
	var post_url = form.attr('action');
	var post_data = form.serialize();	
	//$('#orderNotes').append('<img src="/updates/concrete5.5.2.1/concrete/images/throbber_white_16.gif" id="throbber" />');
			$.ajax({
				type:'POST',
				url: post_url,
				data: post_data,
				dataType: "json",
				success: function(msg) {
						$("#response").html(msg);
						$("#response").show();
						
					 // var generator=window.open('','Check In Sheet','height=800,width=1000');

					// generator.document.write(msg);
					 //generator.document.close();

				
				}
			});
		return false;
		});
	});		
	
function cancelEnrollment(data) {
	var id = data;
		$.ajax({
				type:'POST',
				url: '/cancellations/cancelEnrollment',
				data: 'id='+id,
				dataType: "json",
				success: function(msg) {
					if(msg == 'ok'){
					
						$.pnotify({
						title: 'Enrollment Cancelled!',
						text: 'Enrollment Cancelled!',
						type: 'success',
						nonblock:true,
						nonblock_opacity: .4
						});				
						
						$("#"+id).parent().parent().parent().remove();	

					} else {
						$.pnotify({
						title: 'Uh Oh!',
						text: 'Something went wrong, try again in a few seconds. If this continues happening, please tell Lee or Brett.',
						type: 'error',
						nonblock:true,
						nonblock_opacity: .4
						}); 
						
					}					
				}
			});
	return false;
}						
</script>
<div class="row">
	<div class="span12">    
   <h1>Cancel Enrollments</h1>
   <div class="alert alert-info">This page will allow you to cancel individual or multiple enrollments for a single class. <strong>The table generated will only show students NOT SHOW checked in, no-show, or student cancelled.</strong></div> 
   	
    <form method="post" action="/cancellations/getEnrollmentsForClass" id="generateCheckin" name="generateCheckin">
    	<label for="datepicker">Date</label> 
    	<input type="text" id="datepicker" name="datepicker" placeholder="Choose Date" value="" />
   		
   		
   		<select id="courses" name="courses" style="display:none;">   		
   		
   		</select>

   		<button type="submit" id="submit" class="submit" style="display:none;">Show Enrollments</button>
   		
    </form>
    
    <div id="response" style="display:none;"></div>
	</div>
</div>
    <script>
$( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
</script>
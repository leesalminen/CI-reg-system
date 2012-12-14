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
	$('#orderNotes').append('<img src="/updates/concrete5.5.2.1/concrete/images/throbber_white_16.gif" id="throbber" />');
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
	<div id="banner-bar">
		<h2>Generate Sign In Sheet</h2>
	</div>
    
    
    
    <div style="height:25px;">&nbsp;</div>
    
   <h1>Printable Sign In Sheet By Date & Course</h1>
   <p>Select a Date and a course to generate a sign in sheet for print.</p>
   	
    <form method="post" action="/checkin/generateCheckinSheet" id="generateCheckin" name="generateCheckin">
    	<label for="datepicker">Date</label> 
    	<input type="text" id="datepicker" name="datepicker" placeholder="Choose Date" value="" />
   		
   		
   		<select id="courses" name="courses" style="display:none;">   		
   		
   		</select>

   		<button type="submit" id="submit" class="submit" style="display:none;">Generate Form</button>
   		
    </form>
    
    <div id="response" style="display:none;"></div>
    
    <script>
$( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
</script>
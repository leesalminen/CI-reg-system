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
	
	
	function checkInChange(data) {
	if($("#cancelP"+data).hasClass('green')) { alert("Error! Other status active. Disable, then try again"); return false; }
	if($("#noShowP"+data).hasClass('green')) { alert("Error! Other status active. Disable, then try again"); return false; }
	
		$.ajax({
				type:'POST',
				url: '/checkin/checkInChange',
				data: 'id='+data,
				dataType: "json",
				success: function(msg) {
						//alert(msg);
						if(msg == '1') {
							if($("#checkIn"+data).parent().hasClass('green') == false) {
								$("#checkIn"+data).parent().addClass('green');
							} else {
								$("#checkIn"+data).parent().removeClass('green');
							}
							
						} else { 
							alert('Error. Try Again.');
						}
				}
		});
	}
	
	
	function cancelChange(data) {
	if($("#checkInP"+data).hasClass('green')) { alert("Error! Other status active. Disable, then try again"); return false; }
	if($("#noShowP"+data).hasClass('green')) { alert("Error! Other status active. Disable, then try again"); return false; }
		$.ajax({
				type:'POST',
				url: '/checkin/cancelChange',
				data: 'id='+data,
				dataType: "json",
				success: function(msg) {
						//alert(msg);
						if(msg == '1') {
							if($("#cancel"+data).parent().hasClass('green') == false) {
								$("#cancel"+data).parent().addClass('green');
							} else {
								$("#cancel"+data).parent().removeClass('green');
							}						} else { 
							alert('Error. Try Again.');
						}
				}
		});
	
	
	}
			
	
	function noShowChange(data) {
	if($("#checkInP"+data).hasClass('green')) { alert("Error! Other status active. Disable, then try again"); return false; }
	if($("#cancelP"+data).hasClass('green')) { alert("Error! Other status active. Disable, then try again"); return false; }

		$.ajax({
				type:'POST',
				url: '/checkin/noShowChange',
				data: 'id='+data,
				dataType: "json",
				success: function(msg) {
						//alert(msg);
						if(msg == '1') {
							if($("#noShow"+data).parent().hasClass('green') == false) {
								$("#noShow"+data).parent().addClass('green');
							} else {
								$("#noShow"+data).parent().removeClass('green');
							}
						} else { 
							alert('Error. Try Again.');
						}
				}
		});
	
	
	
	}			
</script>
	<div id="banner-bar">
		<h2>Check In … Shows Todays Classes Only (Change to today before launch)</h2>
	</div>
    
  <!--  <h2>Generate Check In Forms</h2>
    
   
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

<hr />
-->
    <div>
       <h2>Live Check In</h2>
       <!--<p>This form does not show enrollments with statuses "Cancelled" or "No Show" already marked.</p>-->
       
       
        <?php echo $table; ?>
 
    </div>
  

 
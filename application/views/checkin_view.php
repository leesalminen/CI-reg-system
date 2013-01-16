<script>

$(document).ready(function(){
setInterval('updateClock()', 1000);
setInterval('checkForNewEnrollments()',100000);

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
	if($("#cancelP"+data).hasClass('green')) { 
		$.pnotify({
						title: 'Error Changing CheckIn Status',
						text: 'Other status active for that student. Disable, then try again.',
						type: 'error',
						nonblock:true,
						nonblock_opacity: .4,
						delay: 3500

					});
		//alert("Error! Other status active. Disable, then try again");
		return false;
	 }
	if($("#noShowP"+data).hasClass('green')) {
		$.pnotify({
						title: 'Error Changing CheckIn Status',
						text: 'Other status active for that student. Disable, then try again.',
						type: 'error',
						nonblock:true,
						nonblock_opacity: .4,
						delay: 3500

					}); 
		//alert("Error! Other status active. Disable, then try again"); 
		return false; 
	}
	
		$.ajax({
				type:'POST',
				url: '/checkin/checkInChange',
				data: 'id='+data,
				dataType: "json",
				cache: false,
				success: function(msg) {
						//alert(msg);
						if(msg == '1') {
							if($("#checkIn"+data).parent().hasClass('green') == false) {
								$("#checkIn"+data).parent().addClass('green');
								
							} else {
								$("#checkIn"+data).parent().removeClass('green');

							}
							
						} else { 
							$.pnotify({
						title: 'Uh Oh!',
						text: 'Something went wrong, try again in a few seconds. If this continues happening, please tell Lee or Brett.',
						type: 'error',
						nonblock:true,
						nonblock_opacity: .4

					});

							//alert('Error. Try Again.');
						}
				}
		});
	}
	
	
	function cancelChange(data) {
	if($("#checkInP"+data).hasClass('green')) { 
		$.pnotify({
						title: 'Error Changing CheckIn Status',
						text: 'Other status active for that student. Disable, then try again.',
						type: 'error',
						nonblock:true,
						nonblock_opacity: .4,
						delay: 3500

					});

	//alert("Error! Other status active. Disable, then try again"); 
	return false; 
	}
	if($("#noShowP"+data).hasClass('green')) { 
		$.pnotify({
						title: 'Error Changing CheckIn Status',
						text: 'Other status active for that student. Disable, then try again.',
						type: 'error',
						nonblock:true,
						nonblock_opacity: .4,
						delay: 3500

					});

	//alert("Error! Other status active. Disable, then try again");
	return false;
	}
		$.ajax({
				type:'POST',
				url: '/checkin/cancelChange',
				data: 'id='+data,
				dataType: "json",
				cache: false,
				success: function(msg) {
						//alert(msg);
						if(msg == '1') {
							if($("#cancel"+data).parent().hasClass('green') == false) {
								$("#cancel"+data).parent().addClass('green');
								

								
							} else {
								$("#cancel"+data).parent().removeClass('green');
								
							}						} else { 
							//alert('Error. Try Again.');
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
	
	
	}
			
	
	function noShowChange(data) {
	if($("#checkInP"+data).hasClass('green')) {
		$.pnotify({
						title: 'Error Changing CheckIn Status',
						text: 'Other status active for that student. Disable, then try again.',
						type: 'error',
						nonblock:true,
						nonblock_opacity: .4,
						delay: 3500

					});

		//alert("Error! Other status active. Disable, then try again");
		return false;
	}
	if($("#cancelP"+data).hasClass('green')) { 
		$.pnotify({
						title: 'Error Changing CheckIn Status',
						text: 'Other status active for that student. Disable, then try again.',
						type: 'error',
						nonblock:true,
						nonblock_opacity: .4,
						delay: 3500

					});

		//alert("Error! Other status active. Disable, then try again");
		return false; 
	}

		$.ajax({
				type:'POST',
				url: '/checkin/noShowChange',
				data: 'id='+data,
				dataType: "json",
				cache: false,
				success: function(msg) {
						//alert(msg);
						if(msg == '1') {
							if($("#noShow"+data).parent().hasClass('green') == false) {
								$("#noShow"+data).parent().addClass('green');
								

							} else {
								$("#noShow"+data).parent().removeClass('green');
							

							}
						} else { 
							//alert('Error. Try Again.');
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
	
	
	
	}		
	
	function updateClock ( )
    {
    var currentTime = new Date ( );
    var currentHours = currentTime.getHours ( );
    var currentMinutes = currentTime.getMinutes ( );
    var currentSeconds = currentTime.getSeconds ( );

    // Pad the minutes and seconds with leading zeros, if required
    currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
    currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;

    // Choose either "AM" or "PM" as appropriate
    var timeOfDay = ( currentHours < 12 ) ? "AM" : "PM";

    // Convert the hours component to 12-hour format if needed
    currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;

    // Convert an hours component of "0" to "12"
    currentHours = ( currentHours == 0 ) ? 12 : currentHours;

    // Compose the string for display
    var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;
    
    
    $("#clock").html(currentTimeString);
        
 }
 
 function checkForNewEnrollments() {
 	var data = $("#numRows").val();
 	$.ajax({
				type:'POST',
				url: '/checkin/checkForNewEnrollments',
				data: 'numRows='+data,
				dataType: "json",
				success: function(msg) {
					//$("#testingResponse").html('').html(msg);
					if(msg == '1') {
						$.pnotify({
    title: 'New Enrollments Found!',
    text: 'New enrollments found for today, refresh page.<br /><a href="/checkin" style="text-align:center;">Refresh Page</button>',
    type: 'error',
    hide: false
});
					
					}				
				}
			});
 
 }
 
		
</script>
<div class="row-fluid">
	<div class="span9">
	<h1>Welcome to the Dashboard</h1>
		<!--<h1>Check In … Shows Todays Classes Only</h1>-->
	</div>
	<div class="span3">
	<div class="label label-info">
	<p style="margin-bottom:0;margin-left:20px;">Live Check In - <span id="clock"></span> - <?=date('m.d.Y');?></p>
	</div>
		<!--<h1>Check In … Shows Todays Classes Only</h1>-->
	</div>
</div>
    
 <!--   <p id="testingResponse"><a href="#" onclick="checkForNewEnrollments();">Click</a></p>
   <h2>Generate Check In Forms</h2>
    
   
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
    	<?php if(isset($numRows)) { ?> <input id="numRows" type="hidden" value="<?=$numRows;?>" /><?php } ?>
      <!-- <p class="label label-info" style="margin-bottom:0;margin-left:20px;">Live Check In - <span id="clock"></span> - <?=date('m.d.Y');?></p>-->
       <!--<h4 style="margin-top:5px;">Logged In As: <?=$username;?>. Not <?=$username;?>? <a href="/logout">Logout</a></h4>-->
       <!--<p>This form does not show enrollments with statuses "Cancelled" or "No Show" already marked.</p>-->
       
       
      <?php if(!isset($noRows)) { echo $table; } else { echo '
     
      <div class="alert alert-info">No active registrations for today ... Go Home Early :)</div>
      <div class="well"><h4>Since there\'s nothing to do, here\'s a fun fact for you!</h4><p>' .$random. '</p></div>'; } ?>
       
    </div>
    
    <div class="row" style="margin-top:25px;">
    <div class="span12">
    <p><b>Fun Fact:</b> 
    <?php echo $random; ?>
    </p>
    </div>
    </div>
    
    </div>

 
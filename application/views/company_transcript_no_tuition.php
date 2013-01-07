<script>
$(document).ready(function(){	
		$.ajax({
				type:'POST',
				url: '/companytranscript/getCompanies',
				data: '',
				dataType: "json",
				success: function(msg) {
						$("#companies").html(msg);
						$("#companies").show();
						$("#submit").show();
				}
			});
			

	$("#companyTranscriptReport").submit(function(){
	var form = $(this);
	var post_url = form.attr('action');
	var post_data = form.serialize();	
			$.ajax({
				type:'POST',
				url: post_url,
				data: post_data,
				dataType: "json",
				success: function(msg) {
						$("#response").show();
						if(msg == '<p style="color:red;font-weight:bold;">No Classes Found.</p>') {$.pnotify({
						title: 'Report Not Generated!',
						text: 'Organizational Transcript With Tuition report NOT generated! '+msg,
						type: 'error',
						delay: 10000

					});
	} else {
		$.pnotify({
						title: 'Report Generated!',
						text: 'Organizational Transcript With Tuition report generated! Click the link to save/print. '+msg[0],
						type: 'success',
						delay: 10000

					});
							//$("#response").html(msg[0]);
							window.open((msg[1]), '', 'height=800,width=1000');
						}			
				}
			});
		return false;
		});
				
	});					
</script>



<div style="width:100%;">
<h1>Organizational Transcript Without Tuition</h1>
<p>This report will generate a transcript for an organization showing all students for that organization and which classes they have attended.</p>

	<h4>Search by Company</h4>
  <form method="post" action="/companytranscript/generateCompanyTranscriptReportNoTuition" id="companyTranscriptReport" name="companyTranscriptReport">
  		
    	<label for="Companies">Select a Company:</label> 
    	
    	<select id="companies" name="companies" style="display:none;"></select>
    			
		<br /><br />
		<div id="student" style="display:none;">
		<label for="students">Select a Student:</label> 
    	
    	<select id="students" name="students"></select>
    			
		<br /><br />
		</div>
		 
   		<button type="submit" id="submit" class="btn btn-primary" style="display:none;">Generate Form</button>
   		
    </form>
    
    <div id="response" style="display:none;"></div>

</div>
   

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
						if(msg == '<p style="color:red;font-weight:bold;">No Classes Found.</p>') { $("#response").html(msg);	} else {
							$("#response").html(msg[0]);
							window.open((msg[1]), '', 'height=800,width=1000');
						}			
				}
			});
		return false;
		});
				
	});					
</script>

<div style='height:20px;'></div> 

<div style="width:100%;">
<h1>Company/Organization Transcript Report</h1>
<p>This report will generate a transcript for an organization showing all students for that organization and which classes they have attended.</p>

	<h4>Search by Company</h4>
  <form method="post" action="/companytranscript/generateCompanyTranscriptReport" id="companyTranscriptReport" name="companyTranscriptReport">
  		
    	<label for="Companies">Select a Company:</label> 
    	
    	<select id="companies" name="companies" style="display:none;"></select>
    			
		<br /><br />
		<div id="student" style="display:none;">
		<label for="students">Select a Student:</label> 
    	
    	<select id="students" name="students"></select>
    			
		<br /><br />
		</div>
		 
   		<button type="submit" id="submit" class="submit" style="display:none;">Generate Form</button>
   		
    </form>
    
    <div id="response" style="display:none;"></div>

</div>
   

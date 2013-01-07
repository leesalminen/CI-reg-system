<script>
$(document).ready(function(){	
		$.ajax({
				type:'POST',
				url: '/studenttranscript/getCompanies',
				data: '',
				dataType: "json",
				success: function(msg) {
						$("#companies").html(msg);
						$("#companies").show();
				}
			});
			
		$("#companies").change(function(){	
			var val = $("#companies").val();
			$.ajax({
				type:'POST',
				url: '/studenttranscript/getStudent/'+val+'/',
				data: 'companyid='+val,
				dataType: "json",
				success: function(msg) {
					if(msg == '<option value="null">No Classes Scheduled</option>'){
						$("#students").find('option').remove();
						$("#students").append(msg).show();
						$("#submit").hide();

					} else {
						$("#students").find('option').remove();
						$("#students").append(msg).show();
						$("#student").show();
						$("#submit").show();
					}					
				}
			});
		return false;
		});

	$("#studentTranscriptReport").submit(function(){
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
						if(msg == '<p style="color:red;font-weight:bold;">No Classes Found.</p>') { $.pnotify({
						title: 'Report Not Generated!',
						text: 'Individual Student Transcript report NOT generated! '+msg,
						type: 'error',
						delay: 10000

					});
	} else {
							$.pnotify({
						title: 'Report Generated!',
						text: 'Individual Student Transcript Report Generated, click the link to save/print. '+msg[0],
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
			
	
	$("#searchForStudent").submit(function(){
	var form = $(this);
	var post_url = form.attr('action');
	var post_data = form.serialize();	
			$.ajax({
				type:'POST',
				url: post_url,
				data: post_data,
				dataType: "json",
				success: function(msg) {
						$("#names").html(msg);
						$("#names").show();	
						$("#submit2").show();			
				}
			});
		return false;
		});
				
	});	
	
	function generateReportByName(id, companyid) {
			//alert('students='+id+',companies='+companyid);
			$.ajax({
				type:'POST',
				url: '/studenttranscript/generateStudentTranscriptReport',
				data: 'students='+id+'&companies='+companyid,
				dataType: "json",
				success: function(msg) {
						$("#response2").show();
						if(msg == '<p style="color:red;font-weight:bold;">No Classes Found.</p>') { $.pnotify({
						title: 'Report Not Generated!',
						text: 'Individual Student Transcript report NOT generated! '+msg,
						type: 'error',
						delay: 10000

					});
	} else {
						$.pnotify({
						title: 'Report Generated!',
						text: 'Individual Student Transcript Report Generated, click the link to save/print. '+msg[0],
						type: 'success',
						delay: 10000

					});
							//$("#response2").html(msg[0]);
							window.open((msg[1]), '', 'height=800,width=1000');
						}			
				}
			});
		return false;
		};
				
</script>


<div style="width:100%;">
<h1>Individual Student Transcript Report</h1>
<p>This report will generate a transcript for an individual student.</p>

<div style="width:50%;float:left;">
	<h4>Search by Company</h4>
  <form method="post" action="/studenttranscript/generateStudentTranscriptReport" id="studentTranscriptReport" name="studentTranscriptReport">
  		
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

<div style="width:50%;float:left;">
<h4>Search by Last Name</h4>
<form method="post" action="/studenttranscript/searchForStudent" id="searchForStudent" name="searchForStudent">
    	<label for="studentLastName">Enter a Last Name: </label> 
    	<input type="text" placeholder="Last Name" id="studentLastName" name="studentLastName" />
    	<button type="submit" id="submit2" class="btn btn-primary">Search</button>
    	    			
		<br /><br />
		   		
    </form>
    
    	<div id="names"></div>


    <div id="response2" style="display:none;"></div>


</div>

<div style="clear:both;">&nbsp;</div>

</div>
   

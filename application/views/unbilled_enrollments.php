 <script>
$(document).ready(function(){
	$.ajax({
		type:'POST',
		url: '/invoice/getCompanies',
		data: '',
		dataType: "json",
		success: function(msg) {
				$("#company").html(msg);
				$("#company").show();
		}
	});
	$("#company").change(function(){	
		var val = $("#company").val();
		$.ajax({
			type:'POST',
			url: '/invoice/getBillingContacts/'+val+'/',
			data: 'companyid='+val,
			dataType: "json",
			success: function(msg) {
				if(msg == '<option value="null">No Billing Contacts Found</option>'){
					$("#billingcontact").find('option').remove();
					$("#billingcontact").append(msg);
					$("#billingcontactContainer").show();
					$("#submit").hide();

				} else {
					$("#billingcontact").find('option').remove();
					$("#billingcontact").append(msg);
					$("#billingcontactContainer").show();
					$("#dates").show();
					$("#submit").show();
				}					
			}
		});
	return false;
	});	
	$("#unBilledEnrollments").submit(function(){
	$("#ajaxLoader").html('<img src="../ajax-loader.gif" />');
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
						$("#createContainer").show();
						$("#ajaxLoader").hide();
				}
			});
		return false;
		});
		
	$("#createInvoice").click(function(){
	var val = $("#billingcontact").val();
	//$("#createInvoice").hide();
	var post_url = '/invoice/createInvoice/'+val;
	var post_data = $('#checkIn').find('input').serialize();	
			$.ajax({
				type:'POST',
				url: post_url,
				data: post_data,
				dataType: "json",
				success: function(msg) {
					$("#response2").html(msg);
					$.pnotify({
						title: 'Invoice created!',
						text: '<a href="/invoice/viewGeneratedInvoices">Click Here</a> to view the invoice.',
						type: 'success',
						nonblock:true,
						nonblock_opacity: .4,
						delay: 5000

					});					
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
		$(this).attr("checked",true);
	});
}			
</script>



<div style='height:20px;'></div> 

<div>
<h1>View UnBilled Enrollments</h1>
<p>View Unbilled enrollments by Company, Billing Contact & Date Range</p>
  <form method="post" action="/invoice/getUnBilledEnrollments" id="unBilledEnrollments" name="unBilledEnrollments">
  		
  		<label for="company">Company:</label>
  		<select id="company" name="company" style="display:none;"></select>
  		
  		<div id="billingcontactContainer" style="display:none;">
  		<br />
  		<label for="billingcontact">Billing Contact:</label>
  		<select id="billingcontact" name="billingcontact"></select>
  		<br />
  		</div>
  		
  		<div id="dates" style="display:none;">	
    	<label for="datepickerFrom">From Date</label> 
    	
    	<input type="text" id="datepickerFrom" class="datepicker" name="datepickerFrom" placeholder="Choose From Date" value="<?php echo date('Y-m-d'); ?>" /> (Required)
   		
   		<br />
   		
   		<label for="datepickerTo">To Date</label>&nbsp; &nbsp;&nbsp;
   	    <input type="text" id="datepickerTo" class="datepicker" name="datepickerTo" placeholder="Choose To Date" value="" /> (optional, if blank will show indefinitely into the future)
		
		<br /><br />
		</div>
   		<button type="submit" id="submit" class="submit" style="display:none;">Show Enrollments</button>
   		
    </form>
    <div id="ajaxLoader"></div>
    
    <p style="display:none;" id="selectAllP"><a href="#" id="selectAll" onclick="selectAllCheckbox();return false;">Select All</a>  |  <a href="#" id="unSelectAll" onclick="unSelectAllCheckbox(); return false;">UnSelect All</a></p>
    <div id="response" style="display:none;"></div>
    <div id="createContainer" style="display:none;"><br /><br /><button type="submit" id="createInvoice" name="createInvoice" value="submit">Create Invoice</button></div>
    
    <div id="response2"></div>
    
</div>


    
<script>
$( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
</script>

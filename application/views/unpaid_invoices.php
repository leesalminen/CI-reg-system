<script>
$(document).ready(function() {  
	$("#getDates").submit(function() { 
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
				}
			});
		return false;
		});
});

</script>



<div style='height:20px;'></div> 

<div>
<h1>UnPaid Invoices</h1>
<p>This page will list allow you to view unpaid invoices in intervals of 30, 60 or 90 days.</p>


<form action="/invoice/getUnPaidInvoices" method="post" id="getDates">
<select name="reconcile" id="reconcile">
<option value="30">30 Days</option>
<option value="60">60 Days</option>
<option value="90">90 Days</option>
</select>
<input type="submit" value="Show Invoices" name="submit" id="submit" />
</form>
  

<br />

<div id="response"></div>
      
</div>
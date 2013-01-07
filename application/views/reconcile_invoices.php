<script>
$(document).ready(function() {  
	$("#reconcile").submit(function() {
	$("#ajax").show(); 
	var form = $(this);
	var post_url = form.attr('action');
	var post_data = form.serialize();	
			$.ajax({
				type:'POST',
				url: post_url,
				data: post_data,
				dataType: "json",
				success: function(msg) {
						$("#invoiceID").val('');
						$("#response").append(msg);
						$("#ajax").hide();
				}
			});
		return false;
		});
});

</script>



<div style='height:20px;'></div> 

<div>
<h1>Receive Payments</h1>
<p>This page will list allow you to quickly mark invoices as paid. Simply enter the invoice number and click "Mark Invoice As Paid".</p>

<div>
<form action="/invoice/doReconcileInvoice" method="post" id="reconcile">
<input type="text" id="invoiceID" name="invoiceID" placeholder="Invoice ID" />
<input type="submit" value="Mark Invoice As Paid" name="submit" id="submit" class="btn btn-primary"/>
</form>
</div>
<div id="ajax" style="display:none;"><img src="../ajax-loader.gif" /></div>

<br />

<div id="response"></div>
      
</div>
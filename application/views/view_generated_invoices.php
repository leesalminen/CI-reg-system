<script>
function deleteInvoice(msg) {	
	var isGood=confirm('Do you wan\'t to delete this invoice? This can NOT be undone.');
    if (isGood) {
      $.get('/invoice/deleteInvoice/'+msg, function(data) {
  	  $('.result').html(data);
      $.pnotify({
						title: 'Invoice Deleted!',
						text: 'Invoice # '+msg+' deleted. Please <a href="/invoice/viewGeneratedInvoices">click here</a> to refresh the page.',
						type: 'success',
						nonblock:true,
						nonblock_opacity: .4,
						delay: 3500

					});
      
	  });
    } else {
      $.pnotify({
						title: 'Invoice Not Deleted',
						text: 'You cancelled deletion of Invoice # '+msg+'.',
						type: 'error',
						nonblock:true,
						nonblock_opacity: .4,
						delay: 3000

					});
    }
}
function emailInvoice(msg) {
	if(confirm('Are you sure you want to email invoice now? This will mark invoice as sent.'))
	{
      $.get('/invoice/sendInvoice/'+msg, function(data) {
  	  //$('.result').html(data);
      $.pnotify({
						title: 'Email Sent!',
						text: data,
						type: 'success',
						nonblock:true,
						nonblock_opacity: .4,
						delay: 3500

					});
      
	  });
	} else { return false; }
}
function markAsSent(msg) {
	if(confirm('Are you sure you want to mark invoice as sent? This can not be undone.'))
	{
      $.get('/invoice/markAsSent/'+msg, function(data) {
  	  //$('.result').html(data);
      $.pnotify({
						title: 'Invoice Marked as Sent! <a href="/invoice/viewGeneratedInvoices">Click</a> to refresh page.',
						text: data,
						type: 'success',
						nonblock:true,
						nonblock_opacity: .4,
						delay: 3500

					});
      
	  });
	} else { return false; }
}



</script>



<div style='height:20px;'></div> 

<div>
<h1>View Generated Invoices</h1>
<p>This page will list all generated, but unpaid invoices. You have the option to email, print, or delete any of these invoices.</p>

<?php echo $output; ?>
  
      
</div>
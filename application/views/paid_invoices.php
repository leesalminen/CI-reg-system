<!-- <script type="text/javascript" src="/css/jquery.pnotify.min.js"></script>
<style type="text/css" href="/css/jquery.pnotify.default.css"></style>
<style type="text/css" href="/css/jquery.pnotify.default.icons.css"></style>

<script>
$(document).ready(function() {
	$(".edit_button").click(function() {
		if($(this).attr('href').match('/$printPaidInvoice/$')) { return true; } else {
		$.ajax({
			type:'POST',
			url: $(this).attr('href'),
			data: '',
			dataType: "json",
			success: function(msg) {
			$("#response").append(msg);
			}
		});
		
	return false;
	}
	});

});


</script>
-->

<div>
<h1>View/Print Paid Invoices</h1>

<?php echo $output; ?>
  
<br />
<div id="response"></div>
</div>
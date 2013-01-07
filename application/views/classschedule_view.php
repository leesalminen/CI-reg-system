<?php $addTrue = $this->uri->segment(3); if($addTrue == 'add') { ?>
	
<script type="text/javascript">
	$(document).ready(function() {	
		$("#field-classtitleid").change(function(){	
		var val = $("#field-classtitleid").val();
		$.ajax({
			type:'POST',
			url: '/classschedule/getLength/'+val+'/',
			data: 'classid='+val,
			dataType: "json",
			success: function(msg) {
				if(msg == 'null'){
					
				} else {
					$("#field-duration").val(msg);
					
				}					
			}
		});
	return false;
	});	
});
</script>

<?php } ?>
<div class="alert alert-info">
<span style="text-align:center;">Click the magnifying class next to any class to view Class Roster!</span>
</div>


    <div id="topspacegc">
        <?php echo $output; ?>
 
    </div> 
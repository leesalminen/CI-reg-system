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

<div id="banner-bar">
		<h2>Courses</h2>
	</div>
    <div style='height:20px;'></div>  
    <div>
        <?php echo $output; ?>
 
    </div>
  

 
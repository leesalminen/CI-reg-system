<script>
function cancelEnrollment(data) {
	var id = data;
		$.ajax({
				type:'POST',
				url: '/cancellations/cancelEnrollment',
				data: 'id='+id,
				dataType: "json",
				success: function(msg) {
					if(msg == 'ok'){
					
						$.pnotify({
						title: 'Enrollment Cancelled!',
						text: 'Enrollment Cancelled!',
						type: 'success',
						nonblock:true,
						nonblock_opacity: .4
						});				
						
						$("#"+id).parent().parent().parent().remove();	

					} else {
						$.pnotify({
						title: 'Uh Oh!',
						text: 'Something went wrong, try again in a few seconds. If this continues happening, please tell Lee or Brett.',
						type: 'error',
						nonblock:true,
						nonblock_opacity: .4
						}); 
						
					}					
				}
			});
	return false;
}					
</script>
<style type="text/css">
@media print {
	 #header{display:none;}
  #nav{display:none;}
  #banner-bar{display:none;}
  .footer{display:none;}
  #submit{display:none;}
  #response2{display:none;}
  #noPrint1{display:none;}
  .navbar {display:none;}
	
	
}
</style>
    <div class="well">
    
    <h3>Class Name: <a href="<?php echo $url; ?>" target="_blank" style="font-size:inherit;"><?php echo $classname; ?></a></h3>
    <h4>Class Start Date: <?php echo $startdate; ?> | Class End Date: <?php echo $enddate; ?></h4>
    <h4>Duration: <?php echo $length; ?> | Instructor: <?php echo $instructor; ?> | Location: <?php echo $location; ?> | Type: <?php echo $classType; ?></h4>
    <h4>Laptops? <?php echo $laptops;  if (isset($numLaptops)) {   ?> | How Many Laptops? <?php echo $numLaptops; } ?></h4>
   	<p><b>Notes: </b><?php echo $notes; ?></p>
    </div>

        <?php echo $output; ?>
     
     
     
     <h3>Total # Of Students: <?php echo $numStudents; ?></h3>
      <h4>Gross Revenue: <?php echo $grossCost; ?> | Gross Courseware: <?php echo $grossCourseware; ?> | Net Revenue: <?php echo $netRevenue; ?></h4>
     
      <div id="response2" class="alert alert-info"><b>Helpful Tip:</b> You can print this page directly without any headers/footers. Just hit Control+P to get a print preview !</div>

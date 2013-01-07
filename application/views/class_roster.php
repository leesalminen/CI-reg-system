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
    
    <h2>Class Name: <?php echo $classname; ?></h2>
    <h3>Class Date: <?php echo $startdate; ?></h3>
    <h4>Length: <?php echo $length; ?> | Instructor: <?php echo $instructor; ?> | Laptops? <?php echo $laptops; ?> | Location: <?php echo $location; ?></h4>
   	
    </div>

        <?php echo $output; ?>
     
     
     
     <h3>Total # Of Students: <?php echo $numStudents; ?></h3>
     
      <div id="response2" class="alert alert-info"><b>Helpful Tip:</b> You can print this page directly without any headers/footers. Just hit Control+P to get a print preview !</div>

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
	<div id="banner-bar">
		<h2>Class Roster  |  <a href="/classschedule">Back to Courses…</a></h2>
	</div>
	
    <div style='height:20px;'></div>  
    <div>
    
    <h1>Class Name: <?php echo $classname; ?></h1>
    <h3>Class Date: <?php echo $startdate; ?></h3>
    <h3>Length: <?php echo $length; ?></h3>
 	<h3>Instructor: <?php echo $instructor; ?></h3>
   	<h3>Laptops? <?php echo $laptops; ?></h3>
   	<h3>Location: <?php echo $location; ?></h3>

        <?php echo $output; ?>
     
     
     
     <h2>Total # Of Students: <?php echo $numStudents; ?></h2>
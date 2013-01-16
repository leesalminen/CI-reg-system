<script>
$(document).ready(function() {  
	/*$("#backupDB").submit(function() { 
	var form = $(this);
	var post_url = '/dbBackup/doBackup';
	var post_data = '';	
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
		});*/
		
});

</script>


<div class="row">
<div class="span12">
<h1>Database Backup</h1>
<p>This page will allow you to backup your database into a .zip file downloaded to your computer.</p>


<a href="/dbBackup/doBackup"><button class="btn btn-primary" id="backupDB">Click Here To Backup Database</button></a>  


<div id="response"></div>
      
</div>
</div>
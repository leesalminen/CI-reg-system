<script>
$(document).ready(function(){	

	$("#changePassword").submit(function(){
	var form = $(this);
	var post_url = form.attr('action');
	var post_data = form.serialize();	
			$.ajax({
				type:'POST',
				url: post_url,
				data: post_data,
				dataType: "json",
				success: function(msg) {
						$("#response").show();
						if(msg == 'error') { $.pnotify({
						title: 'Password Not Changed!',
						text: 'Error Changing Password',
						type: 'error',
						delay: 10000

					});
	} else {
						$.pnotify({
						title: 'Password Changed!',
						text: 'Your password has been changed!',
						type: 'success',
						delay: 10000

					});
				}								}			
			
			});
		return false;
		});
				
	});					
</script>

    <div style='height:20px;'></div>  
    <div>
    <h1>Change Your Password</h1>
    <h2>Username: <?php echo $username; ?></h2>
    <form method="post" action="/admin/users/doChangePassword" id="changePassword">
    <input type="hidden" value="<?php echo $username; ?>" name="username" id="username" />
    New Password: <input type="password" id="password" name="password" />
    Confirm Password: <input type="password" id="confirmPassword" name="confirmPassword" />
    <br />
    Email Address: <input type="text" id="email" name="email" />
    <br /><br />
    <input type="submit" value="Change Password" id="submit" />
    
    </form>
    
     
    </div>

 
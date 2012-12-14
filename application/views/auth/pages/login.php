<div id="login">
	
	<h2>Login to Campus Linc WebApp</h2>
	<div class="box">
			<?php echo form_open(); ?>
			Username/Email:<br />
			<input type="text" name="username" value="<?php echo set_value('username'); ?>" size="50" class="form" /><?php echo form_error('username'); ?><br /><br />
			Password:<br />
			<input type="password" name="password" value="<?php echo set_value('password'); ?>" size="50" class="form" /><?php echo form_error('password'); ?><br /><br />
			<input type="submit" value="Login" name="login" />
			</form>
	</div>
	
	<h4>Forgot your username and/or password? <a href="mailto:lee@zoodlemarketing.com">Click to Email Lee.</a></h4>
</div>
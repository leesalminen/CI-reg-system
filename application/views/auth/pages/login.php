<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="<?=base_url()?>css/main.css" type="text/css" />
 <script src="http://campus.zoodleweb.com/assets/grocery_crud/js/jquery-1.8.2.min.js"></script></head>
 <body style="background:url('<?php echo base_url(); ?>img/bg.jpg') top center no-repeat #000000 !important;font-family:helvetica;">
 
<div id="login">
	
	
	<div class="box">
	<p style="text-align:center;padding-right:35px;"><img src="/images/logo.jpg" /></p>
			<?php $attr = array('style' => 'margin:0 auto;margin-left:30px;'); echo form_open('',$attr); ?>
			Username/Email:<br />
			<input placeholder="Username/Email" type="text" name="username" value="<?php echo set_value('username'); ?>" size="50" class="form" /><?php echo form_error('username'); ?><br /><br />
			Password:<br />
			<input placeholder="Password" type="password" name="password" value="<?php echo set_value('password'); ?>" size="50" class="form" /><?php echo form_error('password'); ?><br /><br />
			<input type="submit" value="Login" name="login" />
			</form>
	</div>
	
	<h4 style="text-align:center;">Forgot your username and/or password?<br> <a href="mailto:lee@zoodlemarketing.com">Click to Email Lee.</a></h4>
</div>
</body>
</html>
	<div id="banner-bar">
		<h2>Register</h2>
	</div>
    <div style='height:20px;'></div>  
    <div>
    
 
   

        <?php echo $output; ?>
        <?php if(isset($dropdown_setup)) {
    	$this->load->view('dependent_dropdown', $dropdown_setup);
		}?>
	<?php $addTrue = $this->uri->segment(3); if($addTrue == 'add') { ?>
		<script type="text/javascript">$(document).ready(function() {var classid = $('select[name="classid"]');$('#classid_input_box').append('<img src="http://campus.zoodleweb.com/ajax-loader.gif" border="0" id="classid_ajax_loader" class="dd_ajax_loader" style="display: none;">');var datesid = $('select[name="datesid"]');$('#datesid_input_box').hide();datesid.children().remove().end();classid.change(function() {var select_value = this.value;$('#classid_ajax_loader').show();datesid.find('option').remove();var myOptions = "";$.getJSON('http://campus.zoodleweb.com//enrollment/getdates/'+select_value, function(data) {datesid.append('<option value=""></option>');$.each(data, function(key, val) {datesid.append($('<option></option>').val(val.value).html(val.property));});$('#datesid_input_box').show();classid.each(function(){$(this).trigger("liszt:updated");});datesid.each(function(){$(this).trigger("liszt:updated");});$('#classid_ajax_loader').hide();});});});</script>	
 <?php } ?>
    </div>

 
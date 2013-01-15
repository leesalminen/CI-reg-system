    <div id="topspacegc">
    

        <?php echo $output; ?>
        <?php if(isset($dropdown_setup)) {
    	$this->load->view('dependent_dropdown', $dropdown_setup);
		}?>
	<?php $addTrue = $this->uri->segment(3); if($addTrue == 'add') { ?>
	
<script type="text/javascript">
	$(document).ready(function() {	
		$("#field-classid").change(function(){	
		var val = $("#field-classid").val();
		$.ajax({
			type:'POST',
			url: '/enrollment/getMSRP/'+val+'/',
			data: 'classid='+val,
			dataType: "json",
			success: function(msg) {
				if(msg == 'null'){
					
				} else {
					$("#field-tuition").val(msg.tuition);
					
					
					if(msg.courseware != '') {
					$("#field-courseware").val(msg.courseware);
					
					}
				}					
			}
		});
	return false;
	});	
});
</script>
 <script type="text/javascript">$(document).ready(function() {var classid = $('select[name="classid"]');$('#classid_input_box').append('<img src="http://campus.zoodleweb.com/ajax-loader.gif" border="0" id="classid_ajax_loader" class="dd_ajax_loader" style="display: none;">');var datesid = $('select[name="datesid"]');$('#datesid_input_box').hide();datesid.children().remove().end();classid.change(function() {var select_value = this.value;$('#classid_ajax_loader').show();datesid.find('option').remove();var myOptions = "";$.getJSON('http://campus.zoodleweb.com//enrollment/getdates/'+select_value, function(data) {datesid.append('<option value=""></option>');$.each(data, function(key, val) {datesid.append($('<option></option>').val(val.value).html(val.property));});$('#datesid_input_box').show();classid.each(function(){$(this).trigger("liszt:updated");});datesid.each(function(){$(this).trigger("liszt:updated");});$('#classid_ajax_loader').hide();});});});</script>
 <?php } ?>
</div>



<div id="responseT" style="display:none;margin-top:30px;font-size:18px;"><strong>MSRP Tuition:</strong> </div>
<div id="responseC" style="display:none;font-size:18px;"><strong>MSRP Courseware:</strong> </div>

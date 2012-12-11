	<div id="banner-bar">
		<h2>Students</h2>
	</div>
    <div style='height:20px;'></div>  
    <div>
       <?php echo $output; ?>
        <?php if(isset($dropdown_setup)) {
    	$this->load->view('dependent_dropdown', $dropdown_setup);
		}?>
    </div>

 
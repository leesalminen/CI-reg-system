    <div id="topspacegc">
       <?php echo $output; ?>
        <?php if(isset($dropdown_setup)) {
    	$this->load->view('dependent_dropdown', $dropdown_setup);
		}?>
    </div>

 
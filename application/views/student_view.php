<div class="alert alert-info">
<span style="text-align:center;"><b>Helpful Tip:</b> Click the magnifying glass next to any class to view Individual Student Class Details!</span>
</div>
    <div id="topspacegc">
       <?php echo $output; ?>
        <?php if(isset($dropdown_setup)) {
    	$this->load->view('dependent_dropdown', $dropdown_setup);
		}?>
    </div>

 
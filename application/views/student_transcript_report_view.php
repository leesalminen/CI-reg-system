<style type="text/css">
@media print {
	 #header{display:none;}
  #nav{display:none;}
  #banner-bar{display:none;}
  .footer{display:none;}
  #submit{display:none;}
  #response2{display:none;}
  #noPrint1{display:none;}
  .navbar {display:none;}
	
	
}
</style>
<img src="<?=base_url()?>images/logo.png" style="margin-bottom:15px;" />

    <div class="well">
    
    <h2>Student Transcript Report For: <?php echo $fullname; ?></h2>
    <h3>Company: <?php echo $company; ?></h3>
    <h3>Generated On: <?php echo $today; ?></h3>
   	
    </div>

        <?php echo $output; ?>
     
     
     
     <h3>Total # Of Courses: <?php echo $total; ?></h3>
     
      <div id="response2" class="alert alert-info"><b>Helpful Tip:</b> You can print this page directly without any headers/footers. Just hit Control+P to get a print preview !</div>

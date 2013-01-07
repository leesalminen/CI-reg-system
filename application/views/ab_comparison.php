<script>
$(document).ready(function(){		
	$("#abCompare").submit(function(){
	var form = $(this);
	var post_url = form.attr('action');
	var post_data = form.serialize();	
			$.ajax({
				type:'POST',
				url: post_url,
				data: post_data,
				dataType: "json",
				success: function(msg) {
					
						$("#response").html(msg);
						$("#response").show();
						$("#response2").show();

						
					  //var generator=window.open('','Check In Sheet','height=800,width=1000');

					 // generator.document.write(msg);
					 // generator.document.close();

				
				}
			});
		return false;
		});
	});					
</script>
<style type="text/css">

@media print
  {
  
  #header{display:none;}
  #nav{display:none;}
  #banner-bar{display:none;}
  .footer{display:none;}
  #submit{display:none;}
  #response2{display:none;}
  #noPrint1{display:none;}
  
  }
</style>

	
	
    <div style='height:20px;'></div>  
    <h1>A-B Course Comparison</h1>
    <p>Students Took Class A, But NOT Class B Report</p>
    <form action="/aBComparison/do_compare" method="post" id="abCompare">
    <label for="classA">Student Took Class A: </label>
    <select name="classA" id="classA">
    <?php foreach($classname as $name) { 
    	echo $name;
    }
    ?>
    </select>
    <br />
    <label for="classB">But, Did NOT Take Class B: </label>
    <select name="classB" id="classB">
     <?php foreach($classname as $name) { 
    	echo $name;
    }
    ?>
    </select>
    
    <br /><br />
    
    <input type="submit" class="btn btn-primary" value="Search For Students" id="submit" />
    </form>
    <div id="response" style="display:none;"></div>
    
    <div id="response2" style="display:none" class="alert alert-info"><p style="font-weight:bold;">Helpful Tip: You can print this page directly without any headers/footers. Just hit Control+P to get a print preview !</p></div>
 	

<?php

include($path.'header.php');

?>
  

        <div class="wrapper">
            <div class="container">
                <div class="row">

<?php include($path.'menu.php'); ?>				
				
                    <div class="span9">
                        <div class="content">
							<div class="module">
							<div class="module-head">
								<h3>
<?php
  echo $page_name;								
?>								
								</h3>
							</div>
							<div class="module-body">
							
	<?php
    if(!empty($error))
    {

?>	
									<div class="alert alert-error">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong><?php echo $error; ?></strong> 
									</div>					
	
<?php
   }
   
   ?>
   
   
	
<form class="form-horizontal row-fluid" action="<?php echo $_SERVER['REQUEST_URI'];?>" enctype="multipart/form-data"  method="post">  

<h3>Invoice Details </h3>

<div class="control-group">
<label class="control-label" for="basicinput">Invoice name *</label>
<div class="controls">
<input data-title="item" name="item" type="text" data-original-title="" class="span8 tip" value="<?php echo $item; ?>">
</div>
</div>

<div class="control-group">
<label class="control-label" for="basicinput">Upload File</label>
<div class="controls">
<input name="invoice" type="file" class="span8 tip">
</div>
</div>

<div class="control-group">
<label class="control-label" for="basicinput">Send it to OBR?</label>
<div class="controls" id="genre">
<select name="send" class="span8">
<option value="yes">Yes</option>
<option value="no">No</option>
</select>
</div>
</div>

 
<div class="control-group">
		<div class="controls">
			<a href="index.php" class="btn btn-inverse">Back</a> &nbsp; &nbsp;
			<button type="submit" name="Submit" class="btn btn-primary">Submit</button>
		</div>
</div>
								

</form>
							
							</div>
						</div><!--/.module-->

						
                        </div>
                        <!--/.content-->
                    </div>
                    <!--/.span9-->
                </div>
            </div>
            <!--/.container-->
        </div>
        <!--/.wrapper-->
   <?php include($path."footer.php"); ?> 
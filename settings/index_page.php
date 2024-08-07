<?php include($path.'header.php'); ?>

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
   
   
   <?php
    if(!empty($error1))
    {

?>	
									<div class="alert alert-success alert-dismissable">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong><?php echo $error1; ?></strong> 
									</div>					
	
<?php
   }
   
   ?>
   
	
		<form class="form-horizontal row-fluid" action="<?php echo $_SERVER['REQUEST_URI'];?>" enctype="multipart/form-data" method="post">
		

<h2> Settings </h2>

<br />			
		
<div class="control-group">
<label class="control-label" for="basicinput">Country</label>
<div class="controls">
<select name="country_site" tabindex="1" class="span8">
    <option value="Burundi">Burundi</option>			
	</select>
</div>
</div>		
		
		
<div class="control-group">
<label class="control-label" for="basicinput">Name of the site</label>
<div class="controls">
<input data-title="name_site" name="name_site" type="text" data-original-title="" class="span8 tip" value="<?php echo $name_site; ?>">
</div>
</div>

<div class="control-group">
<label class="control-label" for="basicinput">Site Url</label>
<div class="controls">
<input data-title="url_site" name="url_site" type="text" data-original-title="" class="span8 tip" value="<?php echo $url_site; ?>">
</div>
</div>	

<div class="control-group">
<label class="control-label" for="basicinput">Company name</label>
<div class="controls">
<input data-title="company_name" name="company_name" type="text" data-original-title="" class="span8 tip" value="<?php echo $company_name; ?>">
</div>
</div>	

<div class="control-group">
<label class="control-label" for="basicinput">Company address</label>
<div class="controls">
<input data-title="company_address" name="company_address" type="text" data-original-title="" class="span8 tip" value="<?php echo $company_address; ?>">
</div>
</div>

<div class="control-group">
<label class="control-label" for="basicinput">Administrator name</label>
<div class="controls">
<input data-title="admin_name" name="admin_name" type="text" data-original-title="" class="span8 tip" value="<?php echo $admin_name; ?>">
</div>
</div>	

<div class="control-group">
<label class="control-label" for="basicinput">Administrator mail</label>
<div class="controls">
<input data-title="admin_email" name="admin_email" type="text" data-original-title="" class="span8 tip" value="<?php echo $admin_email; ?>">
</div>
</div>	

<div class="control-group">
<label class="control-label" for="basicinput">Administrator signature</label>
<div class="controls">
<textarea name="admin_signature" class="span8" rows="4"><?php echo $admin_signature; ?></textarea>
</div>
</div>	

<div class="control-group">
<label class="control-label" for="basicinput">Phone number</label>
<div class="controls">
<input data-title="phone_site" name="phone_site" type="text" data-original-title="" class="span8 tip" value="<?php echo $phone_site; ?>">
</div>
</div>

<div class="control-group">
<label class="control-label" for="basicinput">Site Logo (300x300)</label>
<div class="controls">
<input name="logo_site" type="file" class="span8 tip">
</div>
</div>	

<?php
 if(!empty($logosite))
 {
?> 

<div class="control-group">
<label class="control-label" for="basicinput">Current logo</label>
<div class="controls">
<img src="<?php echo @$path.$logosite; ?>" > 
</div>
</div>
<?php		
}
?>


<br /> 

<hr>

<!--

<br />

<h2> AfriPAY </h2>

<br />

<div class="control-group">
<label class="control-label" for="basicinput">Access Token</label>
<div class="controls">
<input data-title="access_token" name="access_token" type="text" data-original-title="" class="span8 tip" value="<?php echo $access_token; ?>">
</div>
</div>	


<div class="control-group">
<label class="control-label" for="basicinput">App id</label>
<div class="controls">
<input data-title="app_id" name="app_id" type="text" data-original-title="" class="span8 tip" value="<?php echo $app_id; ?>">
</div>
</div>

<div class="control-group">
<label class="control-label" for="basicinput">App secret</label>
<div class="controls">
<input data-title="app_secret" name="app_secret" type="text" data-original-title="" class="span8 tip" value="<?php echo $app_secret; ?>">
</div>
</div>

<br />

<hr>

-->

<br />

<h2> SMTP configuration </h2>

<br />

<div class="control-group">
<label class="control-label" for="basicinput">Staff Mail</label>
<div class="controls">
<input data-title="staff_site" name="staff_site" type="text" data-original-title="" class="span8 tip" value="<?php echo $staff_site; ?>">
</div>
</div>	


<div class="control-group">
<label class="control-label" for="basicinput">Email password</label>
<div class="controls">
<input data-title="email_password" name="email_password" type="text" data-original-title="" class="span8 tip" value="<?php echo $email_password; ?>">
</div>
</div>



<br />

<hr>

<br />

<h2> Other configurations </h2>

<br />


<div class="control-group">
<label class="control-label" for="basicinput">Currency</label>
<div class="controls">
<input data-title="currency_site" name="currency_site" type="text" data-original-title="" class="span8 tip" value="<?php echo $currency_site; ?>">
</div>
</div>	

<!--

<div class="control-group">
<label class="control-label" for="basicinput">VAT</label>
<div class="controls">
<input data-title="tva_site" name="tva_site" type="text" data-original-title="" class="span8 tip" value="<?php echo $tva_site; ?>"> %
</div>
</div>	

-->

<br />

<!--
<hr>

<br />

<h2> Terms and Conditions </h2>

<br />

  <p>
  
<textarea class="ckeditor" cols="80" id="editor1" name="terms_conditions" rows="10"><?php echo $terms_conditions; ?></textarea>
 
  </p> 

  <br /><br />
  

<h2> Policy Privacy </h2>

<br />

  <p>
  
<textarea class="ckeditor" cols="80" id="editor1" name="policy_privacy" rows="10"><?php echo $policy_privacy; ?></textarea>
 
  </p> 

  <br /><br />  
  
-->
	

	<div class="control-group">
				<div class="controls">
			<!-- <a href="index.php" class="btn btn-inverse">Back</a> --> &nbsp; &nbsp;
			<button type="submit" name="Submit1" class="btn btn-primary">Save</button>
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
<?php
$path='../';
//$path_pagination='../../';
$path_pagination=$path;
$rubrique='settings';

if(isset($_GET['id']))
{
$page_name='Edit payment method';
}
else
{
$page_name = 'Add payment method';
}

include($path.'must.php');

$page_retour = 'list_payment.php';


   if(isset($_GET['id'])) // là on cherche les données à modifier
{
	$id = $conn->escape_string($_GET['id']);  
 
$sql = "SELECT * FROM method_payment WHERE id_method='".$id."'"; 
		
$req = $conn->query($sql);

if($req != false AND $req->num_rows == 0)
{
   header('Location: '.$page_retour); 
   exit();
}

$solu = $req->fetch_assoc();
	 
 }

 
$method	 = isset($_POST['method'])? $_POST['method']:(isset($_GET['id'])? $solu['method']:'');
$momo	 = isset($_POST['momo'])? $_POST['momo']:(isset($_GET['id'])? $solu['momo']:'');

$error = '';


if(isset($_POST['Submit1']))
{	

if(empty($method))
{
  $error .= 'Give the name of payment method <br />'; 
}
else
{
  // cherchons si il n'y aurait un autre qui a le même nom
  if(isset($_GET['id']))
  {
   $req1 = $conn->query("SELECT method FROM method_payment WHERE method='".$conn->escape_string($method)."' 
						AND id_method !='".$id."' AND status = 1 ");
  }
  else
  {
  $req1 = $conn->query("SELECT id_method FROM method_payment WHERE method='".$conn->escape_string($method)."' AND status=1 ");
  }
  
 if($req1 != false AND $req1->num_rows > 0) {

	 $error .= 'The payment method is already registered! Please use another one!  <br />'; 

} 
  
}	


   if(empty($error))
   {
   
		$accuse = date('jmY');
	  
	    $crypt = md5($accuse);
		
	if(!isset($_GET['id']))
	{	

		$sq3 = 'INSERT INTO method_payment (method,status,momo,created) VALUES("'.$conn->escape_string($method).'",
													"1",
													"'.$conn->escape_string($momo).'",
													NOW())';
										
										
		$req3 = $conn->query($sq3);
		
		
	// on va le rediriger vers la page d'accusation  avec comme variable p pour l'ajout
	  
	  header('Location: '.$page_retour.'?p='.$crypt); 
	  
	  exit();

   }
   else
   {
      $sq3 = 'UPDATE method_payment SET 
				method = "'.$conn->escape_string($method).'",
				momo = "'.$conn->escape_string($momo).'"
				WHERE id_method="'.$id.'"';
		
		$req3 = $conn->query($sq3);
		
			// on va le rediriger vers la page d'accusation  avec comme variable p pour l'ajout
	  
	  header('Location: '.$page_retour.'?i='.$crypt); 
	  
	  exit();
		
		
   }
	  
	    	
 }

}



?>
		
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
   

	
		<form class="form-horizontal row-fluid" action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post">

<div class="control-group">
<label class="control-label" for="basicinput">Payment method</label>
<div class="controls">
<input data-title="method" name="method" type="text" data-original-title="" class="span8 tip" value="<?php echo $method; ?>">
</div>
</div>

<div class="control-group">
<label class="control-label" for="basicinput"> Mobile Money</label>
<div class="controls">
<select name="momo" class="span8">
<option value="1" <?php if($momo == 1) { echo 'selected="selected"'; } ?>> Yes</option>
<option value="0" <?php if($momo == 0) { echo 'selected="selected"'; } ?>> No </option>
</select>
</div>
</div> 	


<div class="control-group">
		<div class="controls">
			<a href="list_payment.php" class="btn btn-inverse">Back</a> &nbsp; &nbsp;
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
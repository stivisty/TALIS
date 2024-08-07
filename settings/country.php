<?php
$path='../';
//$path_pagination='../../';
$path_pagination=$path;
$rubrique='settings';

include($path.'must.php');

$page_retour = 'list_countries.php';


if(isset($_GET['id']))
{
$page_name='Edit country';
}
else
{
$page_name = 'Add country';
}




   if(isset($_GET['id'])) // là on cherche les données à modifier
{
	$id = $conn->escape_string($_GET['id']);  
 
$sql = "SELECT * FROM a_pays WHERE rowid='".$id."'"; 
		
$req = $conn->query($sql);

if($req != false AND $req->num_rows == 0)
{
   header('Location: '.$page_retour); 
   exit();
}

$solu = $req->fetch_assoc();
	 
 }

 
$name_en 		= isset($_POST['name_en'])? $_POST['name_en']:(isset($_GET['id'])? $solu['en']:'');
$name_fr		= isset($_POST['name_fr'])?$_POST['name_fr']:(isset($_GET['id'])? $solu['fr']:'');
$code			= isset($_POST['code'])?$_POST['code']:(isset($_GET['id'])? $solu['code']:'');
$continent		= isset($_POST['continent'])?$_POST['continent']:(isset($_GET['id'])? $solu['region']:'');


$error = '';


if(isset($_POST['Submit1']))
{	

if(empty($name_en))
{
  $error .= 'Give the name of country in English <br />'; 
}	

if(empty($name_fr))
{
  $error .= 'Give the name of country in French <br />';
}

if(empty($code))
{
  $error .= 'Give the code of country <br />';
}
else
{
	$nbre = strlen($code);
	
	if($nbre != 2)
	{
		$error .= 'Code must be 2 characters <br /> ';
	}
}

if(empty($continent))
{
  $error .= 'Give the continent <br />';
}


   if(empty($error))
   {
   
		$accuse = date('jmY');
	  
	    $crypt = md5($accuse);
	

if(!isset($_GET['id'])) // lors de l'insertion
{	  

	$sq3 = 'INSERT INTO a_pays (code,fr,en,region) VALUES ("'.$conn->escape_string($code).'",
									"'.$conn->escape_string($name_fr).'",
									"'.$conn->escape_string($name_en).'",
									"'.$conn->escape_string($continent).'")';

		
	$req3 = $conn->query($sq3);
		
		
	// on va le rediriger vers la page d'accusation  avec comme variable p pour l'ajout
	  
	  header('Location: '.$page_retour.'?p='.$crypt); 
	  
	  exit();	
	    	
  
}
else
{

		$sq3 = 'UPDATE a_pays SET 
				fr = "'.$conn->escape_string($name_fr).'",
				en = "'.$conn->escape_string($name_en).'",
				code = "'.$conn->escape_string($code).'",
				region = "'.$conn->escape_string($continent).'"
		
				WHERE rowid="'.$id.'"';
		
		$req3 = $conn->query($sq3);
		
		
	// on va le rediriger vers la page d'accusation  avec comme variable i pour la modification
	  
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
<label class="control-label" for="basicinput">Country (EN)</label>
<div class="controls">
<input data-title="country" name="name_en" type="text" data-original-title="" class="span8 tip" value="<?php echo $name_en; ?>">
</div>
</div>	

<div class="control-group">
<label class="control-label" for="basicinput">Country (FR)</label>
<div class="controls">
<input data-title="country" name="name_fr" type="text" data-original-title="" class="span8 tip" value="<?php echo $name_fr; ?>">
</div>
</div>	

<div class="control-group">
<label class="control-label" for="basicinput">Code</label>
<div class="controls">
<input data-title="code" name="code" type="text" data-original-title="" class="span8 tip" value="<?php echo $code; ?>">
</div>
</div>

<div class="control-group">
<label class="control-label" for="basicinput">Continent</label>
<div class="controls">
<select name="continent" tabindex="1" data-placeholder="Selectionner ici.." class="span8">
	<option value=""> Select here </option>
	<option value="1" <?php echo ($continent == 1)?'selected="selected"':''; ?>> Africa </option>
	<option value="2" <?php echo ($continent == 2)?'selected="selected"':''; ?>> Europe </option>
	<option value="3" <?php echo ($continent == 3)?'selected="selected"':''; ?>> America </option>
	<option value="4" <?php echo ($continent == 4)?'selected="selected"':''; ?>> Asia </option>
	<option value="5" <?php echo ($continent == 5)?'selected="selected"':''; ?>> Oceania </option>									
	</select>
</div>
</div>


			<div class="control-group">
				<div class="controls">
			<a href="list_countries.php" class="btn btn-inverse">Back</a> &nbsp; &nbsp;
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
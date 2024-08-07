<?php

//ini_set('display_errors',1);
//error_reporting(E_ALL);

$path='../';
//$path_pagination='../../';
$path_pagination=$path;
$rubrique='admin';


if(isset($_GET['id']))
{
$page_name='Edit admin';
}
else
{
$page_name = 'Add admin';
}

include($path.'must.php');


if($_SESSION['admin_type'] != 'super')
{	

  if($_SESSION['admin_id'] != $_GET['id'])
  {
	header("location: ../index.php");
	exit();  
	
  }

}


$page_retour = 'index.php';


if(isset($_GET['id'])) // là on cherche les données à modifier
{
	$id = $_GET['id'];  
 
	//$sql = "SELECT * FROM admin WHERE id_admin='".trim(addslashes($id))."'"; 

	//$req = $conn->query($sql);
	
	$stmt = $pdo->prepare("SELECT * FROM admin WHERE id_admin = :id ");
	
	$stmt->execute(['id' => $id]);
	
	$res = $stmt->fetchAll();

    if(count($res) == 0)
    {
       header('Location: '.$page_retour); 
       exit();
    }

    $solu = $res[0];
	 
 }

 
$nom_admin	 		= isset($_POST['nom_admin'])? $_POST['nom_admin']:(isset($_GET['id'])? $solu['name']:'');
$username			= isset($_POST['username'])?$_POST['username']:(isset($_GET['id'])? $solu['username']:'');
$pass1				= isset($_POST['pass1'])?$_POST['pass1']:'';
$pass2				= isset($_POST['pass2'])?$_POST['pass2']:'';
$pass3				= isset($_POST['pass3'])?$_POST['pass3']:'';
$type				= isset($_POST['type'])?$_POST['type']:(isset($_GET['id'])? $solu['type']:'');

$error = '';
$error1 = '';


if(isset($_POST['Submit1']))
{

if(empty($nom_admin))
{
  $error .= 'Give the name of the admin <br />'; 
}		

if(empty($username))
{
  $error .= 'Give the username of the admin <br />'; 
}
else
{
  // cherchons si il n'y aurait un autre admin qui a le même username
  if(isset($_GET['id']))
  {
	$stmt = $pdo->prepare("SELECT name FROM admin WHERE username = :username AND id_admin != :id ");
	
	$stmt->execute(['username' => $username, 'id' => $id]);
	
  }
  else
  {
	$stmt = $pdo->prepare("SELECT id_admin FROM admin WHERE username= :username ");
	
	$stmt->execute(['username' => $username]);
  }
  
  $res = $stmt->fetchAll();
  
 if(count($res) > 0) {

	 $error .= 'The username is already used! Please use another one!  <br />'; 

} 
  
}	


if(!isset($_GET['id']))
{
if(empty($pass1) OR empty($pass2))
{
  $error .= 'One of the password field is empty <br />';
}
else
{
   if($pass1 != $pass2)
   {
       $error .= 'Passwords are not  identical! Please correct <br />';
   }
}

}

   if(empty($error))
   {
   
		$accuse = date('jmY');
	  
	    $crypt = md5($accuse);
		
	if(!isset($_GET['id']))
  {
		
		$stmt = $pdo->prepare('INSERT INTO admin (name,username,password,type,creator,created) VALUES(
										:nom,
										:username,
										:password,
										:type,
										:admin_name,
										NOW())');
										
		
		$stmt->execute(['nom' => $nom_admin,
	                    'username' => $username,
	                    'password' => password_hash($pass1, PASSWORD_BCRYPT),
	                    'type' => $type,
	                    'admin_name' => $admin_username
	                    ]);
	                    
		
	// on va le rediriger vers la page d'accusation  avec comme variable p pour l'ajout
	  
	  header('Location: '.$page_retour.'?p='.$crypt); 
	  
	  exit();

   }
   else
   {
		$stmt = $pdo->prepare('UPDATE admin SET 
                				name = :name,
                				username = :username,
                				type = :type
                				WHERE id_admin= :id ');
                				
        $stmt->execute(['name' => $nom_admin, 'username' => $username, 'type' => $type, 'id' => $id]);
        
        
		
	// on va le rediriger vers la page d'accusation  avec comme variable p pour l'ajout
	  
	  header('Location: '.$page_retour.'?i='.$crypt); 
	  
	  exit();
		
		
   }
	  
	    	
 }

}


 if(isset($_POST['Submit2'])) {

 if(empty($pass3))
{
  $error .= 'Give the new password <br />'; 
}	

  
  if(empty($error)) {
  
	//$accuse = date('jmY');
	  
	//$crypt = md5($accuse);

    $password_sel = md5('$Pesa&&'.$pass3.'--Bay%%');
  

	$stmt = $pdo->prepare('UPDATE admin SET 
				password = :password
				WHERE id_admin = :id ');
				
	$stmt->execute(['password' => password_hash($pass3, PASSWORD_BCRYPT), 'id' => $id ]);
		
	$error1 = 'Password has been successfully updated!';	
		
		
	// on va le rediriger vers la page d'accusation  avec comme variable i pour la modification
	  
	  //header('Location: '.$page_retour.'?i='.$crypt); 
	  
	  //exit();	
  
  
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
	
		<form class="form-horizontal row-fluid" action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post">

<div class="control-group">
<label class="control-label" for="basicinput">Admin name</label>
<div class="controls">
<input data-title="currency" name="nom_admin" type="text" data-original-title="" class="span8 tip" value="<?php echo $nom_admin; ?>">
</div>
</div>

<div class="control-group">
<label class="control-label" for="basicinput"> Type </label>
<div class="controls">
<select name="type" class="span8">
<option value="simple" <?php if($type == 'simple') { echo 'selected="selected"'; } ?>> Simple</option>
<option value="super" <?php if($type == "super") { echo 'selected="selected"'; } ?>> Super </option>
</select>
</div>
</div> 	

<div class="control-group">
<label class="control-label" for="basicinput">Username</label>
<div class="controls">
<input data-title="currency_code" name="username" type="text" data-original-title="" class="span8 tip" value="<?php echo $username; ?>">
</div>
</div>			


<?php

if(!isset($_GET['id']))
{
?>

<div class="control-group">
<label class="control-label" for="basicinput">Password *</label>
<div class="controls">
<input data-title="status" name="pass1" type="password" data-original-title="" class="span8 tip">
</div>
</div>


<div class="control-group">
<label class="control-label" for="basicinput">Retype password *</label>
<div class="controls">
<input data-title="status" name="pass2" type="password" data-original-title="" class="span8 tip">
</div>
</div>

<?php
}

?>
 
 
<br />

<div class="control-group">
		<div class="controls">
			<a href="index.php" class="btn btn-inverse">Back</a> &nbsp; &nbsp;
			<button type="submit" name="Submit1" class="btn btn-primary">Save</button>
											</div>
										</div>
									</form>
									
									
<?php

if(isset($_GET['id']))
{
?>

<br /><br />

<hr>

<h2> Change Password </h2>

<br />

<form class="form-horizontal row-fluid" name="password" action="<?php echo $_SERVER['REQUEST_URI'];?>"  method="post">


<div class="control-group">
<label class="control-label" for="basicinput">New Password </label>
<div class="controls">
<input data-title="status" name="pass3" type="password" data-original-title="" class="span8 tip" value="">
</div>
</div>  
 
 
<div class="control-group">
		<div class="controls">
			<button type="submit" name="Submit2" class="btn btn-primary">Change password</button>
		</div>
</div>

</form>


<?php

}

?>									
								  
		 
							
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
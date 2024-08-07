<?php

//ini_set('display_errors',1);
//error_reporting(E_ALL);

$path='../';
$path_pagination=$path;
$rubrique='settings';
$page_name='Settings';


include($path.'must.php');

$page_retour = 'index.php';

$path_logo_folder = $path.'images/logo/';

$front_end = '../../images/logo/';


function verif_image($index,$nomImage)
{
   $extensions = array( 'jpg' , 'jpeg' , 'gif' , 'png' ); 
   $maxsize = 2097152;
   $msg ='';
 
   //Test1: fichier correctement uploadé
     if (!isset($_FILES[$index]) OR $_FILES[$index]['error'] > 0) $msg = 'Error Transfert : '.$nomImage;
   //Test2: taille limite
     if ($maxsize !== FALSE AND $_FILES[$index]['size'] > $maxsize) $msg = $nomImage.' has not the recommended dimensions!';
   //Test3: extension
     $ext =  strtolower( substr(strrchr($_FILES[$index]['name'],'.'),1) );
     if ($extensions !== FALSE AND !in_array($ext,$extensions)) $msg = $nomImage.'  has not the right format!';
   
   return $msg;
}




$sqlC		= "SELECT * FROM a_lookup ";

$resC		= $pdo->query($sqlC);

$res        = $resC->fetchAll();

foreach ($res as $row) { 
    $vname		= stripslashes(trim($row["vLookUpName"]));
    $vvalue		= stripslashes(trim($row["vLookUpValue"]));
	
	switch($vname) {
		case 'country_site':
			$countrysite		= $vvalue;
			break;
		case 'name_site':
			$namesite		= $vvalue;
			break;
		case 'url_site':
			$urlsite		= $vvalue;
			break;	
		case 'company_name':
			$companyname		= $vvalue;
			break;	
		case 'company_address':
			$companyaddress		= $vvalue;
			break;			
		case 'admin_email':
			$adminemail			= $vvalue;
			break;
		case 'admin_name':
			$adminname			= $vvalue;
			break;
		case 'admin_signature':
			$adminsignature		= $vvalue; 
			break; 			
		case 'staff_site':
			$staffsite		= $vvalue;
			break;	
		case 'phone_site':
			$phonesite		= $vvalue;
			break;		
		case 'currency_site':
			$currencysite		= $vvalue;
			break;
		case 'tva_site':
			$tva_site		= $vvalue;
			break;			
		case 'logo_site':
			$logosite			= $vvalue;
			break;
		case 'email_password':
			$Pass_email_admin	= $vvalue;
			break;
			
		case 'terms_conditions':
		$terms_conditions	= $vvalue;
		break;

		case 'policy_privacy':
		$policy_privacy	= $vvalue;
		break;
		
		case 'access_token':
			$access_token	= $vvalue;
			break;			
		case 'app_id':
			$app_id			= $vvalue;
			break;
		case 'app_secret':
			$app_secret		= $vvalue;
			break;
	
	}	
}



 

$k = 0;
 
 
$country_site 		= isset($_POST['country_site'])? $_POST['country_site']:$countrysite;
$name_site			= isset($_POST['name_site'])?$_POST['name_site']:$namesite;
$url_site 			= isset($_POST['url_site'])? $_POST['url_site']:$urlsite;
$company_name 		= isset($_POST['company_name'])? $_POST['company_name']:$companyname;
$company_address 	= isset($_POST['company_address'])? $_POST['company_address']:$companyaddress;
$admin_name 		= isset($_POST['admin_name'])? $_POST['admin_name']:$adminname;
$admin_email 		= isset($_POST['admin_email'])? $_POST['admin_email']:$adminemail;
$email_password 	= isset($_POST['email_password'])? $_POST['email_password']:$Pass_email_admin;
$admin_signature 	= isset($_POST['admin_signature'])? $_POST['admin_signature']:$adminsignature;
$staff_site 		= isset($_POST['staff_site'])? $_POST['staff_site']:$staffsite;
$phone_site 		= isset($_POST['phone_site'])? $_POST['phone_site']:$phonesite;
$currency_site 		= isset($_POST['currency_site'])? $_POST['currency_site']:$currencysite;
$tva_site 			= isset($_POST['tva_site'])? $_POST['tva_site']:$tva_site;
$logo_site 			= isset($_POST['name_site'])? $_FILES['logo_site']['tmp_name']:'';
$terms_conditions 	= isset($_POST['terms_conditions'])? $_POST['terms_conditions']:$terms_conditions;
$policy_privacy 	= isset($_POST['policy_privacy'])? $_POST['policy_privacy']:$policy_privacy;

$access_token 		= isset($_POST['access_token'])? $_POST['access_token']:$access_token;
$app_secret 		= isset($_POST['app_id'])? $_POST['app_id']:$app_id;
$app_secret 		= isset($_POST['app_secret'])? $_POST['app_secret']:$app_secret;


	if(!isset($_POST['Submit1'])) {
    //On inclue le formulaire tous simplement
	include ("index_page.php");
      } 
 /* CAS - 2 : on doit inserer*/
 else {
      
	  $error = '';
	  $error1 = "";

	if($country_site == '')
	{
	  $error .= 'Choose the country <br />';   
	}
	
	if(empty($name_site))
	{
	  $error .= 'Please give the name of website <br />';   
	}
	
	if(empty($url_site))
	{
	  $error .= 'Give the url of website <br />';   
	}
	
	if(empty($admin_name))
	{
	  $error .= 'Give the administrator name <br />';   
	}
	
	if(empty($admin_email))
	{
	  $error .= 'Give the administrator email <br />';   
	}
	
	if(empty($staff_site))
	{
	  $error .= 'Give the email of SMTP configuration <br />';   
	}
	
	
	if(empty($email_password))
	{
	  $error .= 'Give the email password <br />';   
	}
	
	if(empty($admin_signature))
	{
	  $error .= 'Give the administrator signature <br />';   
	}
	
	if(empty($phone_site))
	{
	  $error .= 'Give the phone number <br />';   
	}
	
	if(empty($currency_site))
	{
	  $error .= 'Give the currency <br />';   
	}
	
	if(!empty($tva_site))
	{
		if (!(is_numeric($tva_site) AND $tva_site >= 0))
		{
			$error .= 'Please the tva must be a number higher or equal to zero  <br />'; 
		}
	      
	}
	
	

			if(!empty($logo_site))
			{
				$test_logo = verif_image('logo_site','Site Logo'); 

				$error .= $test_logo;
			}
			
/*
			
	if(empty($terms_conditions))
	{
	  $error .= 'Please give the terms and conditions  <br />';   
	}

*/	

	
	
	if(!empty($error)) {
	 	//il y'a une erreur on inclue le formulaire
    	include ("index_page.php");
		//et l'erreur lui sera afficher 
 	}
	else
	{
	
	    $accuse = date('jmY');
	  
	    $crypt = md5($accuse);
	

	
  //website					
						
	// website details
    foreach ($_POST as $key => $value) {
		
		if($key != 'Submit1')
	{
		
    // verifier si value existe

	$stmt = $pdo->prepare("SELECT * FROM a_lookup WHERE vLookUpName = :key ");
	
	$stmt->execute(['key' => $key]);
	
	$res = $stmt->fetchAll();

    if(count($res) > 0)
    {
    		$stmt = $pdo->prepare('UPDATE a_lookup SET vLookUpValue = :value WHERE vLookUpName = :name');
    		
    		$stmt->execute(['value' => $value,'name' => $key]);

    }
    else
    {
        
            $stmt = $pdo->prepare('INSERT INTO a_lookup(vLookUpName,vLookUpValue) VALUES(:key,:value)');
            
            $stmt->execute(['key' => $key, 'value' => $value]);
    		
    }
	
	
	}
	
}	
	
	
	// logo_site
	if(!empty($logo_site))
{	
	$nom = date('jmY\_hisa');
	$ext1 =  strtolower( substr(strrchr($_FILES['logo_site']['name'],'.'),1));
	$nom1 = $nom.'.'.$ext1;
	
	$logo_db = 'images/logo/'.$nom1;
	
	if(!(move_uploaded_file($_FILES['logo_site']['tmp_name'],$path_logo_folder.$nom1)))
	{
		echo 'The image1 has not been uploaded <br /> Verify the chmod of the folder <br /> <a href="index.php"> retry again </a> ';
		exit();
	}
	else
	{	

		 copy($path_logo_folder.$nom1,$front_end.$nom1);
	   
	   // verifier si logo_site existe
	$reqTest = $pdo->query("SELECT * FROM a_lookup WHERE vLookUpName ='logo_site' ");
	
	$res = $reqTest->fetchAll();

if(count($res) == 0)
{
		
		$stmt = $pdo->prepare('INSERT INTO a_lookup(vLookUpName,vLookUpValue) VALUES("logo_site",:value)');
            
        $stmt->execute(['value' => $logo_db]);
}		
else
{
		
		$stmt = $pdo->prepare('UPDATE a_lookup SET vLookUpValue = :value WHERE vLookUpName = "logo_site"');
    		
    	$stmt->execute(['value' => $logo_db]);
	
}	
	
	}
							 
}
		

		
		$error1 = "Update done successfully";
		
		
		$_SESSION["site_name"] = $name_site;
		
		
  	// on va le rediriger vers la page d'accusation  avec comme variable i pour la modification
	  
	  //header('Location: '.$page_retour.'?i='.$crypt); 
	  
	  //exit();

	  include ("index_page.php");
	  
	  



	
	}

}

?>
<?php
//ini_set('display_errors',1);
//error_reporting(E_ALL);

$path='../';
//$path_pagination='../../';
$path_pagination=$path;
$rubrique='invoice';

$page_name='Add Invoice';

include($path.'must.php');

$error = '';
$error1 = '';
  
 
 $path_folder = $path.'invoice/files/';
 

function verif_image($index,$nomImage)
{
   $extensions = array('xml'); 
   $maxsize = 2097152;
   $msg ='';
 
   //Test1: fichier correctement uploadé
     if (!isset($_FILES[$index]) OR $_FILES[$index]['error'] > 0) $msg = 'Error Transfert : '.$nomImage;
   //Test2: taille limite
     if ($maxsize !== FALSE AND $_FILES[$index]['size'] > $maxsize) $msg = $nomImage.' has not the recommended size (Maximum 2MB)!';
   //Test3: extension
     $ext =  strtolower( substr(strrchr($_FILES[$index]['name'],'.'),1) );
     if ($extensions !== FALSE AND !in_array($ext,$extensions)) $msg = $nomImage.'  has not the right format only XML is recommended!';
   
   return $msg;
}


//user info
$item  			    = isset($_POST['item'])? $_POST['item']:'';

$file 				= isset($_POST['item'])? $_FILES['invoice']['tmp_name']:'';


// ADD OR UPDATE USER

 if(!isset($_POST['item'])) {
    //On inclue le formulaire tous simplement
	include ("add_file_page.php");
    } 
 /* CAS - 2 : on doit inserer*/
 
if(isset($_POST['Submit'])) {
       
	$error = '';  


if($item == '') {

   $error .= 'Please give the name <br />';
} 
else{
    
    $stmt = $pdo->prepare("SELECT * FROM invoices WHERE item = :item ");
    
    $stmt->execute(['item' => $item]);
    
    $resItem = $stmt->fetchAll();
    
    if(count($resItem) > 0){
        
        $error .= 'Invoice name ('.$item.') already exist! Please use another one.';
    }
}

if(!empty($file))
{
	$test_file = verif_image('invoice','Invoice file'); 

	$error .= $test_file;
}
else{
    
     $error .= 'Please upload the file <br />';
}


//echo 'BLOC YEEESSS';

//exit;

  if(!empty($error)) {
	 	//il y'a une erreur on inclue le formulaire
		include ("add_file_page.php");
		//et l'erreur lui sera afficher 
 	}	
   else
   {
	   
	   
	// invoice
	if($_FILES['invoice']['tmp_name'] != '')	
	{	
			$nom 		= 'invoice_'.date('jmY\_hisa');
			$ext2 		=  strtolower( substr(strrchr($_FILES['invoice']['name'],'.'),1));
			$nom_inv	= $nom.'.'.$ext2;
			
			if(!(move_uploaded_file($_FILES['invoice']['tmp_name'],$path_folder.$nom_inv)))
			{
				echo 'The invoice file has not been uploaded <br /> Verify the chmod of the folder <br /> <a href="add_file.php"> Try again </a> ';
				exit();
			}
   
	}
	
	
	$stmt = $pdo->prepare("INSERT INTO invoices(item,file_name,created,creator) VALUES (:item,:file_name,NOW(),:creator) ");
	
	$stmt->execute(['item'=>$item, 'file_name'=>$nom_inv, 'creator'=> $_SESSION['admin_nom'] ]);
	
	$invoice_id = $pdo->lastInsertId();
	   
	
	if($_POST['send'] == 'yes'){
	    
	    header('Location: send_file.php?id='.$invoice_id);
	  
	    exit();
	    
	}
	else{
	    
	    $p = date('jmY');
	  
	    $crypt = md5($p);
	    
	    header('Location: index.php?p='.$crypt);
        
        exit();
	}
    

  }
  
 }

?>
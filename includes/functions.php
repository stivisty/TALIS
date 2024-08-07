<?php

function ipadress(){

  $ip=$_SERVER['REMOTE_ADDR'];
  echo $ip;
}


 function formatFR($number)
  {
	//$p = number_format($number, 2, ',', ' ');
	
	$p = number_format($number,0,',',' ');
	
	return $p;
  }
  
  function formatEN($number)
  {
    $t = number_format($number);
	
	return $t;
  }  

  
//################ PHP MAILER #######################"

include_once  dirname(__FILE__)."/PHPMailer/PHPMailerAutoload.php";


 function mail_phpmailer($adminemail,$password,$from_name,$address,$subject,$message,$host='',$file='') {
	 
if($host == '')
{
  $host = 'mail.'.$_SERVER["SERVER_NAME"];
  //$host = 'nyati.afriregister.co.ke';
} 
 
 $mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               	// Enable verbose debug output

$mail->isSMTP();                                      	// Set mailer to use SMTP
$mail->Host = $host;  							// Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = $adminemail;                 			// SMTP username
$mail->Password = $password;                           // SMTP password
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                                    // TCP port to connect to

$mail->From = $adminemail;
$mail->FromName = $from_name;
//$mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
$mail->addAddress($address);               // Name is optional
$mail->addReplyTo($adminemail, 'Reply');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

if($file != '')
{
	$mail->addAttachment('./'.$file);   // Add attachments
}

//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = $subject;
$mail->Body    = $message;
//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    $reponse = 'Message could not be sent.';
     $reponse .= 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    //echo 'Message has been sent';
	$reponse = '';
}			
			
	return $reponse;		

 }
 
 
 
function info_apps() {
	
	global $pdo;
	
	$sqlC		= "SELECT * FROM a_lookup ";
	$resC		= $pdo->query($sqlC);
    $res        = $resC->fetchAll();

    $info_hotel = array();

    if(count($res) > 0)
    {
        foreach($res as $row) { 
            $vname		= stripslashes(trim($row["vLookUpName"]));
            $vvalue		= stripslashes(trim($row["vLookUpValue"]));
    	
            $info_hotel[$vname] = $vvalue;
        }	
    }
	
    return $info_hotel;	
}
 
 
 
function is_valide_date($date, $sep='/')
{
	if(!list($day, $month, $year) = explode($sep, $date))
		return false;
 
	if($day > 31 OR $day < 1 OR $month > 12 OR $month < 1 OR $year > 32767 OR $year < 1)
		return false;
 
	return checkdate($month, $day, $year);
}

 
 

function random($car) {
$string = "";
$chaine = "123456789abcdefghijkmnpqrstuvwxyABCDEFGHJKMNPQRSTUVWXYZ";
srand((double)microtime()*1000000);
for($i=0; $i<$car; $i++) {
$string .= $chaine[rand()%strlen($chaine)];
}
return $string;
}

 
 
function name_country($id,$lang='en') {
	
	global $pdo;
	 
	$id = trim($id); 
	
	$stmt = $pdo->prepare("SELECT * FROM a_pays WHERE rowid=:id");
	
	$stmt->execute(['id' => $id]);
	
	$res = $stmt->fetchAll();

	$country = '';
	
	if(count($res) > 0)
    {
	    $datCountry = $res[0];

    	if($lang == 'fr')
    	{
    	   $country = $datCountry["fr"];
    	}
    	else
    	{
    		$country = $datCountry["en"];
    	}
	
    }
	
	return $country;
	
} 

 
function rmdir_recursive($dir)
{
	//Liste le contenu du repertoire dans un tableau
	$dir_content = scandir($dir);
	//Est-ce bien un repertoire?
	if($dir_content !== FALSE){
		//Pour chaque entree du r�pertoire
		foreach ($dir_content as $entry)
		{
			//Raccourcis symboliques sous Unix, on passe
			if(!in_array($entry, array('.','..'))){
				//On retrouve le chemin par rapport au debut
				$entry = $dir . '/' . $entry;
				//Cette entree n'est pas un dossier: on l'efface
				if(!is_dir($entry)){
					unlink($entry);
				}
				//Cette entree est un dossier, on recommence sur ce dossier
				else{
					rmdir_recursive($entry);
				}
			}
		}
	}
	//On a bien efface toutes les entrees du dossier, on peut a present l'effacer
	rmdir($dir);
} 
 

?>
<?php
session_start();

$path='';
$path_pagination='../';

$page_name = 'Login';


include("includes/connection_DB.php");

include("includes/functions.php");
 
$apps = info_apps(); // get info 


$_SESSION["site_name"] = empty($apps['name_site'])?'Admin Side1':$apps['name_site'];



  if(isset($_SESSION['admin_id']))
  {
    header('Location: index.php'); 
	exit();
  }
  
  // on verifie les info données

  $error ='';
  
  if(isset($_POST['login']))
  {
  
	$pseudo = isset($_POST['login'])?$_POST['login']:'';
	$password = isset($_POST['password1'])?$_POST['password1']:'';
	//$type = isset($_POST['type'])?$_POST['type']:'gest';
	
	if(!empty($_POST['login']) AND !empty($_POST['password1']))
	{
	 
	 
	// On initialise $existence_ft
    $existence_ft = '';
 
 
    // Si le fichier existe, on le lit
    if(file_exists('antibrute/'.$_POST['login'].'.tmp'))
    {
 
        // On ouvre le fichier
        $fichier_tentatives = fopen('antibrute/'.$_POST['login'].'.tmp', 'r+');
 
        // On récupère son contenu dans la variable $infos_tentatives
        $contenu_tentatives = fgets($fichier_tentatives);
		
		  // On découpe le contenu du fichier pour récupérer les informations
        $infos_tentatives = explode(';', $contenu_tentatives);
		
		
		 // Si la date du fichier est celle d'aujourd'hui, on récupère le nombre de tentatives
        if($infos_tentatives[0] == date('d/m/Y'))
        {
            $tentatives = $infos_tentatives[1];
        }
        // Si la date du fichier est dépassée, on met le nombre de tentatives à 0 et $existence_ft à 2
        else
        {
            $existence_ft = 2;
            $tentatives = 0; // On met la variable $tentatives à 0
        }	
 
    }
    // Si le fichier n'existe pas encore, on met la variable $existence_ft à 1 et on met les $tentatives à 0
    else
    {
        $existence_ft = 1;
        $tentatives = 0;
    }

	
	
  
    // S'il y a eu moins de 30 identifications ratées dans la journée, on laisse passer
   if($tentatives < 5)
   {

    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username=:username");
	
	$stmt->execute(['username' => $pseudo]);
	
	$res = $stmt->fetchAll();
	
      // on vérifie d'abord si le pseudo existe
	  if(count($res) > 0)
	  {
			//$password_sel = '$Pesa&&'.$password.'--Bay%%';
			//if($data['password'] != md5($password_sel))
			
			$data = $res[0];
	  
	  
	       //echo 'pass form: '.$password.'<br>';
	       
	       //echo 'pass db: '.$data['password'];
	       
	       //exit;
	  
			//if(!password_verify($password,$data['password']))
			
			//if(count($data) == 0)
			
			if(!password_verify($password,$data['password']))
			{
			
			   $pseudo11 = stripslashes($data['username']);
			
			    // Si le fichier n'existe pas encore, on le créer
               if($existence_ft == 1)
               {
                   $creation_fichier = fopen('antibrute/'.$pseudo11.'.tmp', 'a+'); // On créer le fichier puis on l'ouvre
                   fputs($creation_fichier, date('d/m/Y').';1'); // On écrit à l'intérieur la date du jour et on met le nombre de tentatives à 1
                   fclose($creation_fichier); // On referme
               }
               // Si la date n'est plus a jour
               elseif($existence_ft == 2)
               {
                   fseek($fichier_tentatives, 0); // On remet le curseur au début du fichier
                   fputs($fichier_tentatives, date('d/m/Y').';1'); // On met à jour le contenu du fichier (date du jour;1 tentatives)
               }
               else
               {
				   
			   //*
			   // Si la variable $tentatives est sur le point de passer à 30, on en informe l'administrateur du site
                   if($tentatives == 10)
                   {
                     //$email_administrateur = 'stivisty@yahoo.fr';
 
                    $sujet = '['.$_SESSION['company_name'].'] Un compte membre a atteint son quota';
 
                    $message = 'Un des comptes a atteint le quota de mauvais mots de passe journalier :';
					$message .= stripslashes($data['pseudo']).' - '.$_SERVER['REMOTE_ADDR'].' - '.gethostbyaddr($_SERVER['REMOTE_ADDR']);
 
                       //@mail($email_administrateur, $sujet_notification, $message_notification);
					   
					   
	if(!empty($apps['staff_site'] AND $apps['email_password']))
	{
		$rep = mail_phpmailer($apps['staff_site'],$apps['email_password'],$adminname,$apps['staff_site'],$sujet,$message);	
	}
					   
					   
                   }
			   
			   //*/
			   
                   fseek($fichier_tentatives, 11); // On place le curseur juste devant le nombre de tentatives
                   fputs($fichier_tentatives, $tentatives + 1); // On ajoute 1 au nombre de tentatives
               }
			
			
			
				$error = '<font color="#CC0000">Username or password are wrong!</font>';   
			}
			else 
			{
					
				

              $_SESSION['admin_id'] 			= $data['id_admin'];
              $_SESSION['admin_nom'] 			= stripslashes($data['name']);
              $_SESSION['admin_username'] 		= stripslashes($data['username']);
              $_SESSION['admin_type'] 			= $data['type'];
              $_SESSION['admin_date_creation'] 	= $data['created'];
			  
			  //info site
			  //$_SESSION["site_name"] 			= $apps["name_site"];
			  
			header('Location: index.php'); 
			exit();

				
			}
		
      }
	  else
	  {
	    $error = '<font color="#CC0000">Username or password are wrong!</font>';  
	  }
	  
	} // fin tentatives depassées   
	else // S'il y a déjà eu 15 tentatives dans la journée, on affiche un message d'erreur
	{
	  $error ='<font color="#CC0000">Too many authentication attempts today</font>';
	}
	
	
   } // fin de isset $_post	
	
	else
	{
	  $error ='<font color="#CC0000">Please login!</font>';
	  
	}
	
  
  }

   include("header.php"); 
?>
	<div class="wrapper">
		<div class="container">
			<div class="row">
			
			
				<div class="module module-login span4 offset4">
		
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
				
					<form class="form-vertical" name="form1" action="" method="post">
						<div class="module-head">
							<h3>Sign In</h3>
						</div>
						<div class="module-body">
							<div class="control-group">
								<div class="controls row-fluid">
									<input class="span12" name="login" type="text" id="inputEmail" placeholder="Username">
								</div>
							</div>
							<div class="control-group">
								<div class="controls row-fluid">
									<input class="span12" name="password1" type="password" id="inputPassword" placeholder="Password">
								</div>
							</div>
						</div>
						<div class="module-foot">
							<div class="control-group">
								<div class="controls clearfix">
									<button type="submit" name="submit1" class="btn btn-primary pull-right">Login</button>
									<label class="checkbox">
									<!-- <input type="checkbox"> Remember me -->
									</label>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div><!--/.wrapper-->
	
<?php include("footer.php"); ?>	
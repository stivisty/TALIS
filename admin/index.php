<?php
$path='../';
//$path_pagination='../../';
$path_pagination=$path;
$rubrique='admin';
$page_name='List of admin';


include($path.'must.php');

//check if is super admin

if($_SESSION['admin_type'] != 'super')
{	
  header("location: ../index.php");
  exit(); 
}


// traitement

if(isset($_GET['typ_search']) AND isset($_GET['val_search']))
{
  $typ_search = $_GET['typ_search'];
  $val_search = $_GET['val_search'];
  
  $stmt_values = array();
  
   if($typ_search == 'username' AND !empty($val_search))
   {
     $sql_search = ' WHERE username Like :username ';
     
     $stmt_values['username'] = "%$val_search%";
   }
   else
   {
     $sql_search = '';
   }

}
else
{
  $typ_search = "";
  $val_search = "";
  $sql_search = '';

}


$page_retour='index.php';
$nom_item ='admin';


// par page

if(isset($_GET['nbrepge']))
{
  $nbrepge = $_GET['nbrepge'];
}
else
{
  $nbrepge = 10;
}


// requete

  $sql = 'SELECT *,DATE_FORMAT(created, "%d/%m/%Y") AS date1 FROM admin '.$sql_search;  

  
 
    if(isset($_GET['i']) OR isset($_GET['p'])) // pour les messages
	{
      if(isset($_GET['i']))
	  {
        $i =  addslashes($_GET['i']);
	  }
	  elseif(isset($_GET['p']))
	  {
	    $ac = addslashes($_GET['p']);
	  }
	  
	  $p = date('jmY');
	  
	  $crypt = md5($p);
	  
	  if(isset($_GET['i']) AND ($i == $crypt))
	  {
	  //$msg = '<font color="green">WebSite has been modified</font>';
	  
	  $msg = '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>'.$nom_item.' has been modified</b>
                                    </div>';
	  
	  }
	  elseif(isset($_GET['p']) AND ($ac == $crypt))
	  {
		//$msg = '<font color="green">WebSite has been added</font>';
		 $msg = '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>'.$nom_item.' has been added</b>
                                    </div>';
	  }
	  
   }
    else
   {	
   $msg='';
   }
   
   	  
	// pour la suppression
   if(isset($_GET['del']))
   {
	  $id_delete = addslashes($_GET['del']);
	  
	   if($id_delete == '')
	    {
			header('Location: '.$page_retour); // HOME PAGE
			exit();
		}
		 else
		{
			
			$stmt = $pdo->prepare('SELECT * FROM admin WHERE id_admin = :id ');
			
			$stmt->prepare(['id' => $id_delete]);
			
			$res = $stmt->fetchAll();
			
			if(count($res) == 0)
			{
			  header('Location: '.$page_retour); // HOME PAGE
			  exit();
			}
	
	        $stmt = $pdo->prepare("DELETE FROM admin WHERE id_admin=:id");
	        
	        $stmt->execute(['id' => $id_delete]);
	
	
	//$req_DES2 = mysql_query("DELETE FROM a_lookup WHERE site='$id_delete'") or die (mysql_error()); 		   
			   
			   
  //$msg = '<font color="green">Website has been deleted</font>';
  
   $msg = '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>'.$nom_item.' has been deleted</b>
                                    </div>';
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
								<h3><?php echo $page_name; ?></h3>
							</div>
							
							<div class="module-option clearfix">
                                    <div class="pull-left">
                                        <div class="btn-group">
                                        </div>
                                    </div>
                                    <div class="pull-right">
                                        <a href="admin.php" class="btn btn-primary">Add admin</a>
                                    </div>
                                </div>	
							
							<div class="module-body">
							
<div align="right">
		<form action="" method="get">
	 <table>
	    <tr>
		  <td> <label> Search:  </label> </td>
		  <td> 
		     <select name="typ_search" tabindex="1" data-placeholder="Selectionner ici.." class="span2">
			    <option value="username" <?php echo ($typ_search == "username")?'selected="selected" ':''; ?> > username </option>
			 </select>
			</td> 
			<td>
<input name="val_search" value="<?php echo $val_search ?>" type="text" placeholder="valeur…">
			</td>
			<td>
			  <input type="submit" value="OK" class="btn btn-primary">
			</td>
		</tr>
    </table>		
	  </form>
        </div>		
		
<br />							
								
<?php


    if(count($stmt_values) > 0){
        
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute($stmt_values);
        
    }
    else{
        
        $stmt = $pdo->query($sql);
    }
    
    $res = $stmt->fetchAll();
    
    $count =  count($res);
  
  if($count == 0)
   {
     echo '<strong>There is no '.$nom_item.'!</strong>';
   }
   
   else
   {
   
    if($nbrepge == 'all')
	{
	  $nbre1 = $count;
	}
	elseif(is_numeric($nbrepge) AND $nbrepge > 0)
	{
	  $nbre1 = $nbrepge;
	}
	else
	{
	  $nbre1 = 10;
	}
	
	
		   								// On met dans une variable le nombre de produit qu'on veut par page
								$nombreDeProduitParPage = $nbre1;
							
									// On récupère le nombre total de produit
									
									$totalDesProduits = $count;
									// On calcule le nombre de pages à créer
									$nombreDePages  = ceil($totalDesProduits / $nombreDeProduitParPage);
									
									
									if (isset($_GET['page']))
									{		
										$pag = $_GET['page']; // On récupère le numéro de la page indiqué dans l'adresse 
		
										if(is_numeric($pag) AND $pag > 0 AND $pag <= $nombreDePages) // on va vérifier si c'est un chiffre superieur à 0 !!!
											{
												$page = $_GET['page'];
											}
											elseif(is_numeric($pag) AND $pag > $nombreDePages)
											{
											   $page = $nombreDePages;
											}
											else //  c'est pas un chiffre on lui attribue la valeur 1
											{
												$page = 1;
											}
									}
									else // La variable n'existe pas, c'est la première fois qu'on charge la page
									{
												$page = 1; // On se met sur la page 1 (par défaut)
									}	
								   
								   
								   // On calcule le numéro du premier Produit qu'on prend pour le LIMIT de MySQL
									$premierProduitAafficher = ($page - 1) * $nombreDeProduitParPage;
									
$sql .= " ORDER BY id_admin DESC LIMIT $premierProduitAafficher,$nombreDeProduitParPage ";	

if(count($stmt_values) > 0){
    
    $stmt = $pdo->prepare($sql);
    
    $stmt->execute($stmt_values);
}
else{
    
    $stmt = $pdo->query($sql);
}

?>

<?php echo (!empty($msg))?$msg.'<br />':'';?>

		
<?php echo $count ?> admin(s) <br />


<div align="right">
	  <form action="" method="get">
	     <table>
	    <tr>
		  <td> <label> Per page:  </label> </td>
		  <td> 
		     <select name="nbrepge" tabindex="1" class="span1" id="nbre" onchange="perpage(this.value);">
			    <option value="10" <?php echo ($nbrepge == "10")?'selected="selected" ':''; ?> > 10 </option>
			    <option value="20" <?php echo ($nbrepge == "20")?'selected="selected" ':''; ?> > 20 </option>
			    <option value="50" <?php echo ($nbrepge == "50")?'selected="selected" ':''; ?> > 50 </option>
			    <option value="100" <?php echo ($nbrepge == "100")?'selected="selected" ':''; ?> > 100  </option>
			    <option value="all" <?php echo ($nbrepge == "all")?'selected="selected" ':''; ?> > Tout </option>
			 </select>
			</td>
		</tr>
    </table>
	  </form>
    </div>	
								
                                    <table class="table table-striped table-bordered table-condensed">
                                        <thead>
                                            <tr>
												<th>Name</th>
												<th>Username</th>
												<th>Type</th>
												<th>Created</th>
												<th>Creator</th>
												<th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										
<?php 
		  
    $resultat = $stmt->fetchAll();

	foreach($resultat as $solution) 
			{
		

			?>	
   <tr>
									  <td><?php echo stripslashes($solution['name']); ?></td>
						
									  <td><?php echo stripslashes($solution['username']); ?></td>
									  <td><?php echo $solution['type']; ?></td>
									  <td><?php echo stripslashes($solution['date1']); ?></td>
									  <td><?php echo $solution['creator']; ?></td>
									  <td>


<a href="<?php echo $page_retour; ?>?del=<?php echo $solution['id_admin']; ?>" onclick="return(confirm('Do you really want to delete it?'));" title="delete">
<img src="<?php echo $path ?>images/delete_icon.png" />
</a>

&nbsp;

<a href="admin.php?id=<?php echo $solution['id_admin']; ?>" title="Edit">
<img src="<?php echo $path; ?>images/i_edit.png" />
</a>
									  
									  </td>
									</tr>
     
			 <?php 
            }	
			?>	 

                                        </tbody>
                                    
                                    </table>
									
<!--  start paging..................................................... -->
	<div align="center">		
			<table>
			<tr>
			<td>
			
				<?php 
 
 $link = '?nbrepge='.$nbrepge.'&typ_search='.$typ_search.'&val_search='.$val_search.'&page=%d';
 
 echo '<p class="pagination">' . pagination($page,$nombreDePages,$link). '</p>';
 
?>	
			</td>
			<td>
			
			</td>
			</tr>
			</table>
		</div>	
			<!--  end paging................ -->
			
		<?php
     }
  ?>	 					
	

<script>

function perpage() {
    //document.forms.nbre.submit();
	var nbre = document.getElementById('nbre').value;
	var type = '<?php echo $typ_search;  ?>';
	var val = '<?php echo $val_search;  ?>';
	var url = '<?php echo $page_retour;  ?>';
	
	location.href=''+url+'?nbrepge='+nbre+'&typ_search='+type+'&val_search='+val;
  }
  
</script>										
									
							
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
<?php
$path='../';
//$path_pagination='../../';
$path_pagination=$path;
$rubrique='settings';
$page_name='List of countries';

include($path.'must.php');

// traitement

if(isset($_GET['typ_search']) AND isset($_GET['val_search']))
{
  $typ_search = $_GET['typ_search'];
  $val_search = $_GET['val_search'];
  
   if($typ_search == 'code' AND !empty($val_search))
   {
     $sql_search = ' WHERE code = "'.$conn->escape_string($val_search).'" ';
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


$page_retour='list_countries.php';
$nom_item ='country';


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

  $sql = 'SELECT * FROM a_pays '.$sql_search;  

  
 
        if(isset($_GET['i']) OR isset($_GET['p'])) // pour les messages
   {
      if(isset($_GET['i']))
	  {
        $i =  $conn->escape_string($_GET['i']);
	  }
	  elseif(isset($_GET['p']))
	  {
	    $ac = $conn->escape_string($_GET['p']);
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
	  $id_delete = $conn->escape_string($_GET['del']);
	  
	   if($id_delete == '')
	    {
			header('Location: '.$page_retour); // HOME PAGE
			exit();
		}
		 else
		{	
		
			$req_SUP = "SELECT * FROM a_pays WHERE rowid='$id_delete'";
			$res_SUP = $conn->query($req_SUP);
			
			if($res_SUP != false AND $res_SUP->num_rows == 0)
			{
			  header('Location: '.$page_retour); // HOME PAGE
			  exit();
			}
			
		
	$req_DES = $conn->query("DELETE FROM a_pays WHERE rowid='$id_delete'"); 		   
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
                                        <a href="country.php" class="btn btn-primary">Add Country</a>
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
			    <option value="code" <?php echo ($typ_search == "code")?'selected="selected" ':''; ?> > Country code </option>
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


   $req = $conn->query($sql);
  
  $count = $req->num_rows;
  
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
									
 $sql .= " ORDER BY rowid DESC LIMIT $premierProduitAafficher,$nombreDeProduitParPage ";								
									
$resultat = $conn->query($sql);


?>

<?php echo (!empty($msg))?$msg.'<br />':'';?>

		
<?php echo $count ?> countries <br />


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
												<th>Country</th>
												<th>Country code</th>
												<th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										
<?php 
		  

	 while ($solution = $resultat->fetch_assoc()) 
			{
		

			?>	
   <tr>
									  <td><?php echo $solution['en']; ?></td>
						
									  <td><?php echo $solution['code']; ?></td>
									  <td>


<a href="<?php echo $page_retour; ?>?del=<?php echo $solution['rowid']; ?>" onclick="return(confirm('Do you really want to delete it?'));" title="delete">
<img src="<?php echo $path ?>images/delete_icon.png" />
</a>

&nbsp;

<a href="country.php?id=<?php echo $solution['rowid']; ?>" title="Edit">
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
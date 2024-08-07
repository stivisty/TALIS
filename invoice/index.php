<?php
$path='../';
//$path_pagination='../../';
$path_pagination=$path;
$rubrique='invoice';
$page_name='List of invoices';

include($path.'must.php');

// traitement

if(isset($_GET['typ_search']) AND isset($_GET['val_search']))
{
  $typ_search = $_GET['typ_search'];
  $val_search = $_GET['val_search'];
  
  $stmt_values = array();
  
   if($typ_search == 'date' AND !empty($val_search))
   {
        $dateD      = $val_search;
        $arrD       = explode("/", $dateD);
	    $newdateD   = $arrD[2] . "-" . $arrD[1] . "-" . $arrD[0];
       
        $sql_search = ' WHERE DATE_FORMAT(created,"%Y-%m-%d") = :date ';
     
        $stmt_values['date'] = $newdateD;
   }
   elseif($typ_search == 'status' AND !empty($val_search)){
       
       if($val_search == 'Pending' OR $val_search == 'Sent'){
           
           $stat = ($val_search == 'Pending')?0:1;
           
            $sql_search = ' WHERE status = :status ';
     
            $stmt_values['status'] = $stat;
       }
       else{
           
           $sql_search = '';
       }
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
  $sql_search = ' ORDER BY id DESC';

}


$page_retour='index.php';
$nom_item ='Invoice';


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

  $sql = 'SELECT * FROM invoices '.$sql_search;  

  //echo $sql;
  //exit;

 
 
    if(isset($_GET['i']) OR isset($_GET['p'])) // pour les messages
   {
      if(isset($_GET['i']))
	  {
        $i =  $_GET['i'];
	  }
	  elseif(isset($_GET['p']))
	  {
	    $ac = $_GET['p'];
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
	  elseif(isset($_GET['error']) AND $_GET['error'] != ''){
	      
	       $msg = '<div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>'.$_GET['error'].'</b>
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
	  $id_delete = $_GET['del'];
	  
	   if($id_delete == '')
	    {
			header('Location: '.$page_retour); // HOME PAGE
			exit();
		}
		 else
		{	
		
			$req_SUP = "SELECT * FROM invoices WHERE id = :id";
			
			$stmt = $pdo->prepare($req_SUP);
			
			$stmt->execute(['id' => $id_delete]);
			
			$res = $stmt->fetchAll();
			
			if(count($res) == 0)
			{
			  header('Location: '.$page_retour); // HOME PAGE
			  exit();
			}
			
		
	$stmt = $pdo->prepare("DELETE FROM invoices WHERE id = :id ");
	
	$stmt->execute(['id' => $id_delete]);
	
  
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
                                        <a href="add_file.php" class="btn btn-primary">Add Invoice</a>
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
				 <option value="date" <?php echo ($typ_search == "date")?'selected="selected" ':''; ?> > Created (dd/mm/yyyy) </option>
				 <option value="status" <?php echo ($typ_search == "status")?'selected="selected" ':''; ?> > Status (Pending or Sent) </option>
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
  
  $count = count($res);
  
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
									
$sql .= " LIMIT $premierProduitAafficher,$nombreDeProduitParPage ";								


if(count($stmt_values) > 0){
    
    $stmt = $pdo->prepare($sql);
    
    $stmt->execute($stmt_values);
}
else{
    
    $stmt = $pdo->query($sql);
}


?>

<?php echo (!empty($msg))?$msg.'<br />':'';?>


<?php

if(isset($_SESSION['MSG']) AND $_SESSION['MSG'] != ''){
    
    echo '<div>'.$_SESSION['MSG'].'</div> <br>';
    
    $_SESSION['MSG'] = '';
    
    unset($_SESSION['MSG']);
}

?>
		
<?php echo $count; ?> invoices <br />


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
												<th>File</th>
												<th>Created</th>
												<th>Status</th>
												<th>Signature</th>
												<th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										
<?php 

    $resultat = $stmt->fetchAll();

	 foreach($resultat as $solution) 
	{
	    
	    $date = date("d/m/Y",strtotime($solution["created"]));
	    
	    if($solution['signature'] == 0){
	        
	        $status = '<font color="red"> Pending </font>';
	        
	        $action = '<span> <a href="send_file.php?id='.$solution['id'].'" onclick="return(confirm(\'Do you really want to send the invoice?\'));"> <i class="icon-upload-alt">Upload file</i> </a> &nbsp;
	                <a href="'. $page_retour.'?del='.$solution['id'].'" onclick="return(confirm(\'Do you really want to delete?\'));" title="Delete">
                    <img src="'.$path.'images/delete_icon.png" />Delete file</a> </span>';
	        
	        $signature = '-';
	    }
	    else{
	        
	        $status = '<font color="green"> Sent </font>';
	        
	        $action = '-';
	        
	        $signature = $solution['signature'];
	    }
	    
	    
	    $link = '<a href="view_file.php?id='.$solution['id'].'" target=_blank>'.$solution['file_name'].'</a>';
	    
	    //$link = $solution['file_name'];
	    

			?>	
   <tr>
									  <td><?php echo stripslashes($solution['item']); ?></td>
									  <td><?php echo $link; ?></td>
									  <td><?php echo $date; ?></td>
									  <td><?php echo $status; ?></td>
									  <td><?php echo $signature; ?></td>
									  <td><?php echo $action; ?></td>
									  
<!--
									 <td>
<a href="<?php //echo $page_retour; ?>?del=<?php //echo $solution['id']; ?>" onclick="return(confirm('Do you really want to delete?'));" title="Delete">
<img src="<?php //echo $path ?>images/delete_icon.png" />
</a>
&nbsp;

<a href="category.php?id=<?php //echo $solution['id']; ?>" title="Edit">
<img src="<?php //echo $path; ?>images/i_edit.png" />
</a>

-->
									  
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
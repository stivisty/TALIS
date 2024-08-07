<?php
session_start();

include($path."includes/connection_DB.php");
include($path."Pagination/pagination.php");
include($path."includes/functions.php"); 

  
 // on va verifier si il est en session
//* 
  if(!isset($_SESSION['admin_id']))
{
  header('Location: '.$path.'login.php'); 
  exit();
} 

//*/ 

  
?>
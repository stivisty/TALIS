<!DOCTYPE html>
<html lang="en">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $_SESSION["site_name"]; ?> | <?php echo $page_name; ?></title>
		<link rel="stylesheet" href="<?php echo $path_pagination; ?>Pagination/Css_pagination.css" />
        <link type="text/css" href="<?php echo $path; ?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link type="text/css" href="<?php echo $path; ?>bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link type="text/css" href="<?php echo $path; ?>css/theme.css" rel="stylesheet">
        <link type="text/css" href="<?php echo $path; ?>images/icons/css/font-awesome.css" rel="stylesheet">
     <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
	 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	 

	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
	  
$( "#datepicker" ).datepicker({ minDate: "-50Y", maxDate: "+5Y" , altField:"#datepicker", altFormat : "dd/mm/yy", dateFormat: "dd/mm/yy", changeYear : true }); 

$( "#datepicker2" ).datepicker({ minDate: 0, maxDate: "+1Y" , altField:"#datepicker2", altFormat : "dd/mm/yy", dateFormat: "dd/mm/yy" });
	
  } );
  </script>
	 
	 
	 <script src="<?php echo $path; ?>ckeditor/ckeditor.js"></script>
    </head>
    <body>
	
	<?php
	if(isset($_SESSION['admin_id']))
	{
	?>
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
                   <i class="icon-reorder shaded"></i></a><a class="brand" href="<?php echo $path; ?>index.php"> 
				    <!-- <img src="<?php echo $path_pagination; ?>/images/logo_mini2.jpg" alt="logo" /> -->
					<?php
			
					echo $_SESSION["site_name"];
	
					?>
				   </a>
                    <div class="nav-collapse collapse navbar-inverse-collapse">
                        <ul class="nav nav-icons">
							<!--
                            <li class="active"><a href="#"><i class="icon-envelope"></i></a></li>
                            <li><a href="#"><i class="icon-eye-open"></i></a></li>
                            <li><a href="#"><i class="icon-bar-chart"></i></a></li>
							-->
                        </ul>
                        
        <!--
           <form class="navbar-search pull-left input-append" method="get" action="<?php echo $path; ?>sales/index.php">
                   <input type="hidden" name="typ_search" value="ref" class="span3">
                   <input type="text" name="val_search" placeholder="put order reference" class="span3">
                   <button class="btn" type="submit">
                    <i class="icon-search"></i>
                   </button>
                   </form>
                   -->
                        <ul class="nav pull-right">
                            <!--
							<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown
                                <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Item No. 1</a></li>
                                    <li><a href="#">Don't Click</a></li>
                                    <li class="divider"></li>
                                    <li class="nav-header">Example Header</li>
                                    <li><a href="#">A Separated link</a></li>
                                </ul>
                            </li>
							-->
                            <li><a href="#"><?php echo $_SESSION['admin_username']; ?> </a></li>
                            <li class="nav-user dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="<?php echo $path; ?>images/user.png" class="nav-avatar" />
                                <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo $path; ?>admin/admin.php?id=<?php echo  $_SESSION['admin_id']; ?>">Edit Profile</a></li>
                                   <!-- <li><a href="#">Edit Profile</a></li> 
                                    <li><a href="#">Account Settings</a></li> -->
                                    <li class="divider"></li>
                                    <li><a href="<?php echo $path; ?>logout.php">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <!-- /.nav-collapse -->
                </div>
            </div>
            <!-- /navbar-inner -->
        </div>
		       <!-- /navbar -->
		
		<?php
		}
		else
		{
		?>
		<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
					<i class="icon-reorder shaded"></i>
				</a>

			  	<a class="brand" href="index.php">
			  		<!-- <img src="<?php echo $path_pagination; ?>/images/logo.png" alt="logo" /> -->
					
			<?php
			
				echo $_SESSION["site_name"];
	
			?>
					
			  	</a>

				<div class="nav-collapse collapse navbar-inverse-collapse">
				
					<ul class="nav pull-right">

						<li><a href="#">
						<!-- Sign Up -->
						</a></li>

						
						<!--
						<li><a href="#">
							Mot de passé oublié?
						</a></li>
						-->
					</ul>
				</div><!-- /.nav-collapse -->
			</div>
		</div><!-- /navbar-inner -->
	</div><!-- /navbar -->
   	
	<?php
	  }
	?>  
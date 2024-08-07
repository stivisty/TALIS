                    <div class="span3">
                        <div class="sidebar">    
                        
                        	<ul class="widget widget-menu unstyled"> 
							 <li>
							 <a href="<?php echo $path; ?>index.php">
							 <i class="menu-icon icon-inbox"></i>Dashboard</a>
							 </li>
							 </ul>

					 <ul class="widget widget-menu unstyled">
                                <li><a class="collapsed" data-toggle="collapse" href="#togglePages8"><i class="menu-icon icon-cog">
                                </i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right">
                                </i>Settings</a>
                                    <ul id="togglePages8" class="collapse unstyled">
                        <li><a href="<?php echo $path; ?>settings/index.php"><i class="icon-inbox"></i> Settings </a></li>
                        <!-- <li><a href="<?php echo $path; ?>settings/list_payment.php"><i class="icon-inbox"></i> Payment methods </a></li> 
                        <li><a href="<?php echo $path; ?>settings/list_countries.php"><i class="icon-inbox"></i> Countries </a></li>-->
                                    </ul>
                                </li>
                               
                            </ul>
							
					 <!--/.widget-nav-->	
						
                            
							 <ul class="widget widget-menu unstyled">
                                <li><a class="collapsed" data-toggle="collapse" href="#togglePages1"><i class="menu-icon icon-cog">
                                </i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right">
                                </i>Invoices</a>
                                    <ul id="togglePages1" class="collapse unstyled">
                     <li><a href="<?php echo $path; ?>invoice/index.php"><i class="icon-inbox"></i>List</a></li>
                     <li><a href="<?php echo $path; ?>invoice/add_file.php"><i class="icon-inbox"></i>Add Invoice</a></li>
                                    </ul>
                                </li>
                               
                            </ul>
							 
							<!--
							<ul class="widget widget-menu unstyled"> 
							 <li>
							 <a href="<?php //echo $path; ?>messages/sendmessage.php">
							 <i class="menu-icon icon-inbox"></i>Message </a>
							 </li>
							 </ul>
							 -->
                            <!--/.widget-nav-->
							
				<?php

					if($_SESSION['admin_type'] == 'super')
					{
						
					?>
							 
					   <ul class="widget widget-menu unstyled">
                                <li><a class="collapsed" data-toggle="collapse" href="#togglePages6"><i class="menu-icon icon-cog">
                                </i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right">
                                </i>Admin</a>
                                    <ul id="togglePages6" class="collapse unstyled">
                                        <li><a href="<?php echo $path; ?>admin/"><i class="icon-inbox"></i>Admin </a></li>
                                        <li><a href="<?php echo $path; ?>admin/admin.php"><i class="icon-inbox"></i>Add admin </a></li>
                                    </ul>
                                </li>
                               
                            </ul>
					
					<?php
					
					}
					
					?>
							
						 <!--/.widget-nav-->			
					  
					  </div>
                        <!--/.sidebar-->
                    </div>
                    <!--/.span3-->
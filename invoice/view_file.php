<?php
//ini_set('display_errors',1);
//error_reporting(E_ALL);
$path='../';
//$path_pagination='../../';
$path_pagination=$path;
$rubrique='invoice';

$page_name='View File';

include($path.'must.php');

include('settings.php');

$id = isset($_GET['id'])?$_GET['id']:'';

$stmt = $pdo->prepare('SELECT * FROM invoices WHERE id = :id');

$stmt->execute(['id'=>$id]);

$res = $stmt->fetchAll();

if(count($res) == 0){
    
    $error = 'Invoice not found ';
    
    header('Location: index.php?error='.$error);
    
    exit;
}
else{
    
    $data = $res[0];
    
    
include('extract_xml_file.php');


//echo '<pre>';
//print_r($invoice_obr);
//echo '</pre>';
//exit;




include($path.'header.php');

?>
  

        <div class="wrapper">
            <div class="container">
                <div class="row">

<?php include($path.'menu.php'); ?>				
				
                    <div class="span9">
                        <div class="content">
							<div class="module">
							<div class="module-head">
								<h3>
<?php
  echo $page_name;								
?>								
								</h3>
							</div>
							<div class="module-body">
							

<h3>Invoice sent to OBR </h3>

<form class="form-horizontal row-fluid" action=""  method="post"> 

<?php

foreach($invoice_obr as $key=>$value){
    
if(!is_array($value)){
?>
<div class="control-group">
<label class="control-label" for="basicinput"><?php echo $key; ?></label>
<div class="controls">
<input data-title="item" name="item" type="text" data-original-title="" class="span8 tip" value="<?php echo $value; ?>">
</div>
</div>

<?php

}
else{
    
 echo '<br> <h2> Items </h2>';
 
?>

<table class="table table-striped table-bordered table-condensed">
    <thead>
    <tr>
        <th>item_designation</th>
        <th>item_quantity</th>
        <th>item_price</th>
        <th>item_ct</th>
        <th>item_tl</th>
        <th>item_price_nvat</th>
        <th>vat</th>
        <th>item_price_wvat</th>
        <th>item_total_amount</th>
    </tr>
    </thead>
    
    <tbody>
    <?php
    
    foreach($value as $detail){
        
        echo '<tr>
            <td>'.$detail['item_designation'].'</td>
            <td>'.$detail['item_quantity'].'</td>
            <td>'.$detail['item_price'].'</td>
            <td>'.$detail['item_ct'].'</td>
            <td>'.$detail['item_tl'].'</td>
            <td>'.$detail['item_price_nvat'].'</td>
            <td>'.$detail['vat'].'</td>
            <td>'.$detail['item_price_wvat'].'</td>
            <td>'.$detail['item_total_amount'].'</td>
            </tr>';
    }
    
    ?>
    </tbody>
</table>

<?php

}

}

?>

<br>
 
<div class="control-group">
		<div class="controls">
			<a href="index.php" class="btn btn-inverse">Back</a> &nbsp; &nbsp;
		</div>
</div>

</form>
								
							
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

<?php

}

?>
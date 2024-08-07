<?php
//ini_set('display_errors',1);
//error_reporting(E_ALL);
$path='../';
//$path_pagination='../../';
$path_pagination=$path;
$rubrique='invoice';

$page_name='Send File';

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
    
    if($data['status'] == 1 AND $data['signature'] != ''){
        
        $error = 'Invoice ('.$data['item'].') has been sent to OBR';
        
        header('Location: index.php?error='.$error);
        
        exit;
    }
    
    
include('extract_xml_file.php');
 
 
$MSG = '';
    
/*
echo '<pre>';
print_r($invoice_obr);
echo '</pre>';
echo json_encode($invoice_obr);
exit;
//*/

$json_invoice_obr = json_encode($invoice_obr);

$dateNOW = date('d/m/Y H:i:s');

if(count($invoice_obr) == 0){
	
	$MSG .= '<font color="red"> OBR : invoice is null </font> <br>';
}
else{
	
// get the token

$token_obr =  json_decode(getToken_obr(),true);

file_put_contents(__DIR__.'/invoice_logs.txt',PHP_EOL.$dateNOW.': TOKEN : '.json_encode($token_obr).PHP_EOL,FILE_APPEND);

if(!$token_obr['success']){
	
	$MSG .= '<font color="red"> OBR : token not created ('.$token_obr['msg'].') </font> <br>';
	
}
else{

	$token = $token_obr['result']['token'];
	
	//echo 'Token result : '.json_encode($token_obr).' ----  token: '.$token_obr['result']['token'];
	//exit;
	
	
	// check if the invoice has been created on OBR side
	
	$getInvoice = json_decode(getInvoice_obr($invoice_obr['invoice_signature'],$token),true);
	
	file_put_contents(__DIR__.'/invoice_logs.txt',PHP_EOL.$dateNOW.': Get Invoice : '.json_encode($getInvoice).PHP_EOL,FILE_APPEND);

	if($getInvoice['success']){
	
	    $MSG .= '<font color="green"> OBR : Invoice already added ('.$getInvoice['result']['invoices'][0]['invoice_number'].') </font> <br>';
	
        // update the invoice field
    	
        $stmt = $pdo->prepare('UPDATE invoices SET status="1", signature = :signature WHERE id= :id ');
    	    
    	$stmt->execute(['signature' => $invoice_obr['invoice_signature'] , 'id' => $id ]);
	
	}
	else{
		
		// create the invoice 
		
		$addInvoice = json_decode(addInvoice_obr($json_invoice_obr,$token),true);
		
	    file_put_contents(__DIR__.'/invoice_logs.txt',PHP_EOL.$dateNOW.': ADD INVOICE : '.json_encode($addInvoice).PHP_EOL,FILE_APPEND);
		
		
		if($addInvoice['success']){
			
			$MSG .= '<font color="green"> OBR: Invoice has been added ('.html_entity_decode($addInvoice['msg']).' : '.$invoice_obr['invoice_number'].') - signature '.$invoice_obr['invoice_signature'].' </font> <br>';
			
	
    	    // update the invoice field
    	
    	    $stmt = $pdo->prepare('UPDATE invoices SET status="1", signature = :signature WHERE id= :id ');
    	    
    	    $stmt->execute(['signature' => $invoice_obr['invoice_signature'] , 'id' => $id ]);

		}
		else{
			
			$MSG .= '<font color="red"> OBR: Invoice has not been added ('.html_entity_decode($addInvoice['msg']).') - signature '.$invoice_obr['invoice_signature'].' </font> <br>';
		}
		
	}

}

	
}

file_put_contents(__DIR__.'/invoice_logs.txt',PHP_EOL.$dateNOW.": MSG: ".$MSG.' - signature: '.$invoice_obr['invoice_signature'].PHP_EOL." =========== ".PHP_EOL,FILE_APPEND);


$_SESSION['MSG'] = $MSG;

header('location: index.php');

exit;
    
    
    
}
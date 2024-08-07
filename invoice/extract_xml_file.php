<?php

 // try to extract data from xml file
    
    $file       = file_get_contents(__DIR__.'/files/'.$data['file_name']);
    
    $xml        = simplexml_load_string($file,'SimpleXMLElement',LIBXML_NOCDATA);
	
	$json       = json_encode($xml);
	
	$Invoice    = json_decode($json,true);
	
	$datInv     = $Invoice['BODY']['IMPORTDATA']['REQUESTDATA']['TALLYMESSAGE'][0]['VOUCHER'];
	
	$VAT		= 0;
	
	//echo '<pre>';
	//print_r($datInv);
	//echo '</pre>';
    //exit;

    $customer_data  = $datInv['BASICBUYERADDRESS.LIST']['BASICBUYERADDRESS'];
    $tab_tin        = explode(':',$customer_data[0]);
    $tab_assujeti   = explode(':', $customer_data[2]);
    $customer_assujeti = (trim($tab_assujeti['1']) == 'Non')?0:1;

    //echo '<br> customer TIN : '.$tab_tin[1];
    //echo '<br> customer address : '.$customer_data[1];
    //echo '<br> customer assujeti_tva : '.$customer_assujeti;
    //exit;
    
    /*
    foreach($datInv['ALLINVENTORYENTRIES.LIST'] as $detail)
	{
		$item_array = array();
		
		$actualqty  = $detail['ACTUALQTY'];
		$tab_qty    = explode(' ',trim($actualqty));
		$qty        = $tab_qty[0];
		
		$actualrate = $detail['RATE'];
		$tab_rate   = explode('/',trim($actualrate));
		$rate       = $tab_rate[0];
	
	
		$service_tva= ($rate * $VAT)/100;

		$price_wvat = $rate + $service_tva;
		
		$item_array['item_designation'] = $detail['STOCKITEMNAME'];
		$item_array['item_quantity'] 	= $qty;
		$item_array['item_price'] 		= $rate;
		$item_array['item_ct'] 			= "0"; //taxe de consommation
		$item_array['item_tl'] 			= "0"; //prelevement forfaitaire liberatoire
		$item_array['item_price_nvat'] 	= $rate; //prix HTVA
		$item_array['vat'] 				= $service_tva; //prix HTVA
		$item_array['item_price_wvat'] 	= $price_wvat; //prix avec TVA
		$item_array['item_total_amount']= $detail['AMOUNT']; //prix avec TVA
		
		$invoice_obr['invoice_items'][] = $item_array;
	}
	
	echo '<pre>';
	print_r($invoice_obr);
	echo '</pre>';
	exit;
	*/
	
	
	//$inv_status = 'FN';
	$inv_status = 'FP';
	//$inv_status = 'FT';

	//obr_details 
	
	$date_obr	= date('Y-m-d H:i:s');
	$date_sig 	= date('YmdHis');
	
	$invoice_obr['invoice_id']			= $datInv['GUID'];
	$invoice_obr['invoice_number']		= $datInv['VOUCHERNUMBER'];
	$invoice_obr['invoice_date'] 		= $date_obr;
	$invoice_obr['tp_type'] 			= "2"; // contribuable 1 personne physique ou 2 personne morale 
	$invoice_obr['tp_name'] 			= "AFRIREGISTER"; //CHIMIO
	$invoice_obr['tp_TIN'] 				= "4000061905"; // NIF OF CHIMIO
	$invoice_obr['tp_trade_number'] 	= "400"; // registre du commerce
	$invoice_obr['tp_postal_number'] 	= "";
	$invoice_obr['tp_phone_number'] 	= "22258363";
	$invoice_obr['tp_address_commune'] 	= "Mukaza";
	$invoice_obr['tp_address_quartier'] = "Rohero 1";
	$invoice_obr['tp_address_avenue'] 	= "Chaussee Prince Louis Rwagasore";
	$invoice_obr['tp_address_number'] 	= "";
	$invoice_obr['vat_taxpayer'] 		= "0";  // assujeti a la tva (0 no , 1 yes) 
	$invoice_obr['ct_taxpayer'] 		= "0"; // assujeti a la taxe de consommation (0 no , 1 yes) 
	$invoice_obr['tl_taxpayer'] 		= "0"; // assujeti au prelevement forfaitaire liberatoire (0 no , 1 yes) 
	$invoice_obr['tp_fiscal_center'] 	= "DGC";
	$invoice_obr['tp_activity_sector'] 	= "SERVICE MARCHAND";
	$invoice_obr['tp_legal_form'] 		= "SA"; // forme juridique du contribuable
	$invoice_obr['payment_type'] 		= "1"; // 1,2,3,4
	$invoice_obr['customer_name'] 		= $datInv['PARTYNAME'];
	$invoice_obr['customer_TIN'] 		= $tab_tin[1]; // PUT THE CUSTOMER TIN
	$invoice_obr['customer_address'] 	= $customer_data[1]; 
	$invoice_obr['vat_customer_payer'] 	= $customer_assujeti; // client assujeti a la tva
	$invoice_obr['invoice_type'] 		= $inv_status; // FTP : facture proforma, FT: facture de test , FN: facture normale
	$invoice_obr['cancelled_invoice_ref'] = "";
	$invoice_obr['invoice_signature'] 	= "4000061905/".$NIS_obr."/".$date_sig."/".$invoice_obr['invoice_number']; // NIF/NumeroIdentificationSysteme/date/facture
	$invoice_obr['invoice_signature_date'] = $date_obr;
	
	
	//Details
	
	if($datInv['ALLINVENTORYENTRIES.LIST']['STOCKITEMNAME']){
	    
	        $item_array = array();
    		
    		$actualqty  = $datInv['ALLINVENTORYENTRIES.LIST']['ACTUALQTY'];
    		$tab_qty    = explode(' ',trim($actualqty));
    		$qty        = $tab_qty[0];
    		
    		$actualrate = $datInv['ALLINVENTORYENTRIES.LIST']['RATE'];
    		$tab_rate   = explode('/',trim($actualrate));
    		$rate       = $tab_rate[0];
    	
    	
    		$service_tva= ($rate * $VAT)/100;
    
    		$price_wvat = $rate + $service_tva;
    		
    		$item_array['item_designation'] = $datInv['ALLINVENTORYENTRIES.LIST']['STOCKITEMNAME'];
    		$item_array['item_quantity'] 	= $qty;
    		$item_array['item_price'] 		= $rate;
    		$item_array['item_ct'] 			= "0"; //taxe de consommation
    		$item_array['item_tl'] 			= "0"; //prelevement forfaitaire liberatoire
    		$item_array['item_price_nvat'] 	= $rate; //prix HTVA
    		$item_array['vat'] 				= $service_tva; //prix HTVA
    		$item_array['item_price_wvat'] 	= $price_wvat; //prix avec TVA
    		$item_array['item_total_amount']= $datInv['ALLINVENTORYENTRIES.LIST']['AMOUNT']; //prix avec TVA
    		
    		$invoice_obr['invoice_items'][] = $item_array;
	}
	else{
	
        foreach($datInv['ALLINVENTORYENTRIES.LIST'] as $detail)
    	{
    		$item_array = array();
    		
    		$actualqty  = $detail['ACTUALQTY'];
    		$tab_qty    = explode(' ',trim($actualqty));
    		$qty        = $tab_qty[0];
    		
    		$actualrate = $detail['RATE'];
    		$tab_rate   = explode('/',trim($actualrate));
    		$rate       = $tab_rate[0];
    	
    	
    		$service_tva= ($rate * $VAT)/100;
    
    		$price_wvat = $rate + $service_tva;
    		
    		$item_array['item_designation'] = $detail['STOCKITEMNAME'];
    		$item_array['item_quantity'] 	= $qty;
    		$item_array['item_price'] 		= $rate;
    		$item_array['item_ct'] 			= "0"; //taxe de consommation
    		$item_array['item_tl'] 			= "0"; //prelevement forfaitaire liberatoire
    		$item_array['item_price_nvat'] 	= $rate; //prix HTVA
    		$item_array['vat'] 				= $service_tva; //prix HTVA
    		$item_array['item_price_wvat'] 	= $price_wvat; //prix avec TVA
    		$item_array['item_total_amount']= $detail['AMOUNT']; //prix avec TVA
    		
    		$invoice_obr['invoice_items'][] = $item_array;
    	}
    
	}

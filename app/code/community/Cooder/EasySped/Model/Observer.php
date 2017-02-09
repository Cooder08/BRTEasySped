<?php
/**
 * EasySped Observer write csv with shipping information automatically, 
 * when admin user click and confirm a shipping.
 * 
 * @author Cooder www.cooder.it
 * @copyright Copyright (c) 2014, Cooder
 * @license http://shop.cooder.it/index.php/license: this module is protected by cooder copyright
 * if not possible to send to other, without cooder permission.
 * @package Cooder_EasySped BRT Bridge
 * @version 3.0.2 stable
 */
class Cooder_EasySped_Model_Observer
{
	function writeShipping($observer){
	    // Se modo utilizzo= Spedizione
        //$storeId = Mage::app()->getStore()->getStoreId();
        $shipment = $observer->getEvent()->getShipment();
        $order = $shipment->getOrder();
		$storeId = $order->getStoreId();
		
		if(Mage::getStoreConfig('cooder/easysped/enable',$storeId) && Mage::getStoreConfig('cooder/easysped/usemode') == 1){
			
			if($shipment->getCreatedAt() == $shipment->getUpdatedAt()){
				
				$shipping = $order->getShippingAddress();
				$billing = $order->getBillingAddress();
				
				//$flag++;
				$vabrmn = $order->getId();				
				$vabccm = Mage::getStoreConfig('cooder/easysped/vabccm');
				$vablnp = Mage::getStoreConfig('cooder/easysped/vablnp');
				/* Version 3.0 */
				if(Mage::getStoreConfig('cooder/easysped/valuta',$storeId) != ""){
					$vabvas = Mage::getStoreConfig('cooder/easysped/valuta',$storeId);
				}else{
					$vabvas = 'EUR';
				}
				$vabvca = $vabvas;
				/**/
				$vabant = "";
				
				if(Mage::getStoreConfig('cooder/easysped/vabctr')){
					$vabctr = 300;
				}else{
					$vabctr = 0;
				}
				
				$vabcbo = 1;
				$vabcas = "";
				$vabvca = "";
				
				if (strstr($order->getPayment()->getMethodInstance()->getCode(),Mage::getStoreConfig('cooder/easysped/contrassegno', $storeId))){
					$vabcbo = 4;
					$vabcas = number_format($order->getGrandTotal(), 2, ",", "");	
				}
				
				$vabaas = date("Y",strtotime($shipment->getCreatedAt()));
				
				$array_month = array("Jan" => '01', "Feb" => '02', "Mar" => '03', "Apr" => '04', "May" => '05', "Jun" => '06', "Jul" => '07', "Aug" => '08', "Sep" => '09', "Oct" => '10', "Nov" => '11', "Dec" => '12');
				$vabmgs = $array_month[date("M",strtotime($shipment->getCreatedAt()))].date("d",strtotime($shipment->getCreatedAt()));
				
				$customer = Mage::getModel('customer/customer')->load($order->getData('customer_id'));
				$vabrsd = Mage::helper('easysped')->getRagioneSociale($shipping);
				$vabind = $shipping->getData("street"); 
				$vabcad = $shipping->getPostcode();
				$vablod = $shipping->getCity();
				$vabprd = $shipping->getRegionCode();
				
				switch ($shipping->getCountry()) {
		                case "IT":
		                    $vabnzd = "";
				    if(Mage::getStoreConfig('cooder/easysped/vabctr')){
					$vabctr = 301;
					}
		                    break;
		                case "AT":
		                    $vabnzd = "A";
		                    break;
		                case "AD":
		                    $vabnzd = "AND";
		                    break;
		                case "BE":
		                    $vabnzd = "B";
		                    break;
		                case "BG":
		                    $vabnzd = "BG";
		                    break;
		                case "CH":
		                    $vabnzd = "CH";
		                    break;
		                case "CZ":
		                    $vabnzd = "CZ";
		                    break;
		                case "DE":
		                    $vabnzd = "D";
		                    break;
		                case "DK":
		                    $vabnzd = "DK";
		                    break;
		                case "ES":
		                    $vabnzd = "E";
		                    break;
		                case "FR":
		                    $vabnzd = "F";
		                    break;
		                case "GB":
		                    $vabnzd = "GB";
		                    break;
		                case "GI":
		                    $vabnzd = "GBZ";
		                    break;
		                case "HU":
		                    $vabnzd = "HU";
		                    break;
		                case "IE":
		                    $vabnzd = "IRL";
		                    break;
		                case "LU":
		                    $vabnzd = "L";
		                    break;
		                case "LI":
		                    $vabnzd = "LI";
		                    break;
		                case "MC":
		                    $vabnzd = "MC";
		                    break;
		                case "NL":
		                    $vabnzd = "NL";
		                    break;
		                case "PT":
		                    $vabnzd = "P";
		                    break;
		                case "PL":
		                    $vabnzd = "PL";
		                    break;
		                case "RO":
		                    $vabnzd = "RO";
		                    break;
		                case "SE":
		                    $vabnzd = "S";
		                    break;
		                case "SK":
		                    $vabnzd = "SK";
		                    break;
		                case "SI":
		                    $vabnzd = "SLO";
		                    break;
		                default:
		                    $vabnzd = $shipping->getCountry();
		            }
				
				$vabncl = 1;
				$vabpkb = 0;
				if(Mage::getStoreConfig('cooder/easysped/vabpkb', $storeId) > 0){
					$vabpkb = Mage::getStoreConfig('cooder/easysped/vabpkb', $storeId);
				}else{
					foreach($order->getAllItems() as $item){
						$product = Mage::getModel('catalog/product')->load($item->getProductId());
						if($product->getTypeId() != 'configurable'){
							$vabpkb = $vabpkb + ($product->getWeight() * $item->getQtyOrdered());
						}
					}
				}
				$vabvlb = 0;
				if(Mage::getStoreConfig('cooder/easysped/vabvlb',$storeId) != ""){
					$vabvlb = Mage::getStoreConfig('cooder/easysped/vabvlb',$storeId);
				}
				
				$vabnrc = $shipping->getName();
				$vabtrc = str_replace(" ", "", $billing->getTelephone());
				$vabtic = "";
				if($customer->getEmail() != ""){
					$vabemd = $customer->getEmail();
				}else{
					$vabemd = $order->getCustomerEmail();
				}
				$vabrma = $order->getRealOrderId();
				
				/* Version 3.0 */
				if(Mage::getStoreConfig('cooder/easysped/tipemode') == 1){
					if($shipping->getTelephone()){
						$vabcel = str_replace(" ", "", $shipping->getTelephone());
					}else{
						$vabcel = $vabtrc;
					}
					$vabtsp = Mage::getStoreConfig('cooder/easysped/vabtsp'); // tipo di servizio E = espresso C = comune
					$vabias = 0; // valore assicurazione
					if(Mage::getStoreConfig('cooder/easysped/vabffd',$storeId)){
						$vabffd = 'S';
					}else{
						$vabffd = '';
					}
					if(Mage::getStoreConfig('cooder/easysped/vabtc1',$storeId)){
						$vabtc1 = 'A';
					}else{
						$vabtc1 = '';
					}
					if(Mage::getStoreConfig('cooder/easysped/vabias',$storeId) == $order->getShippingDescription()){
						$vabias = number_format($order->getSubtotal(), 2, ",", "");
					}
					
					$vabnot = "";
					$vabnt2 = "";
					$vabtno = Mage::getStoreConfig('cooder/easysped/vabtno');
					$csv_array[0] = array($vabccm, $vabctr, $vabcbo, substr($vabrsd, 0, 35), substr($vabrsd, 35, 35), substr($vabind, 0, 35), $vabcad, substr($vablod, 0, 35), substr($vabprd, 0, 2), $vabnzd, $vabnrc, $vabtrc, $vabemd, $vabtsp, $vabias, $vabvas, $vabncl, $vabpkb, $vabvlb, $vabcas, $vabtic, $vabvca, $vabrmn, $vabnot, $vabnt2, $vabffd, $vabtc1, $vabcel, $vabtno /*, $vabrma*/);
				  
				  	if(Mage::getStoreConfig('cooder/easysped/tracking', $storeId)){
				  		$csv_array[0][] = $vabrma;
						if($order->canShip())
						{
							$itemQty =  $order->getItemsCollection()->count();
							$shipment = Mage::getModel('sales/service_order', $order)->prepareShipment($itemQty);
							$shipment = new Mage_Sales_Model_Order_Shipment_Api();
							$shipmentId = $shipment->create($order->getIncrementId());
						
							$shipment->addTrack($shipmentId, $order->getShippingMethod(), $order->getShippingDescription(), $order->getIncrementId());
							$shipment->addComment('shipment_comment', true, true);
						}
					}
					/* if(Mage::getStoreConfig('cooder/easysped/tracking', $storeId)){
						$csv_array[0][] = $vabrma;
						
						//$shipmentId = Mage::getModel('sales/order_shipment_api')->create($order->getIncrementId(), $csv_array[0] ,'shipment_comment' ,false,1);
						//$trackmodel = Mage::getModel('sales/order_shipment_api')->addTrack($shipmentId,$order->getShippingMethod(),$order->getShippingDescription(),$order->getIncrementId());
						
					} */
				
				}else{
					$csv_array[0] = array("",$vabccm, $vablnp, $vabctr, $vabcbo, $vabaas, $vabmgs, $vabrmn, substr($vabrsd, 0, 35), substr($vabind, 0, 35), substr($vablod, 0, 35), $vabcad, substr($vabprd, 0, 2), $vabnzd, $vabncl, $vabpkb, $vabcas, $vabvca, substr($vabind, 35, 35), substr($vabind, 70, 35), substr($vabnrc, 0, 35), substr($vabtrc, 0, 16), $vabtic, substr($vabemd, 0, 70), $vabrma);
				}	
				$csv = Mage::getModel('easysped/csv');
				$csv->writeCsv($csv_array);
				$comment = "Ordine ".$order->getRealOrderId()." scritto nel file CSV EasySped, attraverso creazione spedizione, in data: ".$shipment->getCreatedAt();
				$order->addStatusHistoryComment($comment)->save(); 		
			}	
		}
	}

	function writeShippingFromInvoice($observer){
            //$storeId = Mage::app()->getStore()->getStoreId();
			$invoice = $observer->getEvent()->getInvoice();
			$order = $invoice->getOrder();
			$storeId = $order->getStoreId();
		if(Mage::getStoreConfig('cooder/easysped/enable',$storeId) && Mage::getStoreConfig('cooder/easysped/usemode') == 0){
			$flag = 0;	
			$shipping = $order->getShippingAddress();
			$billing = $order->getBillingAddress();
			$flag++;
			$vabrmn = $order->getId();				
			$vabccm = Mage::getStoreConfig('cooder/easysped/vabccm');
			$vablnp = Mage::getStoreConfig('cooder/easysped/vablnp');
			
			/* Version 3.0 */
			if(Mage::getStoreConfig('cooder/easysped/valuta',$storeId) != ""){
				$vabvas = Mage::getStoreConfig('cooder/easysped/valuta',$storeId);
			}else{
				$vabvas = 'EUR';
			}
			$vabvca = $vabvas;
			/**/
			
			$vabant = "";
			
			if(Mage::getStoreConfig('cooder/easysped/vabctr')){
				$vabctr = 300;
			}else{
				$vabctr = 0;
			}
			
			$vabcbo = 1;
			$vabcas = "";
			$vabvca = "";
			
			if (strstr($order->getPayment()->getMethodInstance()->getCode(),Mage::getStoreConfig('cooder/easysped/contrassegno', $storeId))){
				$vabcbo = 4;
				$vabcas = number_format($order->getGrandTotal(), 2, ",", "");	
			}
			
			$vabaas = date("Y",strtotime($invoice->getCreatedAt()));
			
			$array_month = array("Jan" => '01', "Feb" => '02', "Mar" => '03', "Apr" => '04', "May" => '05', "Jun" => '06', "Jul" => '07', "Aug" => '08', "Sep" => '09', "Oct" => '10', "Nov" => '11', "Dec" => '12');
			$vabmgs = $array_month[date("M",strtotime($invoice->getCreatedAt()))].date("d",strtotime($invoice->getCreatedAt()));
			
			$customer = Mage::getModel('customer/customer')->load($order->getData('customer_id'));
			$vabrsd = Mage::helper('easysped')->getRagioneSociale($shipping);
			$vabind = $shipping->getData("street"); 
			$vabcad = $shipping->getPostcode();
			$vablod = $shipping->getCity();;
			$vabprd = $shipping->getRegionCode();
			
			switch ($shipping->getCountry()) {
	                case "IT":
	                    $vabnzd = "";
			    if(Mage::getStoreConfig('cooder/easysped/vabctr')){
				$vabctr = 301;
				}
	                    break;
	                case "AT":
	                    $vabnzd = "A";
	                    break;
	                case "AD":
	                    $vabnzd = "AND";
	                    break;
	                case "BE":
	                    $vabnzd = "B";
	                    break;
	                case "BG":
	                    $vabnzd = "BG";
	                    break;
	                case "CH":
	                    $vabnzd = "CH";
	                    break;
	                case "CZ":
	                    $vabnzd = "CZ";
	                    break;
	                case "DE":
	                    $vabnzd = "D";
	                    break;
	                case "DK":
	                    $vabnzd = "DK";
	                    break;
	                case "ES":
	                    $vabnzd = "E";
	                    break;
	                case "FR":
	                    $vabnzd = "F";
	                    break;
	                case "GB":
	                    $vabnzd = "GB";
	                    break;
	                case "GI":
	                    $vabnzd = "GBZ";
	                    break;
	                case "HU":
	                    $vabnzd = "HU";
	                    break;
	                case "IE":
	                    $vabnzd = "IRL";
	                    break;
	                case "LU":
	                    $vabnzd = "L";
	                    break;
	                case "LI":
	                    $vabnzd = "LI";
	                    break;
	                case "MC":
	                    $vabnzd = "MC";
	                    break;
	                case "NL":
	                    $vabnzd = "NL";
	                    break;
	                case "PT":
	                    $vabnzd = "P";
	                    break;
	                case "PL":
	                    $vabnzd = "PL";
	                    break;
	                case "RO":
	                    $vabnzd = "RO";
	                    break;
	                case "SE":
	                    $vabnzd = "S";
	                    break;
	                case "SK":
	                    $vabnzd = "SK";
	                    break;
	                case "SI":
	                    $vabnzd = "SLO";
	                    break;
	                default:
	                    $vabnzd = $shipping->getCountry();
	            }
			
			$vabncl = 1;
			
			if(Mage::getStoreConfig('cooder/easysped/vabpkb', $storeId) > 0){
				$vabpkb = Mage::getStoreConfig('cooder/easysped/vabpkb', $storeId);
			}else{
				foreach($order->getAllItems() as $item){
					$product = Mage::getModel('catalog/product')->load($item->getProductId());
					if($product->getTypeId() != 'configurable'){
						$vabpkb = $vabpkb + ($product->getWeight() * $item->getQtyOrdered());
					}
				}
			}
			if(Mage::getStoreConfig('cooder/easysped/vabvlb',$storeId) != ""){
				$vabvlb = Mage::getStoreConfig('cooder/easysped/vabvlb',$storeId);
			}
			
			$vabnrc = $shipping->getName();
			$vabtrc = str_replace(" ", "", $shipping->getTelephone());
			$vabtic = "";
			if($customer->getEmail() != ""){
				$vabemd = $customer->getEmail();
			}else{
				$vabemd = $order->getCustomerEmail();
			}
			$vabrma = $order->getRealOrderId();
			if(Mage::getStoreConfig('cooder/easysped/tipemode') == 1){
				if($shipping->getTelephone()){
					$vabcel = str_replace(" ", "", $shipping->getTelephone());
				}else{
					$vabcel = $vabtrc;
				}
				$vabtsp = Mage::getStoreConfig('cooder/easysped/vabtsp'); // tipo di servizio E = espresso C = comune
				$vabias = 0; // valore assicurazione
				if(Mage::getStoreConfig('cooder/easysped/vabffd',$storeId)){
					$vabffd = 'S';
				}else{
					$vabffd = '';
				}
				if(Mage::getStoreConfig('cooder/easysped/vabtc1',$storeId)){
					$vabtc1 = 'A';
				}else{
					$vabtc1 = '';
				}
				if(Mage::getStoreConfig('cooder/easysped/vabias',$storeId) == $order->getShippingDescription()){
					$vabias = number_format($order->getSubtotal(), 2, ",", "");
				}
				
				$vabnot = "";
				$vabnt2 = "";
				$vabtno = Mage::getStoreConfig('cooder/easysped/vabtno');
				$csv_array[0] = array($vabccm, $vabctr, $vabcbo, substr($vabrsd, 0, 35), substr($vabrsd, 35, 35), substr($vabind, 0, 35), $vabcad, substr($vablod, 0, 35), substr($vabprd, 0, 2), $vabnzd, $vabnrc, $vabtrc, $vabemd, $vabtsp, $vabias, $vabvas, $vabncl, $vabpkb, $vabvlb, $vabcas, $vabtic, $vabvca, $vabrmn, $vabnot, $vabnt2, $vabffd, $vabtc1, $vabcel, $vabtno, $vabrma);
			}else{
				$csv_array[0] = array("",$vabccm, $vablnp, $vabctr, $vabcbo, $vabaas, $vabmgs, $vabrmn, substr($vabrsd, 0, 35), substr($vabind, 0, 35), substr($vablod, 0, 35), $vabcad, substr($vabprd, 0, 2), $vabnzd, $vabncl, number_format($vabpkb,1,',',''), $vabcas, $vabvca, substr($vabind, 35, 35), substr($vabind, 70, 35), substr($vabnrc, 0, 35), substr($vabtrc, 0, 16), $vabtic, substr($vabemd, 0, 70), $vabrma);
			}	
			$csv = Mage::getModel('easysped/csv');
			$csv->writeCsv($csv_array);
			$comment = "Ordine ".$order->getRealOrderId()." scritto nel file CSV EasySped, attraverso creazione fattura, in data: ".$invoice->getCreatedAt();
			$order->addStatusHistoryComment($comment)->save(); 
			
		}	
	}
	
	public function addMassAction($observer)
        {
            $storeId = Mage::app()->getStore()->getStoreId();
            if(Mage::getStoreConfig('cooder/easysped/enable',$storeId) && Mage::getStoreConfig('cooder/easysped/usemode') == 2){
	        $block = $observer->getEvent()->getBlock();
	        if(get_class($block) =='Mage_Adminhtml_Block_Widget_Grid_Massaction'
	            && $block->getRequest()->getControllerName() == 'sales_order')
	        {
	            $block->addItem('newmodule', array(
	                'label' => 'Export Ordini BRT',
	                'url' => Mage::app()->getStore()->getUrl('easysped/adminhtml_index/mass'),
	            ));
	        }
		}
        }
	
	public function salesOrderShipmentSaveBefore($observer) 
	{
		try {
            //$storeId = Mage::app()->getStore()->getStoreId();
			$shipment = $observer->getEvent()->getShipment();
			$order = $shipment->getOrder();
			$storeId = $order->getStoreId();
            
            if(Mage::getStoreConfig('cooder/easysped/tracking',$storeId))
			{
		   		// Mage::log("enter shipping tracking number ",null,'easysped_traking.log');
            	//$order =$observer->getEvent()->getOrder();
            	$track = Mage::getModel('sales/order_shipment_track')
                        ->setNumber($order->getIncrementId()) //tracking number / awb number
                       // ->setCarrierCode('easysped') //carrier code
                        ->setTitle('BRT'); //carrier title
                     //Mage::log("track ".$track,null,'easysped_traking.log');
            	$shipment->addTrack($track);
			}
		}catch (Exception $e) {
        	Mage::log('salesOrderShipmentSaveBefore: '.$e);
      	}	
	}

}
?>
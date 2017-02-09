<?php
class Cooder_EasySped_Helper_Data extends Mage_Core_Helper_Abstract
{
	
	/* public function getRagioneSociale($address) {
    if($address->getCompany()) {
        return $address->getCompany();
    }

    	return $address->getName();
	}*/
    
    
    public function getRagioneSociale($address) {
    if($address->getCompany()) {
        return $address->getCompany()."-".$address->getName();
    }

        return $address->getName();
    } 
	
	
}
?>
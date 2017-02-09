<?php
/**
 * EasySped Block add button to shipping table on sub-menu
 * Sales. This button provide to send an email, with csv attached, to config mail
 * module address manually.
 * 
 * @author Cooder www.cooder.it
 * @copyright Copyright (c) 2014, Cooder
 * @license http://shop.cooder.it/index.php/license: this module is protected by cooder copyright
 * if not possible to send to other, without cooder permission.
 * @package Cooder_EasySped BRT Bridge
 * @version 3.0.0 stable
 */
class Cooder_EasySped_Block_Adminhtml_Sales_Shipment extends Mage_Adminhtml_Block_Sales_Shipment
{

    public function __construct()
    {
    	Mage::log(Mage::getStoreConfig('cooder/easysped/enable'));
    	
        $this->_controller = 'sales_shipment';
        $this->_headerText = Mage::helper('sales')->__('Shipments');
        parent::__construct();
        $this->_removeButton('add');
		if(Mage::getStoreConfig('cooder/easysped/enable')){
		$this->_addButton('easysped_email', array(
	            'label'     => Mage::helper('core')->__('Invia Easysped Email'),
	            'onclick'   => "location.href='".Mage::helper('adminhtml')->getUrl("easysped/adminhtml_index/sendmail")."'",
	            'class'     => 'go'
	        ), 0, 100, 'header', 'header');
		}
    }

}

<?php
/**
 * EasySped Block add button to order view on sub-menu
 * Sales. This button provide to write a row in csv attached.
 * module address manually.
 * 
 * @author Cooder www.cooder.it
 * @copyright Copyright (c) 2014, Cooder
 * @license http://shop.cooder.it/index.php/license: this module is protected by cooder copyright
 * if not possible to send to other, without cooder permission.
 * @package Cooder_EasySped BRT Bridge
 * @version 3.0.0 stable
 */
class Cooder_EasySped_Block_Adminhtml_Sales_Order_View extends Mage_Adminhtml_Block_Sales_Order_View
{

    public function __construct()
    {
    	$this->_controller = 'sales_order';
        $this->_headerText = Mage::helper('sales')->__('Order');
        parent::__construct();
		$order = $this->getOrder();
        $this->_removeButton('add');
		if(Mage::getStoreConfig('cooder/easysped/enable') && Mage::getStoreConfig('cooder/easysped/usemode') == 2){
		$this->_addButton('easysped_order', array(
	            'label'     => Mage::helper('core')->__('BRT Row'),
	            'onclick'   => "location.href='".Mage::helper('adminhtml')->getUrl("easysped/adminhtml_index/manual/order_id/".$order->getId())."'",
	            'class'     => 'go'
	        ), 0, 100, 'header', 'header');
		}
    }

}

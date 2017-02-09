<?php
/**
 * EasySped Controller.
 * 
 * @author Cooder www.cooder.it
 * @copyright Copyright (c) 2014, Cooder
 * @license http://shop.cooder.it/index.php/license: this module is protected by cooder copyright
 * if not possible to send to other, without cooder permission.
 * @package Cooder_EasySped BRT Bridge
 * @version 3.0.0 stable
 */
class Cooder_EasySped_Adminhtml_IndexController extends Mage_Adminhtml_Controller_Action
{
	
	function sendmailAction(){
		Mage::getModel("easysped/mail")->sendReport();
		$this->_redirect('adminhtml/sales_shipment');
	}
	
	function manualAction(){
		$order_id = $this->getRequest()->getParam('order_id');
		$key = $this->getRequest()->getParam('key');
		Mage::getModel("easysped/manual")->writeShippingFromButton($order_id);
		$this->_redirect('adminhtml/sales_order/view/order_id/'.$order_id."/key/".$key);
	}
	
	function lineAction(){
		$key = $this->getRequest()->getParam('key');
		$risultato = Mage::getModel("easysped/line")->generate();
		if($risultato){
			 Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('core')->__("File generato correttamente nella cartella <a href='".str_replace("/index.php", "", Mage::getBaseUrl())."media/easysped/".$risultato."'> Link </a>!")); 
		}else{
			 Mage::getSingleton('adminhtml/session')->addError(Mage::helper('core')->__("Data Partenza Generale non inserita correttamente!")); 
		}
		$this->_redirect('adminhtml/system_config/edit/section/cooder/key/'.$key);
	}
	
	function massAction(){
		$orderIds = $this->getRequest()->getPost('order_ids', array());
		$key = $this->getRequest()->getParam('key');
		$manual = Mage::getModel("easysped/manual");
		$flag = 1;
		foreach ($orderIds as $id) {
			try{
				$risultato = $manual->writeShippingFromButton($id, $flag);
				$flag = 0;
				if(!$risultato){
					Mage::getSingleton('adminhtml/session')->addError(Mage::helper('core')->__("Stai cercando ci inviare un ordine con uno stato non abilitato: ".$id."!"));
				}else{
					$filename = $risultato;
				}
			}catch(Exception $ex){
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('core')->__("Impossibile caricare ordine n. ".$id."!"));
			}
		}
		Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('core')->__("File generato correttamente nella cartella <a href='".Mage::helper('adminhtml')->getUrl('easysped/adminhtml_easysped/index')."'>Link </a>!"));//,str_replace("/index.php", "", Mage::getBaseUrl())."media/easysped/".$filename."'> ")); 
		$this->_redirect('adminhtml/sales_order/index/key/'.$key);
	}
	
	/**
     * ACL checking
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('sales/easysped');
    }
	
}

?>
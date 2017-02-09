<?php
 
class Cooder_EasySped_Adminhtml_EasyspedController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_title($this->__('Sales'))->_title($this->__('Easysped File Download'));
        $this->loadLayout();
        $this->_setActiveMenu('sales/sales');
        $this->_addContent($this->getLayout()->createBlock('easysped/adminhtml_filedownload_grid'));
        $this->renderLayout();
    }
 
  
    public function downloadAction()
    {
		$file_Id     = $this->getRequest()->getParam('id');
        $easyspedModel  = Mage::getModel('easysped/filedownload')->load($file_Id);
 
        if ($easyspedModel->getId() || $easyspedModel == 0) {
 
            Mage::register('easysped_data', $easyspedModel);
 			$url=$easyspedModel->getFileUrl();
			$today = date("Y-m-d H:i:s");        
			$easyspedModel->setFileStatus('downloaded')
							->setDownloadedTime($today)
                    		->save();
			
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('easysped')->__('Item does not exist'));
            $this->_redirect('*/*/');
        }
       $this->_redirectUrl($url);
       
    }
    
	
	public function deleteAction()
    {
        if( $this->getRequest()->getParam('id') > 0 ) {
            try {
                $easyspedModel = Mage::getModel('easysped/filedownload');
               
                $easyspedModel->setId($this->getRequest()->getParam('id'))
                    ->delete();
                   
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }
     
  
   
   /*
     * Product grid for AJAX request.
     * Sort and filter result for example.
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
               $this->getLayout()->createBlock('easysped/adminhtml_filedownload_grid')->toHtml()
        );
		
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





<?php
 
class Cooder_EasySped_Block_Adminhtml_Filedownload extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'adminhtml';
        $this->_controller = 'adminhtml_easysped';
        $this->_headerText = Mage::helper('easysped')->__('Easysped - File Download');
 
        parent::__construct();
        $this->_removeButton('add');
    }
}
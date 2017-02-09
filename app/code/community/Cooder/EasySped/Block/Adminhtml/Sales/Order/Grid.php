<?php
class Cooder_EasySped_Block_Adminhtml_Sales_Order_Grid extends Mage_Adminhtml_Block_Sales_Order_Grid
{  
    protected function _prepareMassaction()
    {
        parent::_prepareMassaction();
        $this->getMassactionBlock()->addItem(
            'easysped',
            array('label' => $this->__('Export Ordini BRT'),
                  'url'   => $this->getUrl('easysped/adminhtml_index/mass')
            )
        );
    }
}
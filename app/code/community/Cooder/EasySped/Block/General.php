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
class Cooder_EasySped_Block_General extends Mage_Adminhtml_Block_System_Config_Form_Field
{

    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $this->setElement($element);
        $url = $this->getUrl('easysped/adminhtml_index/line');

        $html = $this->getLayout()->createBlock('adminhtml/widget_button')
                    ->setType('button')
                    ->setClass('scalable')
                    ->setLabel('Run General!')
                    ->setOnClick("setLocation('".$url."')")
                    ->toHtml();

        return $html;
    }
}
?>
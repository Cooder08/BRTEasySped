<?php
/**
 * EasySped Source.
 * 
 * @author Cooder www.cooder.it
 * @copyright Copyright (c) 2014, Cooder
 * @license http://shop.cooder.it/index.php/license: this module is protected by cooder copyright
 * if not possible to send to other, without cooder permission.
 * @package Cooder_EasySped BRT Bridge
 * @version 3.0.0 stable
 */
class Cooder_EasySped_Model_Source_Tipemode
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 0, 'label'=>Mage::helper('adminhtml')->__('EasySped Mail')),
            array('value' => 1, 'label'=>Mage::helper('adminhtml')->__('EasySped Web')),
        );
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return array(
        	1 => Mage::helper('adminhtml')->__('EasySped Web'),
            0 => Mage::helper('adminhtml')->__('EasySped Mail'),
        );
    }

}
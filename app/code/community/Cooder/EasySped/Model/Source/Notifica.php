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
class Cooder_EasySped_Model_Source_Notifica
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 0, 'label'=>Mage::helper('adminhtml')->__('Nessuno')),
            array('value' => 1, 'label'=>Mage::helper('adminhtml')->__('Email')),
            array('value' => 2, 'label'=>Mage::helper('adminhtml')->__('SMS')),
            array('value' => 3, 'label'=>Mage::helper('adminhtml')->__('Entrambi')),
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
        	3 => Mage::helper('adminhtml')->__('Entrambi'),
        	2 => Mage::helper('adminhtml')->__('SMS'),
            1 => Mage::helper('adminhtml')->__('Email'),
            0 => Mage::helper('adminhtml')->__('Nessuno'),
        );
    }

}
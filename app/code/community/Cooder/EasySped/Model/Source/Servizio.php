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
class Cooder_EasySped_Model_Source_Servizio
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 'C', 'label'=>Mage::helper('adminhtml')->__('Espresso')),
            array('value' => 'D', 'label'=>Mage::helper('adminhtml')->__('Distribuzione')),
            array('value' => 'H', 'label'=>Mage::helper('adminhtml')->__('Espresso 10:30')),
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
        	'H' => Mage::helper('adminhtml')->__('Espresso 10:30'),
        	'D' => Mage::helper('adminhtml')->__('Normale'),
            'C' => Mage::helper('adminhtml')->__('Espresso'),
        );
    }

}
<?php
 
class Cooder_EasySped_Model_Mysql4_Filedownload extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {   
        $this->_init('easysped/filedownload', 'file_id');
    }
}
<?php
/**
 * EasySped Send Mail Model
 * 
 * @author Cooder www.cooder.it
 * @copyright Copyright (c) 2014, Cooder
 * @license http://shop.cooder.it/index.php/license: this module is protected by cooder copyright
 * if not possible to send to other, without cooder permission.
 * @package Cooder_EasySped BRT Bridge
 * @version 3.0.0 stable
 */
class Cooder_EasySped_Model_Mail
{
	function sendReport(){
		$current_time = explode(" ", date("Ymd H:i:s", Mage::getModel('core/date')->timestamp(time())));
		$time = explode(":", $current_time[1]);
		$path = Mage::getBaseDir('media') . DS. "easysped/";
		$filename = "FNVAB00R".$current_time[0].".csv";
		if(Mage::getStoreConfig('cooder/easysped/time') == $time[0] && Mage::getStoreConfig('cooder/easysped/tipemode') != 2){
			try{
				$mail = new Zend_Mail();
				$mail->setFrom(Mage::getStoreConfig('trans_email/ident_general/email'), Mage::getStoreConfig('trans_email/ident_general/name'));
				$mail->addTo(Mage::getStoreConfig('cooder/easysped/email'),Mage::getStoreConfig('cooder/easysped/nomemail'));
				$mail->addCc(Mage::getStoreConfig('cooder/easysped/emailcc'), '');
				$mail->setSubject("Easysped file data: ".$current_time[0]);
				if(file_exists($path.$filename)){
					$mail->setBodyHtml("EasySped Email: allegato il file csv.");
					// this is for to set the file format in utf8_encode
					$content = file_get_contents($path.$filename);
					$at = new Zend_Mime_Part($content);
					$at->type = 'application/csv';
					$at->disposition = Zend_Mime::DISPOSITION_INLINE;
					$at->encoding = Zend_Mime::ENCODING_8BIT;
					$at->filename = $filename;
					$mail->addAttachment($at);
				}else{
					$mail->setBodyHtml("EasySped Email: non è stata generata nessuna spedizione!");
				}
				$mail->send();
				
			}catch(Exception $e){
				Mage::log($e->getMassage(), null, "easysped_error_email.log");
			}
		}
		if(Mage::getStoreConfig('cooder/easysped/time') == $time[0] && Mage::getStoreConfig('cooder/easysped/autoclean')){
			try{	
				unlink($path.$filename);
			}catch(Exception $ex){
				
			}
		}
	}		
}
?>
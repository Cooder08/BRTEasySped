<?php
/**
 * EasySped CSV Model, provides to generate csv file second config hours
 * 
 * @author Cooder www.cooder.it
 * @copyright Copyright (c) 2014, Cooder
 * @license http://shop.cooder.it/index.php/license: this module is protected by cooder copyright
 * if not possible to send to other, without cooder permission.
 * @package Cooder_EasySped BRT Bridge
 * @version 3.0.0 stable
 */
class Cooder_EasySped_Model_Csv extends Mage_Core_Model_Abstract
{
    function writeCsv($invoiceArray, $reset = false){
        $current_time = explode(" ", date("Ymd H:i:s", Mage::getModel('core/date')->timestamp(time())));
        
        $time  = explode(":", $current_time[1]);
        if($time[0] >= Mage::getStoreConfig('cooder/easysped/time')){
            $datefile = date("Ymd") + 1;
        }else{
            $datefile = date("Ymd");
        }
        $cnvname = "FNVAB00R".$datefile.".csv";
        if(!file_exists(Mage::getBaseDir('media'). DS . "easysped")){
            mkdir(Mage::getBaseDir('media'). DS . "easysped");
        }
        $csvpath = Mage::getBaseDir('media'). DS . "easysped" . DS .$cnvname;
        try{
        	$write = 1;
            if(!file_exists($csvpath) || $reset){
            	Mage::log($csvpath, null, "path_csv.log");
                if(Mage::getStoreConfig('cooder/easysped/tipemode') == 1){
                    $first_line = "vabccm;vabctr;vabcbo;vabrsd;vabrd2;vabind;vabcad;vablod;vabprd;vabnzd;vabnrc;vabtrc;vabemd;vabtsp;vabias;vabvas;vabncl;vabpkb;vabvlb;vabcas;vabtic;vabvca;vabrmn;vabnot;vabnt2;vabffd;vabtc1;vabcel;vabtno";
                    if(Mage::getStoreConfig('cooder/easysped/tracking')){
                        $first_line .= ";vabrma";
                    }
                    $first_line .= "\n";
                }else{
                    $first_line = "vabant;vabccm;vablnp;vabctr;vabcbo;vabaas;vabmgs;vabrmn;vabrsd;vabind;vablod;vabcad;vabprd;vabnzd;vabncl;vabpkb;vabcas;vabvca;vabnot;vabnt2;vabnrc;vabtrc;VABTIC;VABEMD;VABRMA\n";
                }
                if(Mage::getModel('easysped/filedownload')){
                    $files = Mage::getModel('easysped/filedownload')->getCollection();
                    $today = date("Y-m-d H:i:s");  
                    $csvurl = Mage::getBaseUrl('media'). "easysped" . DS .$cnvname;
                    $easyspedModel  = Mage::getModel('easysped/filedownload');
                                            
                    
                    if($files->getLastItem()->getFileStatus() == 'downloaded') {
                            
                            $cnvname = "FNVAB00R".$datefile."-".time().".csv";
                            $csvurl = Mage::getBaseUrl('media'). "easysped" . DS .$cnvname;
                            $csvpath = Mage::getBaseDir('media'). DS . "easysped" . DS .$cnvname;
                            Mage::log("2 ".$csvpath, null, "path_csv.log");
                            $fp = fopen($csvpath, 'w');
                                
                            $easyspedModel->setFileName($cnvname)
                            ->setFileUrl($csvurl)
                            ->setFileStatus('available')
                            ->setCreatedTime($today)
                            ->save(); 
                        
                    }else{
                        if($files->getSize()<1) {
                            $easyspedModel->setFileName($cnvname)
                            ->setFileUrl($csvurl)
                            ->setFileStatus('available')
                            ->setCreatedTime($today)
                            ->save();
                            $fp = fopen($csvpath, 'a');
							$write = 0;
                        }else{
                            $cnvname=$files->getLastItem()->getFileName();
                            $csvpath = Mage::getBaseDir('media'). DS . "easysped" . DS .$cnvname;  
                            if(file_exists($csvpath)){
                                $fp = fopen($csvpath, 'a');
                                $write = 0;
                            }else{
                                $fp = fopen($csvpath, 'w');
                            }
                        }
                    } 
                    
                } 
                
            }else{
                $fp = fopen($csvpath, 'a');
				$write = 0;
            }
            if($first_line != "" && $write != 0){
                fputs($fp, $first_line);
            }
            foreach ($invoiceArray as $fields){
                $iter = 0;
                $len = count($fields); 
                foreach ($fields as $campo) {
                    $iter++;
                    $cp = str_replace(";",",", $campo);
                    $cp = str_replace('"', "'", $cp);
                    $cp = str_replace('<br/>', '', $cp);
                    $cp = preg_replace('#[\n]#', '', $cp);
                    if($iter < $len){  
                        fputs($fp, trim($cp).";");
                    }else{
                        fputs($fp, trim($cp));
                    }
                }
                fputs($fp,"\n");
            }
            fclose($fp);
           
        
            
            return $cnvname;
        }catch(Exception $e){
            //Mage::log("Errore csv creation ".$e, null, "easysped_error.log");
            return false;
        }
    }   
    
}


?>
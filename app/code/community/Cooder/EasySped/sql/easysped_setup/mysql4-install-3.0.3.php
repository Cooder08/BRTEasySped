<?php
 
$installer = $this;
 
$installer->startSetup();
 
$installer->run("
 
-- DROP TABLE IF EXISTS {$this->getTable('easysped_filedownload')};
CREATE TABLE {$this->getTable('easysped_filedownload')} (
  `file_id` int(11) unsigned NOT NULL auto_increment,
  `file_name` varchar(255) NOT NULL default '',
  `file_url` text NOT NULL default '',
  `created_time` datetime NULL,
  `downloaded_time` datetime NULL,
  `file_status` varchar(255) NOT NULL default '',
  PRIMARY KEY (`file_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 
    ");
 
$installer->endSetup();
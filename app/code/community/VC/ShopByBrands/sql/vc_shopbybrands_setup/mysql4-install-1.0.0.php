<?php
$installer = $this;

$installer->startSetup();
$installer->run("
CREATE TABLE IF NOT EXISTS `{$this->getTable('vc_shopbybrands')}` (
	`id` int(11) NOT NULL,
	`identifier` varchar(200) NOT NULL,
	`description` text NOT NULL,
	`meta_keyword` text NOT NULL,
	`meta_description` text NOT NULL,
	`image` varchar(200) NOT NULL,
	`option_id` int(10) NOT NULL DEFAULT '0',
	`show_at_home` TINYINT(1) NOT NULL DEFAULT '0',
	`created_at` datetime NOT NULL,
	`updated_at` datetime NOT NULL,
	`is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

ALTER TABLE `{$this->getTable('vc_shopbybrands')}`
	ADD PRIMARY KEY (`id`);
ALTER TABLE `{$this->getTable('vc_shopbybrands')}`
	MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
");

$installer->endSetup(); 



<?php
	require_once('init.inc');
	
	require_once($site->PATH . '/lib/sql.class');
	$sql = new Sql;
	
	//database
	$sql->SqlExecute('CREATE DATABASE IF NOT EXISTS ' . $site->CONFIG['database']['name']);
	
	$sql->SqlExecute('CREATE TABLE IF NOT EXISTS `' . $module->NAME . '` (
`id` int(10) unsigned NOT NULL auto_increment,
`email` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
`user` int(10) unsigned NOT NULL,
`ip` varchar(15) character set utf8 collate utf8_unicode_ci NOT NULL,
`date` date NOT NULL,
`access` int(1) NOT NULL default "1",
`rate` int(11) NOT NULL default "350",
PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;');	
?>
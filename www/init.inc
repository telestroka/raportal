<?php
	define ("MODULE", "news");
	define ("MODULE_URL", SITE_URL . '/' . MODULE);
	
	//sql
	require_once(SITE_PATH . '/php/sql.php');
	sql_execute('CREATE TABLE IF NOT EXISTS `' . MODULE . '` (id int(11) NOT NULL auto_increment,title varchar(255) NOT NULL default "",text text NOT NULL,date date NOT NULL, PRIMARY KEY id (id) ) TYPE=MyISAM;');	
?>
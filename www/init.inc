<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . '/inc/init.inc'); 
	$module = new Module('subscribe', 'Подписка');
	
	//sql
	require_once($site->PATH . '/lib/sql.class');
	$sql = new Sql;
	
	//mail
	require_once($site->PATH . '/lib/mail.class');
	$message = '';
?>
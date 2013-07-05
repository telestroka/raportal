<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . '/inc/init.inc'); 
	$module = new Module('mail', 'Рассылка');
	
	//sql
	require_once($site->PATH . '/lib/sql.class');
	$sql = new Sql;	
	
	//fs	
	require_once($site->PATH . '/lib/fs.class');
	
	//send
	require_once($site->PATH . '/lib/send.class');
	
	$mail_start = $sql->SqlGetRow('SELECT * FROM `ngs_news` ORDER BY date limit 0,1;');
	$mail_start = strtotime($mail_start['date']);
?>
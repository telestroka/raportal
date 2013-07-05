<?php
	require_once('inc/init.inc');
	$module = new Module('', 'Вопросы бизнеса — на email');
	$page = new Page();
	
	//sql
	require_once($site->PATH . '/lib/sql.class');
	$sql = new Sql;	
	
	//send
	require_once($site->PATH . '/lib/send.class');

	$last_issue = intval(file_get_contents('data/last.dat'));
	$issue = (isset($_GET['issue']) && $_GET['issue'] > 0 && $_GET['issue'] <= $last_issue) ? $_GET['issue'] : $last_issue;
	$data = @file_get_contents('data/' . $issue . '.dat');
	if (!$data && $issue != $last_issue) $site->SiteGoTo('/');
	$grab = unserialize(file_get_contents('data/' . $issue . '.dat'));
	
	include($site->PATH . '/tpl/main.tpl');
?>
<?php
	require_once('../inc/init.inc'); 
	require_once('../init.inc');
	require_once('../php/time.php'); 
	
	if (!isset($_GET['id']) && preg_match('/\d+/', $_GET['id'])) exit();
	$id = $_GET['id'];	
	
	$news = sql_get_row('SELECT * FROM news WHERE id = ' . $id . ';');
	$prev = sql_get_row('SELECT id FROM `news` WHERE id < ' . $news['id'] . ' ORDER BY id DESC LIMIT 1');
	$next = sql_get_row('SELECT id FROM `news` WHERE id > ' . $news['id'] . ' ORDER BY id LIMIT 1');
	
	$next = ($next) ? $next['id'] : '';
	$prev = ($prev) ? $prev['id'] : '';
	
	//prev|||next|||id|||title|||text|||date
	$result = $prev . '|||' . $next . '|||' . $news['id'] . '|||' . $news['title'] . '|||' . $news['text'] . '|||' . convert_date_to_text($news['date']);
	echo $result; //iconv('cp1251','utf-8', $result);
?>
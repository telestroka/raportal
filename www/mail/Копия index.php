<?php
	require_once('init.inc');
	$page = new Page();
	
	//emails
	$emails = $sql->SqlGetRows('SELECT * FROM `subscribe`;');
	
	//period
	$month_names = array('01'=>'января','02'=>'февраля','03'=>'марта','04'=>'апреля','05'=>'мая','06'=>'июня','07'=>'июля','08'=>'августа','09'=>'сентября','10'=>'октября','11'=>'ноября','12'=>'декабря');
	
	$from_time = (date("w") == 1) ? strtotime("last Monday") : strtotime("last Monday") - 3600*24*7;
	$from = strftime("%Y-%m-%d", $from_time);	
	$from_day = date("j", $from_time);
	$from_month = strftime("%m", $from_time);
	$from_month = $month_names[$from_month];
	$from_year = strftime("%Y", $from_time);
	$to = strftime("%Y-%m-%d", strtotime("last Sunday"));
	$to_day = date("j", strtotime("last Sunday"));
	$to_month = strftime("%m");
	$to_month = $month_names[$to_month];
	$to_year = strftime("%Y", strtotime("last Sunday"));
		
	//message
	$message = '
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" >
		<title></title>
	</head>
	<body style="margin: 30px 20px; font: 13px \'Arial\',sans-serif; color: #464646;">
		<h1 style="margin: 0; font: 36px \'Arial\',serif; color: #598527;">
			Вопросы бизнеса — на имэйл
		</h1>
		<div style="font-weight: bold; margin: 10px 0;">Выпуск №' . send::SendGetIssue(time(), $mail_start) . ' Новосибирск, ' . date('d.m.Y', send::SendGetMonday(time())) . '</b></div>
		
		Материалы сайта <a href="http://business.ngs.ru/">НГС.БИЗНЕС</a> за прошлую неделю.<br/>
		Каждый из заголовков является ссылкой на соответствующую публикацию.
<h2 style="margin: 40px 0 0 0; padding-left: 50px; background-color: #008000; color: #fff; font-size: 12pt; font-weight: bold;">
	СТАТЬИ
</h2>';

	//articles
	$articles = $sql->SqlGetRows('SELECT * FROM `ngs_articles` WHERE date >= "' . $from . '" AND date <= "' . $to . '" ORDER BY date desc;');	
	foreach ($articles as $item_params)
		$message .= '
<table cellpadding="0" cellspacing="0">
	<tr>
		<td valign="top" style="padding-right: 10px; color: #999; width: 40px;">
			' . date('j.m',strtotime($item_params['date'])) . '
		</td>
		<td valign="top">
			<a href="' . $item_params['url'] . '">' . $item_params['title'] . '</a><br>
			' . $item_params['text'] . '
		</td>
	</tr>
</table>';
	
	//news	
	$message .= '
<h2 style="margin: 40px 0 0 0; padding-left: 50px; background-color: #008000; color: #fff; font-size: 12pt; font-weight: bold;">НОВОСТИ</h2>';
	$news = $sql->SqlGetRows('SELECT * FROM `ngs_news` WHERE date >= "' . $from . '" AND date <= "' . $to . '" ORDER BY date desc;');	
	$date = '';
	foreach ($news as $item_params)
	{
		if ($date == $item_params['date'])
		{
			$message .= '
<table cellpadding="0" cellspacing="0">
	<tr>
		<td valign="top" style="padding-right: 10px; color: #999; width: 40px;">&nbsp;</td>
		<td valign="top">
			<a href="' . $item_params['url'] . '">' . $item_params['title'] . '</a>
		</td>
	</tr>
</table>';
		}
		else
		{
			$message .= '
<table cellpadding="0" cellspacing="0">
	<tr>
		<td valign="top" style="padding-right: 10px; color: #999; width: 40px;">' . date('j.m',strtotime($item_params['date'])) . '</td>
		<td valign="top">
			<a href="' . $item_params['url'] . '">' . $item_params['title'] . '</a>
		</td>
	</tr>
</table>';
			$date = $item_params['date'];
		}		
	}
	
	//sales	
	$message .= '
<h2 style="margin: 40px 0 0 0; padding-left: 50px; background-color: #008000; color: #fff; font-size: 12pt; font-weight: bold;">ПРОДАЖА БИЗНЕСА</h2>';
	$sales = $sql->SqlGetRows('SELECT * FROM `ngs_sales` WHERE date >= "' . $from . '" AND date <= "' . $to . '" ORDER BY date desc;');	
	$date = '';
	foreach ($sales as $item_params)
	{
		if ($date == $item_params['date'])
		{
			$message .= '
<table cellpadding="0" cellspacing="0">
	<tr>
		<td valign="top" style="padding-right: 10px; color: #999; width: 40px;">&nbsp;</td>
		<td valign="top">
			<a href="' . $item_params['url'] . '">' . $item_params['title'] . '</a> ' . $item_params['price'] . '
		</td>
	</tr>
</table>';
		}
		else
		{
			$message .= '
<table cellpadding="0" cellspacing="0">
	<tr>
		<td valign="top" style="padding-right: 10px; color: #999; width: 40px;">' . date('j.m',strtotime($item_params['date'])) . '</td>
		<td valign="top">
			<a href="' . $item_params['url'] . '">' . $item_params['title'] . '</a> ' . $item_params['price'] . '
		</td>
	</tr>
</table>';
			$date = $item_params['date'];
		}		
	}
	
	//forums	
	$message .= '
<h2 style="margin: 40px 0 0 0; padding-left: 50px; background-color: #008000; color: #fff; font-size: 12pt; font-weight: bold;">ОБЩЕНИЕ</h2>';
	$forums = $sql->SqlGetRows('SELECT * FROM `ngs_forums` WHERE date >= "' . $from . '" AND date <= "' . $to . '" ORDER BY date desc;');	
	$date = '';
	foreach ($forums as $item_params)
	{
		if ($date == $item_params['date'])
		{
			$message .= '
<table cellpadding="0" cellspacing="0">
	<tr>
		<td valign="top" style="padding-right: 10px; color: #999; width: 40px;">&nbsp;</td>
		<td valign="top">
			<a href="' . $item_params['url'] . '">' . $item_params['title'] . '</a>
		</td>
	</tr>
</table>';
		}
		else
		{
			$message .= '
<table cellpadding="0" cellspacing="0">
	<tr>
		<td valign="top" style="padding-right: 10px; color: #999; width: 40px;">' . date('j.m',strtotime($item_params['date'])) . '</td>
		<td valign="top">
			<a href="' . $item_params['url'] . '">' . $item_params['title'] . '</a>
		</td>
	</tr>
</table>';
			$date = $item_params['date'];
		}		
	}
		
	//top
	$message .= '
<h2 style="margin: 40px 0 0 0; padding-left: 50px; background-color: #ccc; font-size: 12pt; font-weight: bold; font-style: italic;">Самые комментируемые на НГС за неделю</h2>';	
	$date = ''; $top = array();
	foreach ($articles as $item_params)
	{
		if ($date != $item_params['date'])
		{
			$date = $item_params['date'];
			$news = $sql->SqlGetRow('SELECT * FROM `ngs_news` WHERE date = "' . $date . '" ORDER BY comments desc limit 0,1;');
			if ($news['comments'] > $item_params['comments']) $item_params = $news;			
			$top[$item_params['comments']] = '<table cellpadding="0" cellspacing="0"><tr><td valign="top" style="padding-right: 10px; color: #999; width: 40px;">' . date('j.m',strtotime($item_params['date'])) . '</td><td valign="top"><a href="' . $item_params['url'] . '">' . $item_params['title'] . '</a> (' . $item_params['comments'] . ')<br>' . $item_params['text'] . '</td></tr></table>';			
		}		
	}
	krsort($top);
	foreach ($top as $top_item) $message .= $top_item;
	$message .= '
<div style="margin-top: 40px; border-top: 1px solid #ccc; font-weight: bold;">
	Если вы хотите отказаться от этой рассылки, перейдите по <a href="' . $site->URL . '/delete.php?email=EMAILPLACE">ссылке</a> или позвоните по телефону 212-54-52
</div>
</body>
</html>';	
		
	include($site->PATH . '/tpl/main.tpl');            
?>
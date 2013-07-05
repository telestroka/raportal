<?php
	require_once('init.inc');
	$page = new Page();
	
	$issue = intval(file_get_contents('../data/last.dat'));
	$grab = unserialize(file_get_contents('../data/' . $issue . '.dat'));
	
	$emails = $sql->SqlGetRows('SELECT * FROM `subscribe`;');
	$month_names = array('01'=>'января','02'=>'февраля','03'=>'марта','04'=>'апреля','05'=>'мая','06'=>'июня','07'=>'июля','08'=>'августа','09'=>'сентября','10'=>'октября','11'=>'ноября','12'=>'декабря');
	$issue = $grab['issue'];
	
	//message
	$message = '
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" >
		<title></title>
	</head>
	<body style="margin: 30px 20px 0 20px; font: 13px \'Arial\',sans-serif; color: #464646;">
		<h1 style="margin: 0; font: 36px \'Arial\',serif; color: #598527;">
			Вопросы бизнеса — на email
		</h1>
		<div style="font-weight: bold; margin: 10px 0;">Выпуск №' . $issue . ' Новосибирск, ' . date('d.m.Y', $grab['time'] + 24 * 60 * 60) . '</b></div>
		
		Материалы сайта <a href="http://business.ngs.ru/">НГС.БИЗНЕС</a> за прошлую неделю.<br/>
		Каждый из заголовков является ссылкой на соответствующую публикацию.';
	
	if ($grab['forums']) {
		$message .= '
	<h2 style="margin: 10px 0 5px 0; padding-left: 5px; background-color: #ACD373; color: #fff; font-size: 15px; font-weight: bold; line-height: 40px;">ОБСУЖДЕНИЯ</h2>';
		foreach ($grab['forums'] as $item_params)
		{
			$message .= '<a href="' . $item_params['url'] . '" style="color: #464646;">' . $item_params['title'] . '</a><br/>';
		}
	}
	if ($grab['sales']) {
		$message .= '
	<h2 style="margin: 20px 0 5px 0; padding-left: 5px; background-color: #ACD373; color: #fff; font-size: 15px; font-weight: bold; line-height: 40px;">ОБЪЯВЛЕНИЯ</h2>';
		foreach ($grab['sales'] as $item_params)
		{
				$message .= '<a href="' . $item_params['url'] . '" style="color: #464646;">' . $item_params['title'] . ' ' . $item_params['price'] . '</a><br/>';
		}
	}
	if ($grab['business_articles']) {
		$message .= '
	<h2 style="margin: 20px 0 5px 0; padding-left: 5px; background-color: #ACD373; color: #fff; font-size: 15px; font-weight: bold; line-height: 40px;">СТАТЬИ</h2>';
		foreach ($grab['business_articles'] as $item_params) {
			$message .= '<a href="' . $item_params['url'] . '" style="color: #464646;">' . $item_params['title'] . '</a><br>
	' . $item_params['subtitle'] . '<br/><br/>';
		}
	}
	if ($grab['best_article']) {
		$message .= '
	<h2 style="margin: 20px 0 5px 0; padding-left: 5px; background-color: #6DCFF6; color: #fff; font-size: 15px; font-weight: bold; line-height: 40px;">ВЫБОР НАРОДА</h2>
	Самая комментируемая статья на сайте НГС прошлой недели<br/>';
		$message .= '<a href="' . $grab['best_article']['url'] . '" style="color: #464646;">' . $grab['best_article']['title'] . '</a>
	<span style="color: #0076A3;">Комментариев - ' . $grab['best_article']['comments'] . '.</span><br>
	' . $grab['best_article']['subtitle'] . '<br/><br/>';
	}
	
	$message .= 'Чтобы оказаться от этой рассылки, просто перейдите по этой <a href="' . $site->URL . '/delete.php?email=EMAILPLACE" style="color: #005E20;">ссылке</a>.<br/><br/>
Удаление вашего электронного почтового адреса из базы данных произойдет автоматически. Или позвоните: (383) 212-54-52.<br/><br/>
<img src="' . $site->URL . '/i/mail_logo.gif" alt=""/>
</body>
</html>';	
		
	include($site->PATH . '/tpl/main.tpl');            
?>
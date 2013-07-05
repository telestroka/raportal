<?php
	require_once('inc/init.inc'); 
	require_once('init.inc');  
	require_once('php/time.php'); 
	
	$news = sql_get_row('SELECT * FROM news ORDER BY id DESC LIMIT 1;');
	$prev = sql_get_row('SELECT id FROM `news` WHERE id < ' . $news['id'] . ' ORDER BY id DESC LIMIT 1');
	
	include(SITE_PATH . '/inc/doctype.inc');
?>
<head>
	<? include(SITE_PATH . '/inc/head.inc'); ?>
	<script language="JavaScript" type="text/javascript" src="js/news.js"></script>
</head>
<body id="body">
	<table cellpadding="0" cellspacing="0" class="container">
		<tr>
			<td class="content-area">
				<table cellpadding="0" cellspacing="0" class="content">
					<tr>
						<td class="left-column">
							<h2 class="orange">«Агентство Портал»</h2>
							<p>
								Общество с ограниченной ответственностью<br/>
								Свидетельство о регистрации 54 № 003473180 от 05.12.2006<br/>
								630004, Новосибирск, <a href="http://maps.yandex.ru/map.xml?mapID=800&mapX=9228724&mapY=7332963&descx=9228724&descy=7332963&scale=8&text=%CB%E5%ED%E8%ED%E0%2C+53" target="_blank">ул. Ленина, 53 — 27 на Яндекс.Карте</a>
							</p>
							<h2 class="orange">(383) 212-54-52</h2> 
							<p><a href="mailto:info@raportal.ru">info@raportal.ru</a></p>
							<p class="white">Сайт в работе с 1 августа 2008 года</p>
						</td>
						<td class="right-column">
							<? include(SITE_PATH . '/inc/header.inc'); ?>
							<h2 class="white" style="margin-bottom: 20px;">Компанейские новости:</h2>
							<p>
								<span class="small" id="news_date"><?=convert_date_to_text($news['date']);?></span><br/>
								<span class="white" id="news_title"><?=$news['title'];?></span>
							</p>
							<div id="news_text">
								<?=$news['text'];?>
							</div>
							<p>
								<? if ($prev): ?><a href="javascript:change_news(<?=$prev['id'];?>)" id="news_prev">Новость раньше</a><br/><? endif; ?>
								<a href="" id="news_next">Новость позже</a><br/>
							</p>
							<? include(SITE_PATH . '/inc/copyright.inc'); ?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td class="footer-area"></td>
		</tr>
	</table>
</body>
</html>
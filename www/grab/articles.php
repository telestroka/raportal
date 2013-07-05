<?php
	ini_set('display_errors',1);
	require_once('include/init.php');
	$last = sql_get_row('SELECT date FROM `ngs_articles` order by date desc limit 0,1;');
	$last = (isset($last['date'])) ? $last['date'] : '0000-00-00';
	$source_url = 'http://business.ngs.ru/articles/';
	$source_content = read($source_url);
	$source_content = iconv("windows-1251", "UTF-8", $source_content);
	if (!$source_content) exit;
	$articles = new simple_html_dom();
	$articles->load($source_content);
	if ($articles == '') exit;
	
	foreach ($articles->find('.article') as $article)
	{
		$title = $article->find('h2', 0)->plaintext;
				
		$date = $article->find('h3 span', 0)->plaintext . '.' . date('Y');
		$date = strftime("%Y-%m-%d", strtotime($date));		
		
		if ($date <= $last) continue; //нужны только новые
		$article->find('h3 span', 0)->outertext = '';
		$subtitle = strip_tags($article->find('h3', 0)->outertext);
		
		$comments = $article->find('.comments', 1)->plaintext;
		$comments = str_replace('Комментариев: ', '', $comments);
		
		if ($comments == '') $comments = 0;
		$url = 'http://business.ngs.ru' . $article->find('h2 a', 0)->href;
		
		//text		
		$text = $article->find('.text', 0)->plaintext;
				
		sql_execute('INSERT IGNORE INTO ngs_articles (title,subtitle,text,url,comments,date) values("' . sql_prepare($title) . '","' . sql_prepare($subtitle) . '","' . sql_prepare($text) . '","' . sql_prepare($url) . '","' . sql_prepare($comments) . '","' . sql_prepare($date) . '");');				
	}
?>
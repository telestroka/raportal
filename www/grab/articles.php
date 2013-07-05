<?php
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
		$title = $article->find('h1', 0)->plaintext;
		
		$date = $article->find('.subheader span', 0)->plaintext . '.' . date('Y');
		$date = strftime("%Y-%m-%d", strtotime($date));		
		if ($date <= $last) continue; //нужны только новые
		$article->find('.subheader span', 0)->outertext = '';
		$subtitle = strip_tags($article->find('.subheader', 0)->outertext);
		
		$comments = $article->find('.comments', 0)->plaintext;
		$comments = str_replace('комментариев: ', '', $comments);
		if ($comments == '') $comments = 0;
		$url = 'http://business.ngs.ru' . $article->find('h1 a', 0)->href;
		
		//text
		$article->find('h1', 0)->outertext = '';
		$article->find('.subheader', 0)->outertext = '';
		$article->find('.comment-add', 0)->outertext = '';
		$article->find('.comments', 0)->outertext = '';
		$article->find('.hits', 0)->outertext = '';
		$text = strip_tags($article->outertext);
		
		//echo 'INSERT IGNORE INTO ngs_articles (title,subtitle,text,url,comments,date) values("' . sql_prepare($title) . '","' . sql_prepare($subtitle) . '","' . sql_prepare($text) . '","' . sql_prepare($url) . '","' . sql_prepare($comments) . '","' . sql_prepare($date) . '");';
		
		sql_execute('INSERT IGNORE INTO ngs_articles (title,subtitle,text,url,comments,date) values("' . sql_prepare($title) . '","' . sql_prepare($subtitle) . '","' . sql_prepare($text) . '","' . sql_prepare($url) . '","' . sql_prepare($comments) . '","' . sql_prepare($date) . '");');				
	}
?>
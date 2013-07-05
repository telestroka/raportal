<?php
	require_once('include/init.php');
	
	$last = sql_get_row('SELECT date FROM `ngs_news` order by date desc limit 0,1;');
	$last = (isset($last['date'])) ? $last['date'] : '0000-00-00';
	
	for ( $page=0; $page<3; $page++ )
	{
		$source_url = 'http://business.ngs.ru/economic/?page=' . $page;
		$source_content = read($source_url);
		$source_content = iconv("windows-1251", "UTF-8", $source_content);
		if (!$source_content) continue;
		$news = new simple_html_dom();
		$news->load($source_content);
		if ($news == '') continue;
		
		foreach ($news->find('.article') as $article)
		{
			$title = $article->find('h1', 0)->plaintext;
			$date = $article->find('.subheader span', 0)->plaintext . '.' . date('Y');
			$date = strftime("%Y-%m-%d", strtotime($date));
			if ($date <= $last) continue; //нужны только новые
			$comments = $article->find('.comments', 0)->plaintext;
			$comments = str_replace('комментариев: ', '', $comments);
			$url = 'http://business.ngs.ru' . $article->find('h1 a', 0)->href;
			
			//text
			$article->find('h1', 0)->outertext = '';
			$article->find('.subheader', 0)->outertext = '';
			$article->find('.comment-add', 0)->outertext = '';
			$article->find('.comments', 0)->outertext = '';
			$article->find('.hits', 0)->outertext = '';
			$text = strip_tags($article->outertext);
			
			sql_execute('INSERT IGNORE INTO ngs_news (title,text,url,comments,date) values("' . sql_prepare($title) . '","' . sql_prepare($text) . '","' . sql_prepare($url) . '","' . sql_prepare($comments) . '","' . sql_prepare($date) . '");');
		}
	}
?>
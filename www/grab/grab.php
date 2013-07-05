<?php	
	ob_implicit_flush();
	set_time_limit(0);
	ini_set('memory_limit',-1);
	ini_set('display_errors',1);
	
	$site_path = '/var/www/vhosts/raportal.ru/httpdocs';
	//$site_path = '..';
	
	include_once($site_path . '/lib/dom.php');		
	include_once($site_path . '/lib/fs.class');
	
	$issue = intval(file_get_contents($site_path . '/data/last.dat'));
	
	//test if not old
	$six_days = 1 * 24 * 60 * 60;
	$last_issue_time = @filemtime($site_path . '/data/' . $issue . '.dat');
	if (!$last_issue_time) $last_issue_time = 0;
	if (time() - $last_issue_time < $six_days) exit('not old file yet');
	$issue++;
	
	//читаем в несколько попыток
	function read($url)
	{
		$i = 0;
		do
		{
			$content = @file_get_contents($url);
			$i++;
		}
		while($content == '' && $i < 5);
		if ($content == '' || !$content) return false;
		
		return $content;
	}
	
	//обсуждения
	function get_forums()
	{
		$result = array();
		$source_content = read('http://business.ngs.ru/articles/');
		$articles = new simple_html_dom();
		$articles->load($source_content);
		$articles_list = $articles->find('.blocks-forums .boxed', 0)->find('.forum-item');
		if (count($articles_list) == 0) return false;
		foreach ($articles_list as $article) {
			$title = $article->plaintext;
			if ($title == NULL) continue;
			$title = trim($title);
			$url = $article->find('a', 0)->href;
			$url = 'http://business.ngs.ru' . $url;
			$result[] = array(
				'title' => $title,
				'url' => $url
			);
		}
		$articles->clear(); 
		unset($articles);
		
		return $result;
	}
	
	//объявления
	function get_sales()
	{
		$result = array();
		$source_content = read('http://business.ngs.ru/business_sales/');
		$articles = new simple_html_dom();
		$articles->load($source_content);
		$articles_list = $articles->find('.sale-notice');
		if (count($articles_list) == 0) return false;
		foreach ($articles_list as $article) {
			$title = $article->find('h2', 0)->plaintext;
			if ($title == NULL) continue;
			$title = trim($title);
			$url = $article->find('h2 a', 0)->href;
			$url = 'http://business.ngs.ru' . $url;
			$result[] = array(
				'title' => $title,
				'url' => $url
			);
		}
		$articles->clear(); 
		unset($articles);
		return $result;
	}
	
	//статьи
	function get_business_articles()
	{
		$result = array();
		$source_content = read('http://business.ngs.ru/articles/');
		$articles = new simple_html_dom();
		$articles->load($source_content);
		$articles_list = $articles->find('.article');
		if (count($articles_list) == 0) return false;
		foreach ($articles_list as $article) {
			$title = $article->find('h2', 0)->plaintext;
			if ($title == NULL) continue;
			$title = trim($title);
			
			$article->find('h3 span', 0)->outertext = '';
			$subtitle = strip_tags($article->find('h3', 0)->outertext);
			if ($subtitle == NULL) continue;
			$subtitle = trim($subtitle);
			
			$url = $article->find('h2 a', 0)->href;
			$url = 'http://business.ngs.ru' . $url;
			$result[] = array(
				'title' => $title,
				'subtitle' => $subtitle,
				'url' => $url
			);
		}
		$articles->clear(); 
		unset($articles);
		return $result;
	}
	
	//выбор народа
	function get_best_article()
	{
		$result = array(); $max_comments = 0;
		$source_content = read('http://news.ngs.ru/what/what3.php');
		$articles = new simple_html_dom();
		$articles->load($source_content);
		$articles_list = $articles->find('.news-records tr');
		if (count($articles_list) == 0) return false;
		foreach ($articles_list as $article) {
			$title = $article->find('h2', 0)->plaintext;
			if ($title == NULL) continue;
			$title = trim($title);			
			
			$subtitle = $article->find('h3', 0)->plaintext;
			if ($subtitle == NULL) continue;
			$date = substr($subtitle, 1, strpos($subtitle, ']') - 1);
			$subtitle = str_replace('[' . $date . ']&nbsp; ', '', $subtitle);
			$subtitle = trim($subtitle);
			
			$url = $article->find('h2 a', 0)->href;
			$url = 'http://news.ngs.ru' . $url;
			
			$comments = $article->find('.news_mini', 0)->outertext;			
			$comments_exist = preg_match_all('/<\/a>:.*(\d+)<\/div>/sU', $comments, $comments_matches);
			$comments = ($comments_exist) ? intval($comments_matches[1][0]) : 0;
			if ($comments > $max_comments) {
				$result = array(
					'title' => $title,
					'subtitle' => $subtitle,
					'url' => $url,
					'comments' => $comments,
				);
				$max_comments = $comments;
			}
		}		
		$articles->clear(); 
		unset($articles);
		return $result;
	}
	
	$grab = array(
		'issue' => $issue,
		'time' => time(),
		'forums' =>  get_forums(),
		'sales' =>  get_sales(),
		'business_articles' =>  get_business_articles(),
		'best_article' =>  get_best_article(),
	);
	
	Fs::FsWrite($site_path . '/data/' . $issue . '.dat', serialize($grab), 'w');
	chmod ($site_path . '/data/' . $issue . '.dat', 0777);
	Fs::FsWrite($site_path . '/data/last.dat', $issue, 'w');
	
	echo('ok');
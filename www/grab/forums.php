<?php
	require_once('include/init.php');
	
	$last = sql_get_row('SELECT date FROM `ngs_forums` order by date desc limit 0,1;');
	$last = (isset($last['date'])) ? $last['date'] : '0000-00-00';
	
	$source_url = 'http://business.ngs.ru/';
	$source_content = read($source_url);
	$source_content = iconv("windows-1251", "UTF-8", $source_content);
	if (!$source_content) exit;
	$forums = new simple_html_dom();
	$forums->load($source_content);
	if ($forums == '') exit;	
	$forums = $forums->find('#d-forum', 0);
	
	foreach ($forums->find('.forum-line') as $forum)
	{
		$title = $forum->plaintext;
		$url = 'http://business.ngs.ru' . $forum->find('a', 0)->href;
				
		$forum_content = read($url);
		$forum_content = iconv("windows-1251", "UTF-8", $forum_content);
		if (!$forum_content) continue;
		$topic = new simple_html_dom();
		$topic->load($forum_content);
		$date = $topic->find('table.subjecttable .small', 0)->plaintext;
		$date = explode(' ', $date);
		$date = strftime("%Y-%m-%d", strtotime($date[2]));
		if ($date <= $last) continue; //нужны только новые
		
		sql_execute('INSERT IGNORE INTO ngs_forums (title,url,date) values("' . sql_prepare($title) . '","' . sql_prepare($url) . '","' . sql_prepare($date) . '");');		
	}
?>
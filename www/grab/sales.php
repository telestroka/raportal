<?php
	require_once('include/init.php');
	
	$last = sql_get_row('SELECT date FROM `ngs_sales` order by date desc limit 0,1;');
	$last = (isset($last['date'])) ? $last['date'] : '0000-00-00';
	
	for ( $page=0; $page<2; $page++ )
	{
		$source_url = 'http://business.ngs.ru/business_sales/?page=' . $page;
		$source_content = read($source_url);
		$source_content = iconv("windows-1251", "UTF-8", $source_content);
		if (!$source_content) continue;
		$sales = new simple_html_dom();
		$sales->load($source_content);
	
		foreach ($sales->find('.notice') as $sale)
		{
			$title = $sale->find('h2', 0)->plaintext;
			$url = 'http://business.ngs.ru' . $sale->find('h2 a', 0)->href;
			$date = $sale->find('.date', 0)->plaintext;
			$date = date('Y-m-d',strtotime(trim($date)));
			sql_execute('INSERT IGNORE INTO ngs_sales (title,url,price,date) values("' . sql_prepare($title) . '","' . sql_prepare($url) . '","' . sql_prepare($price) . '","' . sql_prepare($date) . '");');
		}
	}
?>
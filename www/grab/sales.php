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
		$sales = $sales->find('#sale-list', 0)->innertext;
		$sales = explode('<br /><br /><div class="lightgray-line"><spacer/></div><br />',$sales);
		if ( !is_array($sales) ) exit;
		if ( isset($sales[10]) ) unset($sales[10]);
		
		
		foreach ($sales as $adv)
		{
			$sale = new simple_html_dom();
			$sale->load($adv);
			
			$pieces = explode('<br />',$adv);
			$date = trim($pieces[0]);
			$date = strftime("%Y-%m-%d", strtotime($date));
			if ($date <= $last) continue; //нужны только новые
			
			$title = $sale->find('a', 0)->plaintext;
			$url = 'http://business.ngs.ru' . $sale->find('a', 0)->href;
			
			$price = strip_tags($pieces[2]);
			$price = str_replace('Цена: ','',$price);
			
			sql_execute('INSERT IGNORE INTO ngs_sales (title,url,price,date) values("' . sql_prepare($title) . '","' . sql_prepare($url) . '","' . sql_prepare($price) . '","' . sql_prepare($date) . '");');
		}
	}
?>
<?php
	require_once('../inc/init.inc'); 
	require_once('../init.inc');
	
	$items = sql_get_rows('SELECT * FROM ' . MODULE . ' ORDER BY id;');
	
	include(SITE_PATH . '/inc/doctype.inc'); 	            
?>
<head>
	<? include(SITE_PATH . '/inc/head.inc'); ?>
</head>
<body id="admin">
	<div id="container">
		<div id="content">
			<ul>
				<?
					foreach ($items as $item_id => $item_params)
					{
						echo '<li>
								' . $item_params['title'] . '
								<a href="admin/edit.php?mode=edit&id=' . $item_id . '">редактировать</a>
							</li>';
					}
				?>
			</ul>
			<a href="admin/edit.php">Добавить</a>
		</div>
	</div>
</body>
</html>
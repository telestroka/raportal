<?php
	require_once('../inc/init.inc'); 
	require_once('../init.inc');

	$id = $title = $text = $date = '';
	$result = false;
	
	$mode = assign('mode');
	if ($mode != 'edit') $mode = 'add';
	
	if ($_SERVER['REQUEST_METHOD'] == 'GET' && $mode == 'edit')
	{
		$id = sql_prepare( assign('id') );
		$item_info = sql_get_row('SELECT * FROM ' . MODULE . ' WHERE id = ' . $id . ';');
		if ($item_info)
		{
			$title = $item_info['title'];
			$text = $item_info['text'];	
		}
	}
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		$title = sql_prepare( assign('title') );
		$text = sql_prepare( assign('text') );
		$date = sql_prepare( date('Y-m-d') );
		
		if ($mode == 'add')
		{
			$result = sql_execute('INSERT IGNORE INTO `' . MODULE . '` (title, text, date) VALUES ("' . $title . '", "' . $text . '", "' . $date . '");');			
		}
		elseif ($mode == 'edit')
		{
			$id = sql_prepare( assign('id') );
			$result = sql_execute('UPDATE `' . MODULE . '` SET title = "' . $title . '", text = "' . $text . '", date = "' . $date . '" WHERE id = ' . $id . ';');
		}
	}	
	
	include(SITE_PATH . '/inc/doctype.inc'); 	            
?>
<head>
	<? include(SITE_PATH . '/inc/head.inc'); ?>
</head>
<body id="admin">
	<div id="container">
		<div id="content">
			<h3>
				<?
					if ($mode == 'add') echo 'Добавить';
					if ($mode == 'edit') echo 'Изменить';
				?>
			</h3>
			<? if ($result): ?>
				<p>Спасибо, ваши данные приняты.</p>
			<? else: ?>
				<form name="<?=MODULE;?>" method="post" action="<?=PAGE_URL;?>" class="mainform" style="width: 100%;">					
					<input name="id" type="hidden" maxlength="255"  value="<?=htmlspecialchars($id, ENT_QUOTES);?>"/>
					<label>Заголовок:</label>
					<input name="title" type="text" maxlength="255"  value="<?=htmlspecialchars($title, ENT_QUOTES);?>"/>
					
					<label>Текст:</label>
					<textarea name="text" rows="10" cols="17"><?=htmlspecialchars($text, ENT_QUOTES);?></textarea>
					
					<button type="submit" class="submit">
					<?
						if ($mode == 'add') echo 'Добавить';
						if ($mode == 'edit') echo 'Сохранить';
					?>
					</button>
				</form>
			<? endif; ?>
			<? if (!$result): ?>
				<script language="JavaScript" type="text/javascript" src="js/<?=MODULE;?>.js"></script>
				<script language="JavaScript" type="text/javascript" src="js/validation.js"></script>
			<? endif; ?>
		</div>
	</div>
</body>
</html>
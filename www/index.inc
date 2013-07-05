<b>Выпуск №<?=$issue;?> Новосибирск, <?=date('d.m.Y', $grab['time'] + 24 * 60 * 60);?></b>
<p>Каждый понедельник мы рассылаем подписчикам перечень заголовков, каждый из которых является ссылкой на соответствующую публикацию сайта <a href="http://business.ngs.ru/" target="_blank">НГС.БИЗНЕС</a>.</p>
<? if ($grab['forums']): ?>
<h2 class="green">Обсуждения</h2>
<ul>
	<?
		foreach ($grab['forums'] as $item_params)
			echo '<li><a href="' . $item_params['url'] . '" target="_blank">' . $item_params['title'] . '</a></li>';
	?>
</ul>
<? endif; ?>
<? if ($grab['sales']): ?>
<h2 class="green">Объявления</h2>
<ul>
	<?
		foreach ($grab['sales'] as $item_params)
			echo '<li><a href="' . $item_params['url'] . '" target="_blank">' . $item_params['title'] . ' ' . $item_params['price'] .  '</a></li>';
	?>
</ul>
<? endif; ?>
<? if ($grab['business_articles']): ?>
<h2 class="green">Статьи</h2>
<ul>
	<?
		foreach ($grab['business_articles'] as $item_params)
			echo '<li style="margin-bottom: 15px;"><a href="' . $item_params['url'] . '" target="_blank">' . $item_params['title'] . '</a><br/>' . $item_params['subtitle'] . '</li>';
	?>
</ul>
<? endif; ?>
<? if ($grab['best_article']): ?>
<h2 class="blue">Выбор народа</h2>
<p>Самая комментируемая статья на сайте НГС прошлой недели</p>
<a href="<?=$grab['best_article']['url'];?>" target="_blank"><?=$grab['best_article']['title'];?></a>
<span style="color: #0076A3;">Комментариев - <?=$grab['best_article']['comments'];?></span><br>
<?=$grab['best_article']['subtitle'];?>
<? endif; ?>
<div class="clear"></div>
<?	if ($issue < $last_issue): ?>
	<div class="floatleft nav"><a href="?issue=<?=$issue+1;?>"><<< Следующий</a></div>
<? endif; ?>
<?	if ($issue > 1): ?>
	<div class="floatright nav"><a href="?issue=<?=$issue-1;?>">Предыдущий выпуск >>></a></div>
<? endif; ?>
	

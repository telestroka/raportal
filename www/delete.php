<?php
	require_once('init.inc');
	
	if ( !isset($_GET['email']) || !preg_match('/^\w+@\w+\.\w+$/',$_GET['email']) ) exit('Ошибка.');
	$sql->SqlExecute('DELETE FROM ' . $module->NAME . ' WHERE email="' . $sql->SqlPrepare($_GET['email']) . '";');
	if (!$sql->SqlAffected()) exit('Указанный email не подписан.');
	
	//mail
	$message = '';
	foreach ($fields as $param => $value) $message .= $param . ': ' . $value . "<br/>";	
	require_once($site->PATH . '/lib/phpmailer.class');
	$mail = new PHPMailer();	
	$mail->CharSet = 'utf-8';
	$mail->AddReplyTo("info@raportal.ru",$from);
	$mail->SetFrom("info@raportal.ru",$from);
	$mail->AddAddress($site->EMAIL_OWNER, $site->EMAIL_OWNER);
	$mail->Subject = 'Рапортал - отписка';
	$mail->MsgHTML($message);
	$mail->Send();
	unset($mail);
	
	exit('Рассылка на указанный email прекращена.');	
?>
<?php
	require_once('../init.inc');
	
	$field_names = array('email');
	$required_fields = array('email');
	$fields = array();
	
	foreach ($field_names as $field)
	{
		if (!isset($_GET[$field])) exit('error');
		$fields[$field] = $_GET[$field];
	}
	
	//validate
	require_once($site->PATH . '/inc/validate.inc');
	
	//validate email
	$result = $sql->SqlCountRows('SELECT * FROM `' . $module->NAME . '` WHERE `email`="' . $sql->SqlPrepare($fields['email']) . '";');
	if ($result) exit('{"result":"error","errors":{"email":"Такой адрес уже подписан."}}');
	
	
	//additional info	
	$fields['ip'] = $_SERVER['REMOTE_ADDR'];
	$fields['date'] = date('Y-m-d');
	
	$values = $params = array();
	foreach ($fields as $param => $value)
	{
		$values[] = '"' . $sql->SqlPrepare($value) . '"';
		$params[] = '`' . $param . '`';
	}
	$sql->SqlExecute('INSERT INTO `' . $module->NAME . '` (' . implode(',', $params) . ') values(' . implode(',', $values) . ');');	
	
	//mail
	$message = '';
	foreach ($fields as $param => $value) $message .= $param . ': ' . $value . "<br/>";	
	require_once($site->PATH . '/lib/phpmailer.class');
	$mail = new PHPMailer();	
	$mail->CharSet = 'utf-8';
	$mail->AddReplyTo("info@raportal.ru",$from);
	$mail->SetFrom("info@raportal.ru",$from);
	$mail->AddAddress($site->EMAIL_OWNER, $site->EMAIL_OWNER);
	$mail->Subject = 'Рапортал - подписка';
	$mail->MsgHTML($message);
	$mail->Send();
	unset($mail);
	
	exit('{"result":"ok"}');
?>
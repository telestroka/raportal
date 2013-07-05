<?php
	require_once('../init.inc');
	require_once($site->PATH . '/lib/phpmailer.class');		
	
	$from = "Агентство Портал";
	
	$emails = $_POST['emails'];
	$text = $_POST['text'];
	$subject = $_POST['subject'];
	$text = stripslashes($text);
	
	$emails = explode("\n", $emails);
	foreach ( $emails as $email )
	{
		$email = trim($email);
		if ($email == '') continue;
		
		$mail = new PHPMailer();
		$mail->CharSet = 'utf-8';
		$mail->AddReplyTo("info@raportal.ru",$from);
		$mail->SetFrom("info@raportal.ru",$from);
		$mail->AddAddress($email, $email);
		$mail->Subject = $subject;
		$mail->MsgHTML(str_replace('EMAILPLACE',$email,$text));
		
		$mail->Send();
		unset($mail);
	}
	
	exit('{"result":"ok"}');
?>
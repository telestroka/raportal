<?php
/***********************************************
-=Ms Site=-

Автор: Миропольский Михаил <ms@ensk.ru>
Описание: Код подтверждения
***********************************************/

	require_once('lib/confirm.class');
    $confirm = new Confirm;

	if ( isset($_GET['code']) && preg_match('/\d{4}/', $_GET['code']) )
	{
		$code = $confirm->CipherDecode($_GET['code']);

	}
	else $code = '';

	$confirm->ConfirmGenerateImage($code);
?>
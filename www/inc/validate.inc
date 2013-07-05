<?php	
	require_once($site->PATH . '/lib/validate.class');
	$errors = array();
	foreach ($fields as $param => $value)
	{		
		$error = FALSE;
		if ( in_array($param, $required_fields) ) $error = Validate::ValidateEmpty($value);
		if ($value != '') $error = Validate::ValidateField($value, $param);		
		if ($error) $errors[] = '"' . $param . '":"' . $error . '"';
	}
	if ( count($errors) ) exit('{"result":"error","errors":{' . implode(',', $errors) . '}}');
?>
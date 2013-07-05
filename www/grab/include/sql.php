<?php
	$sql_login = 'root';
	$sql_password = '';
	$sql_db = 'raportal';
	$sql_host = 'localhost';
	
	function sql_execute($sql_query)
	{
		global $sql_connect;
		
		$sql_res = mysql_query($sql_query, $sql_connect);
		$sql_error = mysql_error();
		if ($sql_error) exit ($sql_error);
		
		return $sql_res;
	}
	function sql_prepare($value)
	{
		$value = trim($value);
		if (!get_magic_quotes_gpc()) $value = mysql_real_escape_string($value);
		
		return $value;
	}
	function sql_get_rows($sql_query)
	{
		$result = false;
		$sql_res = sql_execute($sql_query);
        while ($row = mysql_fetch_assoc($sql_res)) $result[$row['id']] = $row;
		return $result;
	}
	function sql_get_row($sql_query)
	{
		$result = false;
		$sql_res = sql_execute($sql_query);
		$result = mysql_fetch_assoc($sql_res);
		return $result;
	}
	function sql_count($sql_query)
	{
		$result = 0;
		$sql_res = sql_execute($sql_query);
		$result = mysql_num_rows($sql_res);
		return $result;
	}
	
	$sql_connect = mysql_connect($sql_host, $sql_login, $sql_password);
	if (!$sql_connect) exit ('');
	
	sql_execute('CREATE DATABASE IF NOT EXISTS ' . $sql_db);
	 mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
	 mysql_query("SET NAMES 'utf8'");

	if (!mysql_select_db($sql_db)) exit ('');
?>
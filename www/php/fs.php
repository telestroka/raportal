<?php	function read_dir($dir)	{		$files = array();		$dh  = @opendir($dir);		if (!$dh) exit('can\'t read dir');		while ( false !== ( $filename = readdir($dh) ) ) 			if ($filename != '.' && $filename != '..') $files[] = $filename;		return sort($files);	}		function write_file($path, $data, $mode)	{		$handle = fopen($path, $mode);		if (!$handle) exit('can\'t create file');		$result = fwrite($handle, $data);		if (!$result) exit('can\'t write file');		fclose($handle);		return $result;	}		function move_file($from, $to)	{		$content = file_get_contents($from);		unlink($from);				return write_file($to, $content, 'w');	}?>
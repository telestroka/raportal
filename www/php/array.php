<?php	function get_random_element($array)	{		$i = rand(0, count($array)-1);		return $array[$i];	}	function merge_array_items($array, $num) //merge some array items in one	{		$new_array = array('');		$i = 0; $j = 0;		foreach ($array as $value)		{			if (!isset($new_array[$i])) $new_array[$i] = '';			$new_array[$i] .= $value; $j++;			if ($j == $num) { $j = 0; $i++; }		}		return $new_array;	}?>
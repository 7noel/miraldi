<?php 

function arrayToAssociative($array, $key)
{
	$na = [];
	foreach ($array as $a) {
		if (isset($a[$key])) {
			$na[$a[$key]] = $a;
		}
	}
	return $na;
}

function holamundo()
{
	return "Saludo a todo el mundo";
}
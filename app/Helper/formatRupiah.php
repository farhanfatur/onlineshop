<?php 

function number_rupiah($number)
{
	$result = number_format($number,0,',','.');
	return $result;
}
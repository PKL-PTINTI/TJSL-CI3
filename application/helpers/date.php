<?php

function tanggal_helper($tanggal){
	$bulan = array (
		1 =>   'jan',
		'feb',
		'mar',
		'apr',
		'mei',
		'jun',
		'jul',
		'ags',
		'sep',
		'okt',
		'nov',
		'des'
	);
	$pecahkan = explode('-', $tanggal);
 
	return $bulan[(int)$pecahkan[1]] . $pecahkan[0];
}
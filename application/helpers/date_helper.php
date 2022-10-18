<?php

function remove_numbers($string) {
    $num = array(0,1,2,3,4,5,6,7,8,9);
    return str_replace($num, null, $string);
}

function periode_to_month($periode){
    $periode = remove_numbers($periode);
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
    return array_search($periode, $bulan);
}

function month_name($month){
    $bulan = array (
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    return $bulan[$month];
}

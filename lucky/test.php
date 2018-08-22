<?
$s1 = 'ㅎㅎ';
$s2 = iconv('UTF-8', 'EUC-KR', $s1); // EUC-KR


$len = str_len_byte($s1); // EA B0 80 (3 bytes)
echo $len ;


function str_len_byte($s){

    $a = unpack('C*', $s);
    $i = 0;
    $by = 0;
    foreach ($a as $v) {
        $h = strtoupper(dechex($v));
        if (strlen($h)<2) $h = '0'.$h;
        echo $h." ";
            ++$i;
    }


    return $i;

}


?>

<?php


function alphabet_position($string){
    $alphabet = str_split('abcdefghijklmnopqrstuvwxyz');
    $list = [];
    for ($j=0;$j<strlen($string);++$j) {
        if (in_array(strtolower($string[$j]), $alphabet)) {
            $list[] = (array_search(strtolower($string[$j]), $alphabet) + 1);
        }
    }
    return implode(" ", $list);
}
//print_r(alphabet_position('The sunset sets at twelve o\' clock.'));


function alphabet_position_advanced(string $s):string {
    return implode(' ', array_filter(array_map(function($x){
        return array_search($x, str_split('_abcdefghijklmnopqrstuvwxyz'));}, str_split(strtolower($s)))));
}


function decode_morse(string $code): string {
    return strtr(trim($code), MORSE_CODE + ['  ' => ' ',' ' => '']);
}

function dirReduc($arr) {
    $ops = ['NORTH' => 'SOUTH', 'SOUTH' => 'NORTH', 'EAST' => 'WEST', 'WEST' => 'EAST'];
    $stack = [];
    foreach ($arr as $k => $v) {
        if (end($stack) == $ops[$v]) {
            array_pop($stack);
        } else {
            $stack[] = $v;
        }
    }

    return $stack;
}

function encrypt($text, $n) {
    $str = "";
    if ($n > 0 && $text != empty($n)) {
        $fpart = "";
        $spart = "";
        while ($n != 0) {
            --$n;
            for ($a=0;$a<strlen($text);++$a) {
                if (($a % 2) != 0) {
                    $fpart .= $text[$a];
                }
            }
            for ($a=0;$a<strlen($text);++$a) {
                if (($a % 2) == 0) {
                    $spart .= $text[$a];
                }
            }
        }
        return $fpart . $spart;
    } else {return $text;}
}

function decrypt($text, $n) {
    $str = "";
    if ($n > 0 && $text != empty($n)) {
        while ($n != 0) {
            $cha = str_split($text, strlen($text) / 2);
            $ch = "";
            --$n;
            for ($a=0;$a<ceil(strlen($cha[0]));++$a) {
                $ch .= $cha[1][$a];
                $ch .= $cha[0][$a];
            }
        }
        return $ch;
    } else {return $text;}
}






// For building the encrypted string:
//Take every 2nd char from the string, then the other chars, that are not every 2nd char, and concat them as new String.
//Do this n times!
//
//Examples:
//
//"This is a test!", 1 -> "hsi  etTi sats!"
//"This is a test!", 2 -> "hsi  etTi sats!" -> "s eT ashi tist!"
//Write two methods:
//
//function encrypt($text, $n)
//function decrypt($text, $n)
//For both methods:
//If the input-string is null or empty return exactly this value!
//If n is <= 0 then return the input text.
function encrypt_adv($text, $n) {
    $result = $text;
    for ($i = 0; $i < $n; $i++) {
        $map = str_split($result, 1);
        $even = array_filter($map, function($k) { return ($k % 2 === 0); }, ARRAY_FILTER_USE_KEY);
        $odd  = array_filter($map, function($k) { return ($k % 2 !== 0); }, ARRAY_FILTER_USE_KEY);
        $result = implode('', $odd) . implode('', $even);
    }
    return $result;
}

function decrypt_adv($text, $n) {
    if ($n <= 0) return $text;
    $result = $text;
    for ($i = 0; $i < $n; $i++) {
        $map  = str_split($result, 1);
        $even = array_slice($map, 0, floor(count($map) / 2));
        $odd  = array_slice($map, floor(count($map) / 2));
        $result = '';
        for ($x = 0; $x < count($map); $x++) {
            $result .= ($x % 2 === 0) ? array_shift($odd) : array_shift($even);
        }

    }
    return $result;
}



function generateHashtag($str) {
    $str = preg_replace('/\s+/', ' ',$str);
    if (strlen($str)<=140 && !empty($str) && $str!= " ") {
        if (!preg_match('/\s/',$str)) {
            return "#" . ucfirst(implode('',array_unique(array_map(function ($y){return strtolower($y);},
                    str_split($str)))));
        } else {
            return "#" . implode('',array_map(function ($x){return ucfirst($x);},
                    array_unique(array_map(function ($y){return strtolower($y);}, explode(" ", $str)))));
        }
    } else {return false;}
}

function generateHashtag1($str) {
    $str = preg_replace('/\s+/', ' ',$str);
    if (strlen($str)<140 && !empty($str) && $str!= " ") {
        if (!preg_match('/\s/',$str)) {
            return "#" . ucfirst(implode('',array_map(function ($y){return strtolower($y);},
                    str_split($str))));
        } else {
            return "#" . implode('',array_map(function ($x){return ucfirst($x);},
                    array_unique(array_map(function ($y){return strtolower($y);}, explode(" ", $str)))));
        }
    } else {return false;}
}


function generateHashtag_adv($str) {

    $str = '#' . str_replace(' ', '', ucwords($str));

    return (strlen($str) > 140 || strlen($str) == 1) ? false : $str;
}

$node->getNext()



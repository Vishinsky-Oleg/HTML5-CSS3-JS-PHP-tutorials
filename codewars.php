<?php


function alphabet_position($string)
{
    $alphabet = str_split('abcdefghijklmnopqrstuvwxyz');
    $list = [];
    for ($j = 0; $j < strlen($string); ++$j) {
        if (in_array(strtolower($string[$j]), $alphabet)) {
            $list[] = (array_search(strtolower($string[$j]), $alphabet) + 1);
        }
    }
    return implode(" ", $list);
}
//print_r(alphabet_position('The sunset sets at twelve o\' clock.'));


function alphabet_position_advanced(string $s): string
{
    return implode(' ', array_filter(array_map(function ($x) {
        return array_search($x, str_split('_abcdefghijklmnopqrstuvwxyz'));
    }, str_split(strtolower($s)))));
}


// function decode_morse(string $code): string
// {
//     return strtr(trim($code), MORSE_CODE + ['  ' => ' ', ' ' => '']);
// }

function dirReduc($arr)
{
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

function encrypt($text, $n)
{
    $str = "";
    if ($n > 0 && $text != empty($n)) {
        $fpart = "";
        $spart = "";
        while ($n != 0) {
            --$n;
            for ($a = 0; $a < strlen($text); ++$a) {
                if (($a % 2) != 0) {
                    $fpart .= $text[$a];
                }
            }
            for ($a = 0; $a < strlen($text); ++$a) {
                if (($a % 2) == 0) {
                    $spart .= $text[$a];
                }
            }
        }
        return $fpart . $spart;
    } else {
        return $text;
    }
}

function decrypt($text, $n)
{
    $str = "";
    if ($n > 0 && $text != empty($n)) {
        while ($n != 0) {
            $cha = str_split($text, strlen($text) / 2);
            $ch = "";
            --$n;
            for ($a = 0; $a < ceil(strlen($cha[0])); ++$a) {
                $ch .= $cha[1][$a];
                $ch .= $cha[0][$a];
            }
        }
        return $ch;
    } else {
        return $text;
    }
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
function encrypt_adv($text, $n)
{
    $result = $text;
    for ($i = 0; $i < $n; $i++) {
        $map = str_split($result, 1);
        $even = array_filter($map, function ($k) {
            return ($k % 2 === 0);
        }, ARRAY_FILTER_USE_KEY);
        $odd  = array_filter($map, function ($k) {
            return ($k % 2 !== 0);
        }, ARRAY_FILTER_USE_KEY);
        $result = implode('', $odd) . implode('', $even);
    }
    return $result;
}

function decrypt_adv($text, $n)
{
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



function generateHashtag($str)
{
    $str = preg_replace('/\s+/', ' ', $str);
    if (strlen($str) <= 140 && !empty($str) && $str != " ") {
        if (!preg_match('/\s/', $str)) {
            return "#" . ucfirst(implode('', array_unique(array_map(
                function ($y) {
                    return strtolower($y);
                },
                str_split($str)
            ))));
        } else {
            return "#" . implode('', array_map(
                function ($x) {
                    return ucfirst($x);
                },
                array_unique(array_map(function ($y) {
                    return strtolower($y);
                }, explode(" ", $str)))
            ));
        }
    } else {
        return false;
    }
}

function generateHashtag1($str)
{
    $str = preg_replace('/\s+/', ' ', $str);
    if (strlen($str) < 140 && !empty($str) && $str != " ") {
        if (!preg_match('/\s/', $str)) {
            return "#" . ucfirst(implode('', array_map(
                function ($y) {
                    return strtolower($y);
                },
                str_split($str)
            )));
        } else {
            return "#" . implode('', array_map(
                function ($x) {
                    return ucfirst($x);
                },
                array_unique(array_map(function ($y) {
                    return strtolower($y);
                }, explode(" ", $str)))
            ));
        }
    } else {
        return false;
    }
}


function generateHashtag_adv($str)
{
    $str = '#' . str_replace(' ', '', ucwords($str));
    return (strlen($str) > 140 || strlen($str) == 1) ? false : $str;
}











//You are given an array strarr of strings and an integer k. Your task is to return the first longest string consisting of k consecutive strings taken in the array.
//
//Example:
//longest_consec(["zone", "abigail", "theta", "form", "libe", "zas", "theta", "abigail"], 2) --> "abigailtheta"
//
//n being the length of the string array, if n = 0 or k > n or k <= 0 return "".
//
//    Note
//consecutive strings : follow one after another without an interruption
function longestConsec($strarr, $k)
{
    if (count($strarr) > 0 && $k <= count($strarr) && $k > 0) {
        $eachLen = array_map('strlen', $strarr);
        return implode('', array_slice($strarr, array_search(max($eachLen), $eachLen), $k));
    } else {
        return "";
    }
}

//$val = ["zone", "abigail", "theta", "form", "libe", "zas"];
//$val = [];
//$leng = array_map('strlen', $val);
//print_r($val[array_search(max($leng), $leng)]);
//echo $val[array_search(max($leng), $leng)] == end($val)? 'Is is end': 'It is not';

//print_r(longestConsec(["ejjjjmmtthh", "zxxuueeg", "aanlljrrrxx", "dqqqaaabbb", "oocccffuucccjjjkkkjyyyeehh"], 1));

function longestConsec_adv($strarr, $k)
{
    $longest = '';
    if ($k > 0) {
        for ($i = 0; $i < count($strarr) - $k + 1; $i++) {
            $consecutive = implode('', array_slice($strarr, $i, $k));
            $longest = strlen($consecutive) > strlen($longest) ? $consecutive : $longest;
        }
    }
    return $longest;
}


function alphanumeric(string $s): bool
{
    if (preg_match("/[^a-zA-Z0-9\S-]/", $s) || empty($s)) {
        return false;
    } else return true;
}

function alphanumeric_adv(string $s): bool
{
    // Your code here
    return ctype_alnum($s);
}

//echo alphanumeric('Mazinkaiser') ? "True": "False";
//echo alphanumeric('hello world_') ? "True": "False";
//echo alphanumeric('PassW0rd') ? "True": "False";
//echo alphanumeric('     ') ? "True": "False";
//echo alphanumeric('hello world') ? "True": "False";
//echo alphanumeric('hello-world') ? "True": "False";
//echo alphanumeric('') ? "True": "False";













//For a given chemical formula represented by a string, count the number of atoms of each element contained in the molecule and return an object (associative array in PHP, Dictionary<string, int> in C#, Map<String,Integer> in Java).
//
//For example:
//
//    parse_molecule('H2O'); // => ['H' => 2, 'O' => 1]
//    parse_molecule('Mg(OH)2'); // => ['Mg' => 1, 'O' => 2, 'H' => 2]
//    parse_molecule('K4[ON(SO3)2]2'); // => ['K' => 4, 'O' => 14, 'N' => 2, 'S' => 4]
//    As you can see, some formulas have brackets in them. The index outside the brackets tells you that you have to multiply count of each atom inside the bracket on this index. For example, in Fe(NO3)2 you have one iron atom, two nitrogen atoms and six oxygen atoms.
//
//Note that brackets may be round, square or curly and can also be nested. Index after the braces is optional.

function parse_molecule(string $formula): array
{
    $molecule = '(' . $formula . ')';
    do {
        $molecule = preg_replace_callback('/[\(\[\{](\w+)[\)\]\}](\d+)?/', function ($matches) {
            return parseBrackets($matches[1], $matches[2] ?? 1);
        }, $molecule, -1, $count);
    } while ($count);

    $atoms = [];
    preg_match_all('/([A-Z][a-z]*)(\d+)?/', $molecule, $matches, PREG_SET_ORDER);
    foreach ($matches as $match) {
        $atom = $match[1];
        $atoms[$atom] =  ($atoms[$atom] ?? 0) + $match[2];
    }
    return $atoms;
}

function parseBrackets($string, $multiply)
{
    return preg_replace_callback('/([A-Z][a-z]*)(\d+)?/', function ($matches) use ($multiply) {
        return $matches[1] . ($matches[2] ?? 1) * $multiply;
    }, $string);
}





















function array_permutation($input, $num)
{
    $perms = $indexed = $output = array();
    $base = count($input);
    $i = 0;

    foreach ($input as $in) {
        $indexed[$i++] = $in;
    }

    foreach (range(0, pow($base, $num) - 1) as $i) {
        $perms[] = sprintf("%'0{$num}d", base_convert($i, 10, $base));
    }

    foreach (array_filter($perms, 'catch_duplicate_chars') as $perm) {
        $temp = array();

        foreach (str_split($perm) as $digit) {
            $temp[] = $indexed[$digit];
        }
        $output[] = $temp;
    }

    return $output;
}

function catch_duplicate_chars($val)
{
    $arr = str_split($val);
    return $arr == array_unique($arr);
}

//$test = array_permutation(array('3', '5', '1'), 3);
//var_dump($test);


//$display = '';
//foreach ($test as $row) {
//    $display .= implode('', $row) . '<br>';
//}
//print $display;


















//print_r(nextBigger(151));
//$array = str_split('351');
//
//
//for ($j=0;$j<count($array);++$j) {
//    shuffle($array);
//    print_r($array);
//    print_r(implode('', $array));

function nextBigger($n)
{
    $pattern = "/[" . $n . "]{3}/";
    $fount = false;
    while (!$fount) {
        ++$n;
        if (preg_match($pattern, $n)) {
            $fount = true;
            return $n;
        }
    }
}



$intervals = [
    [1, 5],
    [10, 20],
    [1, 6],
    [16, 19],
    [5, 11]
];

function sum_intervals($intervals)
{
    $new = [];
    //    foreach ($intervals as $ar) {
    //        for ($a=0;$a<count($intervals);++$a) {
    //            if (!empty(array_intersect(range($ar[0], $ar[1]), range($intervals[$a][0], $intervals[$a][1])))) {
    //                $new[] = [min($ar[0], $intervals[$a][0]), max($ar[1], $intervals[$a][1])];
    //                unset($intervals[$a]);
    //            } else ($new[] = $ar);
    //        }
    //    }
    //    return $new;


    foreach ($intervals as $item) {
        if (array_walk($intervals, function ($th) use ($item) {
            return !empty(array_intersect(range($item[0], $item[1]), range($th[0], $th[1])));
        })) {
            $new[] = $item;
        }
    }
    return $new;
}

//print_r(sum_intervals($intervals));



$testcase = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

function josephus($items, $k)
{
    $index = 0;
    $jo = [];
    $number = count($items);
    while (count($jo) <= $number) {
        ++$index;
        echo $index . '<br>';

        if ($index = $k - 1) {
            $jo[] = $items[$index];
            unset($items[$index]);
            array_values($items);

            $index = 0;
        }
    }
    return $jo;
}

print_r(josephus($testcase, 2));


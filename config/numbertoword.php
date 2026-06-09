<?php

function numberToWords($number)
{
    $ones = array(
        0 => '',
        1 => 'One',
        2 => 'Two',
        3 => 'Three',
        4 => 'Four',
        5 => 'Five',
        6 => 'Six',
        7 => 'Seven',
        8 => 'Eight',
        9 => 'Nine',
        10 => 'Ten',
        11 => 'Eleven',
        12 => 'Twelve',
        13 => 'Thirteen',
        14 => 'Fourteen',
        15 => 'Fifteen',
        16 => 'Sixteen',
        17 => 'Seventeen',
        18 => 'Eighteen',
        19 => 'Nineteen'
    );

    $tens = array(
        2 => 'Twenty',
        3 => 'Thirty',
        4 => 'Forty',
        5 => 'Fifty',
        6 => 'Sixty',
        7 => 'Seventy',
        8 => 'Eighty',
        9 => 'Ninety'
    );

    if ($number < 20) {
        return $ones[$number];
    }

    if ($number < 100) {
        return $tens[floor($number / 10)] . ' ' . $ones[$number % 10];
    }

    if ($number < 1000) {
        return $ones[floor($number / 100)] . ' Hundred ' .
            (($number % 100) ? numberToWords($number % 100) : '');
    }

    if ($number < 100000) {
        return numberToWords(floor($number / 1000)) . ' Thousand ' .
            (($number % 1000) ? numberToWords($number % 1000) : '');
    }

    if ($number < 10000000) {
        return numberToWords(floor($number / 100000)) . ' Lakh ' .
            (($number % 100000) ? numberToWords($number % 100000) : '');
    }

    return numberToWords(floor($number / 10000000)) . ' Crore ' .
        (($number % 10000000) ? numberToWords($number % 10000000) : '');
}

// Example
//$amount = 12345678;
//echo numberToWords($amount);
?>
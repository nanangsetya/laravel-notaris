<?php
if (!function_exists('thousand_sep')) {
    function thousand_sep($string)
    {
        return number_format($string, 0, ',', '.');
    }
}

if (!function_exists('rupiah')) {
    function rupiah($string)
    {
        return "Rp. " . number_format($string, 0, ',', '.') . ",00";
    }
}

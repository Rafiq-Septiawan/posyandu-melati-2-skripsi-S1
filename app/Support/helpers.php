<?php

if (!function_exists('fmtAngka')) {
    function fmtAngka($value)
    {
        if ($value === null || $value === '') {
            return '-';
        }
        return rtrim(rtrim(number_format((float) $value, 2, '.', ''), '0'), '.');
    }
}

<?php

if (!function_exists('getMonthUkr')) {
    function getMonthUkr($date): string
    {
        $monthNumber = date('m', strtotime($date));
        $monthUkr = ['січня', 'лютого', 'березня', 'квітня', 'травня', 'червня', 'липня', 'серпня', 'вересня', 'жовтня', 'листопада', 'грудня'];
        return $monthUkr[--$monthNumber];
    }
}

if (!function_exists('pibConverter')) {
    function pibConverter($pib): string
    {
        $pib = preg_replace("/\s+/", ' ', trim($pib));
        $pibArr = explode(' ', $pib);
        $pibShort = '';

        foreach ($pibArr as $pibKey => $pibValue) {
            if ($pibKey == 0) {
                $pibShort = $pibValue;
            }

            if ($pibKey == 1 || $pibKey == 2) {
                $pibShort = $pibShort . ' ' . substr($pibValue, 0, 2) . '.';
            }
        }

        return $pibShort;
    }
}

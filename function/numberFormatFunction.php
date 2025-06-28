<?php

if (!function_exists('eMony')) {
    function eMony($data, $kop = 2)
    {
        return number_format($data, $kop, ',', ' ') . ' ₽';
    }
}

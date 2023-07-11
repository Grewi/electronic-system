<?php

function eMony($data, $kop = 2){
    return number_format($data, $kop, ',', ' ') . ' ₽';
}
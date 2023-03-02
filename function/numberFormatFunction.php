<?php

function eMony($data){
    return number_format($data, 2, ',', ' ') . ' ₽';
}
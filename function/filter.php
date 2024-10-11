<?php

/**
 * Функции отвечают за формирование элементов форм фильтрации
 * Основная задача сформировать правильно сформировать значение параметра тега name
 * Функции являются, по сути, обёртками для методов класса filters
 */

use system\core\model\forms\filters;

if (!function_exists('filterInput')) {
    /**
     * Формирует input, значение типа, по умолчанию, text, но можно передать любой в массиве параметров
     * @param mixed $name
     * @param mixed $params
     * @return string
     */
    function filterInput($name, $params = [])
    {
        return filters::filterInput($name, $params);
    }
}

if (!function_exists('filterSelect')) {
    /**
     * Формирует выпадающий список, список опций передаётся массивом объектов
     * @param string $name
     * @param mixed $params
     * @param string $defaultText - Верхняя не активная строка, выводится если нет выбранного значения
     * @param array $options - массив объектов
     * @param mixed $valColumn - Имя параметра для value
     * @param mixed $nameColumn - Имя параметра для наименования
     * @return string
     */
    function filterSelect(string $name, $params = [], string $defaultText = null, array $options = [], $valColumn = 'id', $nameColumn = 'name'): string
    {
        return filters::filterSelect($name, $params, $defaultText, $options, $valColumn, $nameColumn);
    }
}

if (!function_exists('filterRangeMin')) {
    /**
     * input для минимального значения в диапазоне
     * @param string $name
     * @param array $params
     * @param mixed $type - тип input, по умолчанию number
     * @return string
     */
    function filterRangeMin(string $name, array $params = [], $type = 'number'): string
    {
        return filters::filterRange($name, $params, 'min', $type);
    }
}

if (!function_exists('filterRangeMax')) {
    /**
     * input для максимального значения в диапазоне
     * @param string $name
     * @param array $params
     * @param mixed $type - тип input, по умолчанию number
     * @return string
     */
    function filterRangeMax(string $name, array $params = [], $type = 'number'): string
    {
        return filters::filterRange($name, $params, 'max', $type);
    }
}
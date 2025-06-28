<?php
use system\core\model\forms\sort;

if (!function_exists('sortLink')) {
    /**
     * Функция формирует ссылку выбора колонки для сортировки
     * @param string $name - наименование таблицы
     * @param string $lang - текст ссылки
     * @param array $params - Массив параметров тегов ссылки (id, class и т.д.)
     * @param string $iconDesc
     * @param string $iconAsc
     * @return string
     */
    function sortLink(string $name, string $lang, array $params = [], string $iconDesc = null, string $iconAsc = null)
    {
        $iconDesc = $iconDesc ? $iconDesc : '<i class="bi bi-sort-up-alt"></i>';
        $iconAsc = $iconAsc ? $iconAsc : '<i class="bi bi-sort-up"></i>';
        return sort::sortLink($name, $lang, $params, $iconDesc, $iconAsc);
    }
}
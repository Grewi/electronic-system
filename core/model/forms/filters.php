<?php 

namespace system\core\model\forms;

class filters{

    public static function filterInput(string $name, array $params = [])
    {
        $value = isset($_GET['filter_' . $name]) ? $_GET['filter_' . $name] : '';
        $dParams = [
            'value' => $value,
            'name' => 'filter_' . $name,
            'type' => 'text',
        ];
        $n = '';
        foreach(array_merge($dParams, $params) as $a => $i){
            $n .= ' ' . $a . '="' . $i . '"';
        }
        return '<input ' . $n . ' />';
    }

    public static function filterSelect(string $name, array $params = [], string $defaultText = null, array $options = [], $valColumn = 'id', $nameColumn = 'name')
    {
        $value = isset($_GET['filter_' . $name]) ? $_GET['filter_' . $name] : '';
        $dParams = [
            'name' => 'filter_' . $name,
        ];
        $n = '';
        foreach(array_merge($dParams, $params) as $a => $i){
            $n .= ' ' . $a . '="' . $i . '"';
        }
        $r = '<select ' . $n . '>' . PHP_EOL;
        if($defaultText){
            $r .= '<option value="" ' . (empty($value) ? 'selected disabled' : '') . ' >' . $defaultText . '</option>' . PHP_EOL;
        }
        foreach($options as $a => $i){
            $name = $i->{$nameColumn};
            $val = $i->{$valColumn};
            $selected = $val == $value ? 'selected' : '';
            $r .= '<option value="' . $val . '" ' . $selected . '>' . $name . '</option>' . PHP_EOL;
        }
        $r .= '</select>' . PHP_EOL;
        return $r;
    }

    public static function filterRange(string $name, array $params = [], $minMax = 'min', $type = 'number')
    {
        $value = isset($_GET['filter_' . $name][$minMax]) ? $_GET['filter_' . $name][$minMax] : '';
        $dParams = [
            'value' => $value,
            'name' => 'filter_' . $name . '[' . ($minMax == 'min' ? 'min' : 'max') . ']',
            'type' => $type,
        ];
        $n = '';
        foreach(array_merge($dParams, $params) as $a => $i){
            $n .= ' ' . $a . '="' . $i . '"';
        }
        return '<input ' . $n . ' />';
    }
}
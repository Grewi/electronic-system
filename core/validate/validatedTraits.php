<?php

declare(strict_types=1);

namespace system\core\validate;

use system\core\database\database;
use system\core\csrf\csrf;

trait validatedTraits
{

    /**
     * Проверяет токен csrf 
     * @param string $name имя токена
     * @return static
     */
    public function csrf(string $name)
    {
        $data = $this->data[$this->currentName];
        $a = null;
        
        if (isset($_SESSION['csrf'][$name])) {
            $a = $_SESSION['csrf'][$name];
        }

        if ($data != $a) {
            $this->error[$this->currentName][] = lang('valid', 'csrf');
            $this->setControl(false);
        }
        $this->setReturn($data);
        return $this;
    }

    /**
     * Проверяет на "пустоту" значения
     * @return static
     */
    public function empty()
    {
        $data = $this->data[$this->currentName];
        if (empty(strip_tags($data ?? ''))) {
            $this->error[$this->currentName][] = lang('valid', 'noEmpty');
            $this->setControl(false);
        }
        $this->setReturn($data);
        return $this;
    }

    /**
     * Значение должно быть целочисленным числом
     * @return static
     */
    public function int()
    {
        $data = $this->data[$this->currentName];
        if (!empty($data) && !preg_match("/^[0-9]+$/u", (string)$data)) {
            $this->error[$this->currentName][] = lang('valid', 'noInt');
            $this->setControl(false);
        }
        $this->setReturn($data);
        return $this;
    }

    /**
     * Значение не должно быть менее указаного
     * @param int $min
     * @return static
     */
    public function min(int $min)
    {
        $data = $this->data[$this->currentName];
        if (!empty($data) && $data < $min) {
            $this->error[$this->currentName][] = lang('valid', 'noMin');
            $this->setControl(false);
        }
        $this->setReturn($data);
        return $this;
    }

    /**
     * Значение не должно быть более указанного
     * @param int $max
     * @return static
     */
    public function max(int $max)
    {
        $data = $this->data[$this->currentName];
        if (!empty($data) && $data > $max) {
            $this->error[$this->currentName][] = lang('valid', 'noMax');
            $this->setControl(false);
        }
        $this->setReturn($data);
        return $this;
    }

    /**
     * Значение должно быть числом с плавающей запятой
     * @return static
     */
    public function float()
    {
        $data = $this->data[$this->currentName];
        if (!empty($data) && !preg_match("/^[0-9\.\,]+$/u", (string)$data)) {
            $this->error[$this->currentName][] = lang('valid', 'noInt');;
            $this->setControl(false);
        }
        $data = str_replace(',', '.', $data);
        $this->setReturn($data);
        return $this;
    }

    /**
     * Значение будет преобразовано в булевое значение
     * @param bool|null $bool
     * @return static
     */
    public function bool($bool = null)
    {
        $data = $this->data[$this->currentName];
        if (!is_null($bool) && $bool && (bool)$bool != (bool)$data) {
            $this->error[$this->currentName][] = lang('valid', 'boolTrue');
            $this->setControl(false);
        }
        if (!is_null($bool) && !$bool && (bool)$bool != (bool)$data) {
            $this->error[$this->currentName][] = lang('valid', 'boolFalse');
            $this->setControl(false);
        }
        if ($data) {
            $this->setReturn(1);
        } else {
            $this->setReturn(0);
        }
        return $this;
    }

    /**
     * Значение может содержать только латинские, киреллические символы и цифры
     * @return static
     */
    public function latRuInt()
    {
        $data = $this->data[$this->currentName];
        if (!empty($data) && !preg_match("/^[\s a-zA-Z0-9а-яА-ЯёЁ\-_]+$/u", $data)) {
            $this->error[$this->currentName][] = lang('valid', 'latRuInt');
            $this->setControl(false);
        }
        $this->setReturn($data);
        return $this;
    }

    /**
     * Значение может содержать только латинские символы и цифры
     * @return static
     */
    public function latInt()
    {
        $data = $this->data[$this->currentName];
        if (!empty($data) && !preg_match("/^[\s a-zA-Z0-9\-_]+$/u", $data)) {
            $this->error[$this->currentName][] = lang('valid', 'latInt');
            $this->setControl(false);
        }
        $this->setReturn($data);
        return $this;
    }

    /**
     * Значение может содержать только киреллические символы
     * @return static
     */
    public function ru()
    {
        $data = $this->data[$this->currentName];
        if (!empty($data) && !preg_match("/^[\s а-яА-ЯёЁ\.]+$/u", $data)) {
            $this->error[$this->currentName][] = lang('valid', 'ru');
            $this->setControl(false);
        }
        $this->setReturn($data);
        return $this;
    }

    /**
     * Значение проверяется на соответствие правилам написания почты
     * @return static
     */
    public function mail()
    {
        $this->data[$this->currentName] = $this->data[$this->currentName] ? mb_strtolower($this->data[$this->currentName]) : '';
        $data = $this->data[$this->currentName];
        if (!empty($data) && !preg_match("/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/u", $data)) {
            $this->error[$this->currentName][] = lang('valid', 'mail');
            $this->setControl(false);
        }
        $this->setReturn($data);
        return $this;
    }

    /**
     * Значение проверяется на правильность написания  телефона по Российским стандартам
     * @param bool $clean
     * @return static
     */
    public function tel()
    {
        $data = $this->data[$this->currentName];
        if (!empty($data) && preg_match("/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?([\d\- ]{7,10})$/u", $data)) {
            $this->error[$this->currentName][] = lang('valid', 'tel');
            $this->setControl(false);
        }
        $this->setReturn($data);
        return $this;
    }

    public function url()
    {
        $data = $this->data[$this->currentName];
        if (!empty($data) && preg_match("/^(https?:\/\/)?([\da-z\.-]+)?\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/u", $data)) {
            $this->error[$this->currentName][] = lang('valid', 'tel');
            $this->setControl(false);
        }
        $this->setReturn($data);
        return $this;
    }

    /**
     * Значение проверяется на соответствие написания даты 
     * @return static
     */
    public function date()
    {
        $this->data[$this->currentName] = !empty($this->data[$this->currentName]) ? $this->data[$this->currentName] : null;
        $data = $this->data[$this->currentName];
        if (!empty($data)) {
            $test = explode('-', $data);
            $check = false;
            if (@checkdate((int)$test[1], (int)$test[2], (int)$test[0])) {
                $check = true;
            }

            if (!preg_match("/^[0-9\-]+$/u", $data) && !$check) {
                $this->error[$this->currentName][] = lang('valid', 'date');
                $this->setControl(false);
            }
        }

        $this->setReturn($data);
        return $this;
    }

    /**
     * Значение преобразует символы в html сущности функцией htmlspecialchars
     * @return static
     */
    public function text()
    {
        $data = $this->data[$this->currentName] ? htmlspecialchars($this->data[$this->currentName]) : '';
        $this->setReturn($data);
        return $this;
    }

    /**
     * Проверка на уникальность записи в базе данных
     * @param string $table Имя таблицы
     * @param string $col Имя стобца
     * @param int $id id исключение (0 если не требуется)
     * 
     * @return static
     */
    public function unique(string $table, string $col, int $id = 0)
    {
        $data = $this->data[$this->currentName];
        $db = database::connect();

        $errorText = $this->errorText ? $this->errorText : lang('valid', 'unique');

        $i = $db->fetch('SELECT COUNT(*) as `count`  FROM `' . $table . '` WHERE `' . $col . '` = :data AND id != :id', ['data'  => $data, 'id' => $id]);

        if (!empty($data) && !empty($i->count)) {
            $this->error[$this->currentName][] = $errorText;
            $this->setControl(false);
        }
        $this->setReturn($data);
        return $this;
    }


    /**
     * Проверка на наличие записи в базе данных
     * @param string $table Имя таблицы
     * @param string $col Имя стобца
     * @param int $id id исключение (0 если не требуется)
     * 
     * @return static
     */
    public function id(string $table, string $col, int $id)
    {
        $data = $this->data[$this->currentName];
        $errorText = $this->errorText ? $this->errorText : lang('valid', 'unique');

        $i = db()->fetch('SELECT COUNT(*) as `count`  FROM `' . $table . '` WHERE `' . $col . '` = :data AND id != :id', ['data'  => $data, 'id' => $id]);

        if (!empty($data) && !empty($i->count)) {
            $this->error[$this->currentName][] = $errorText;
            $this->setControl(false);
        }
        $this->setReturn($data);
        return $this;
    }

    public function isset(string $table, string $col = 'id')
    {
        $data = $this->data[$this->currentName];
        if (!empty($data)) {
            $errorText = $this->errorText ? $this->errorText : 'Значение отсутствует';
            $i = db()->fetch('SELECT COUNT(*) as count FROM ' . $table . ' WHERE ' . $col . ' = :data', ['data' => $data]);
            if (!(int)$i->count) {
                $this->error[$this->currentName][] = $errorText;
                $this->setControl(false);
            }
        }
        $this->setReturn($data);
        return $this;
    }

    /**
     * Длина строки
     * @param string|int $strlen
     * @return static
     */
    public function strlen($strlen)
    {
        $data = $this->data[$this->currentName];
        $errorText = $this->errorText ? $this->errorText : sprintf(lang('valid', 'strlen'), (string)$strlen);
        if (!empty($data) && mb_strlen((string)$data) != $strlen) {
            $this->error[$this->currentName][] = $errorText;
            $this->setControl(false);
        }
        $this->setReturn($data);
        return $this;
    }

    /**
     * Минимальная длина строки
     * @param int|string $strlen
     * @return static
     */
    public function strlenMin($strlen)
    {
        $data = $this->data[$this->currentName];
        $errorText = $this->errorText ? $this->errorText : sprintf(lang('valid', 'strlenMin'), (string)$strlen);
        if (!empty($data) && mb_strlen((string)$data) < $strlen) {
            $this->error[$this->currentName][] = $errorText;
            $this->setControl(false);
        }
        $this->setReturn($data);
        return $this;
    }


    /**
     * Максимальная длина строки
     * @param string|int $strlen
     * @return static
     */
    public function strlenMax($strlen)
    {
        $data = $this->data[$this->currentName];
        $errorText = $this->errorText ? $this->errorText : sprintf(lang('valid', 'strlenMax'), (string)$strlen);
        if (!empty($data) && mb_strlen((string)$data) > $strlen) {
            $this->error[$this->currentName][] = $errorText;
            $this->setControl(false);
        }
        $this->setReturn($data);
        return $this;
    }

    public function free($regex)
    {
        $data = $this->data[$this->currentName];
        if (!empty($data) && !preg_match($regex, (string)$data)) {
            $this->error[$this->currentName][] = lang('valid', 'noRegex');
            $this->setControl(false);
        }
        $this->setReturn($data);
        return $this;
    }
}

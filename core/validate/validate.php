<?php declare(strict_types=1);

namespace system\core\validate;
use system\core\validate\validatedTraits;
use system\core\validate\validetePassTrait;
use system\core\validate\validBuhcrmTrait;
use system\core\validate\toTrait;

class validate
{
    protected $control = true; //Результат проверки всех данных в объекте
    protected $data    = [];   //Поступившие данные в объект
    protected $return  = [];   //Результат проверки (если проверка не пройдена, метод может вернуть null)
    protected $error   = [];   //Массив ошибок.
    protected $currentName = ''; //Текущее имя
    protected $errorText = null; //Текст ошибки переданный из контроллера

    use validatedTraits;
    use validetePassTrait;
    use toTrait;

    public function name(string $name, $value = null) : validate
    {
        
        if(!is_null($value)){
            $data = $value;
        }elseif(is_null($value) && isset($_REQUEST[$name])){
            $data = $_REQUEST[$name];
        }else{
            $data = null;
        }
        $value = (string) $value;
        $this->data[$name] = $data;
        $this->currentName = $name;
        $this->return[$name] = false;
        $this->errorText = null;
        return $this;
	}

    protected function setReturn($data)
    {
        $this->return[$this->currentName] = $data;
    }

    /**
     * 
     * @var Общий индикатор для всех проверок
     */
    public function control(): bool 
    {
        if(!$this->control){
            $_SESSION['data'] = $this->data();
            $_SESSION['error'] = $this->error();
        }
        return $this->control;
    }

    /**
     * @var Устанавливает значение общего индикатора
     */
    protected function setControl(bool $param): void 
    {
        if ($this->control === true && $param === false) {
            $this->control = false;
        }
    }
    
    /**
     * @var Возвращает список ошибок
     */
    public function error(): array 
    {
        $result = [];
        if (!empty($this->error)) {
            foreach ($this->error as $a => $i) {
                if (!empty($i)) {
                    $c = implode(', ', $i);
                    $result[$a] = $c;
                }
            }
        }
        return $result;
    }

    /**
    * @var Устанавливает текст ошибки 
    */
    public function errorText(string $text) : validate
    {
        $this->errorText = $text;
        return $this;
    }
    
    /**
     * @var Возвращает необработанные значения
     */
    public function data():array 
    {
        return $this->data;
    }

    public function return(string $i = null)
    {
        if($i){
            if(isset($this->return[$i])){
                return $this->return[$i];
            }else{
                return null;
            }
        }else{
            unset($this->return['csrf']);
            return $this->return;
        }
    }
}
<?php
namespace system\core\model;

class where{
    protected $_id = 'id';
    public $data = [];
    private $text = 'WHERE ';
    private $bind = [];
    private $count = 0;
    private $start = null;

    private function getStart()
    {
        $a = $this->start;
        $this->start = null;
        return $a;
    }

    private function start($start)
    {
        return $this->getStart() ?? $start;
    }

    public function or()
    {
        $this->start = '||';
    }

    public function and()
    {
        $this->start = '&&';
    }

    public function generatorSql()
    {
        $this->generatorAction($this->data, $this->text, $this->bind, $this->count);
    }

    public function getSql()
    {
        return $this->text;
    }

    public function getBind()
    {
        return $this->bind;
    }

    public function where($p1, $p2 = null, $p3 = null)
    {
        $d['start'] = '&&';
        if(is_null($p2) && is_null($p3)){
            $d['simple'] = [$this->_id, '=', $p1];
        }elseif(is_null($p3)){
            $d['simple'] = [$p1, '=', $p2];
        }else{
            $d['simple'] = [$p1, $p2, $p3];
        }
        $this->data[] = $d;
    }

    public function whereL($p1, $p2, $p3)
    {
        $d['start'] = '&&';
        $d['simple'] = [$p1, $p2, $p3];
        $this->data[] = $d;
        dd($this->data);
    }

    public function group($start, $func)
    {
        $a = (new static);
        $func($a);
        $d['start'] = $start;
        $d['callable'] = $a->data;
        $this->data[] = $d;
    }

    public function whereNull($p)
    {
        $d['start'] = '&&';
        $d['notnull'] = [$p, ' IS NULL '];
        $this->data[] = $d;
    }

    public function whereNotNull($p)
    {
        $d['start'] = '&&';
        $d['notnull'] = [$p, ' IS NOT NULL '];
        $this->data[] = $d;
    }   
    
    public function whereIn($p, array $arr)
    {
        if(empty($arr)){
            return;
        }
        $d['start'] = '&&';
        $str = ' `' . $p . '` IN ';
        $d['in'] = [$p, $str, $arr];
        $this->data[] = $d;
    }

    private function generatorAction(array $where, &$text, &$bind, &$count)
    {
        foreach ($where as $a => $i) {
            ++$count;
            if ($a != 0) {
                $text .= $i['start'] . ' ';
            }

            if(!empty($i['simple'])){
                $s = $i['simple'];
                $n = '';
                $n = ':' . $s[0] . '_' . $count;
                $bind[] = [$n => $s[2]];                        
                $text .= ' `' . $s[0] . '` ' . $s[1] . ' ' . $n . ' ';                
            }

            if(!empty($i['notnull'])){
                $s = $i['notnull'];                    
                $text .= ' `' . $s[0] . '` ' . $s[1];                
            }

            if (!empty($i['callable'])) {
                $text .= ' (';
                $this->generatorAction($i['callable'], $text, $bind, $count);
                $text .= ') ';
            }

            if(!empty($i['in'])){

                foreach($i['in'][2] as $i){
                    $bind[] = [$n => $s[2]]; 
                }
            }
        }
    }


}
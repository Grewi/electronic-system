<?php
namespace system\core\migration;

trait traitType
{
    public function id( $name = 'id ', $primary = 'PRIMARY KEY ', $ai = 'AUTO_INCREMENT ')
    {
        $this->call[] = $name . $primary . $ai;
        return $this;
    }

    public function int($name, $size = null){
        $size = $size ? '('. $size . ') ' : '';
        $this->call[] = ' ' . $name . ' INT' . $size;
        return $this;
    }

    public function decimal($name, $precision = null, $scale = null){
        $size = $precision ? $precision : '';
        $size = $precision && $scale ? $size . ',' . $scale : $size;
        $size = $size ? '('. $size . ') ' : '';
        $this->call[] = ' ' . $name . ' DECIMAL' . $size;
        return $this;
    }   
    
    public function tinyint($name){
        $this->call[] = ' ' . $name . ' TINYINT ';
        return $this;
    }

    public function bool($name){
        $this->call[] = ' ' . $name . ' BOOL ';
        return $this;
    }  
    
    public function float($name){
        $this->call[] = ' ' . $name . ' FLOAT ';
        return $this;
    } 
    
    public function varchar($name, $size = null){
        $size = $size ? '('. $size . ') ' : '';
        $this->call[] = ' ' . $name . ' VARCHAR' . $size;
        return $this;
    }

    public function char($name, $size = null){
        $size = $size ? '('. $size . ') ' : '';
        $this->call[] = ' ' . $name . ' CHAR ' . $size;
        return $this;
    }

    public function text($name){
        $this->call[] = ' ' . $name . ' TEXT ';
        return $this;
    }

    public function date($name){
        $this->call[] = ' ' . $name . ' DATE ';
        return $this;
    }

    public function time($name){
        $this->call[] = ' ' . $name . ' TIME ';
        return $this;
    }

    public function datetime($name){
        $this->call[] = ' ' . $name . ' DATETIME ';
        return $this;
    }  
    
    public function timestamp($name){
        $this->call[] = ' ' . $name . ' TIMESTAMP ';
        return $this;
    }
    

    public function foreign($callName, $tableName, $tableCall)
    {
        $this->call[] = ' FOREIGN KEY (' . $callName .') REFERENCES ' . $tableName . ' (' . $tableCall . ') ';
        return $this;
    }
}
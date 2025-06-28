<?php
namespace system\core\migration;

trait traitElement 
{
    public function null()
    {
        $count = count($this->call);
        $this->call[$count - 1] .= ' NULL ';
    }

    public function notNull()
    {
        $count = count($this->call);
        $this->call[$count - 1] .= ' NOT NULL ';
    }

    public function default($value)
    {
        $count = count($this->call);
        $this->call[$count - 1] .= ' DEFAULT(' . $value . ') ';        
    }

    public function unique()
    {
        $count = count($this->call);
        $this->call[$count - 1] .= ' UNIQUE '; 
    }

    //FOREIGN
    public function onDelete()
    {
        $count = count($this->call);
        $this->call[$count - 1] .= ' ON DELETE '; 
    }

    public function onUpdate()
    {
        $count = count($this->call);
        $this->call[$count - 1] .= ' ON UPDATE '; 
    } 
    
    public function cascade()
    {
        $count = count($this->call);
        $this->call[$count - 1] .= ' CASCADE '; 
    }

    public function setNull()
    {
        $count = count($this->call);
        $this->call[$count - 1] .= ' SET NULL '; 
    } 

    public function restrict()
    {
        $count = count($this->call);
        $this->call[$count - 1] .= ' RESTRICT '; 
    }     
}
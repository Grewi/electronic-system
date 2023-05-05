<?php
namespace system\core\migration;
use  system\core\migration\traitElement;
use  system\core\migration\traitType;

abstract class baseMigration
{
    private $table = '';
    private $sql = '';
    private $call = [];

    use traitElement;
    use traitType;

    public function createTable(string $table, callable $func)
    {
        $this->table = $table;
        $this->sql .= 'CREATE TABLE ' . $this->table . ' ( ';
        if($func){
            $func($this);
        }
        $this->sql .= implode(',', $this->call);
        $this->sql .= ');';
    }

    public function dropTable($table)
    {
        $this->table = $table;
        $this->sql .= 'DROP TABLE table_name;';
    }

    public function renameTable($table, $to)
    {
        $this->sql .= 'ALTER TABLE ' . $table . ' RENAME TO ' . $to . ';';
    }    

    public function addRow(string $table, string $row, callable $func)
    {
        $this->table = $table;
        $this->sql .= ' ALTER TABLE ' . $table . ' ADD (';
        if($func){
            $func($this);
        }
        $this->sql .= implode(',', $this->call);
        $this->sql .= ');';
    }

    public function dropRow(string $table, string $row)
    {
        $this->sql .= ' ALTER TABLE ' . $table . ' DROP COLUMN ' . $row . ';';
    }

    public function renameRow(string $table, string $row, string $to)
    {
        $this->sql .= 'ALTER TABLE ' . $table . ' RENAME COLUMN ' . $row . ' TO ' . $to . ';';
    }    
}
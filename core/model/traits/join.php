<?php
namespace system\core\model\traits;

trait join
{
    public function leftJoin(string $tableName, string $firstTable, string $secondaryTable)
    {
        $lj = ' LEFT JOIN ' . $tableName . ' ON ' . $firstTable . ' = ' . $secondaryTable . ' ';
        $this->_leftJoin = $this->_leftJoin . $lj;
        return $this;
    }
}
<?php

interface DataBaseInterface
{
    public function select($fields, $tableName);
    public function selectUsingCondition($fields, $tableName, $whereFiled, $whereValue);
    public function insert($tableName, $fields, $vallues);
}

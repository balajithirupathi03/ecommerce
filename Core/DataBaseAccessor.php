<?php

class DataBaseAccessor extends PostgreSQLConnector implements DataBaseInterface
{
    private static $conn;

    public function __construct()
    {
        $this->conn = $this->getConnection();
    }

    private function excecuteQueryStatement($preparedStatement)
    {
        return pg_query($this->conn, $preparedStatement);
    }

    private function createConditionString($whereField, $whereFieldValues)
    {
        foreach (array_combine($whereField, $whereFieldValues) as $field => $value) {
            $string .= $field . '=' . $value . ' AND ';
        }
        // echo $string;exit;
        return $string = rtrim($string, ' AND ');
    }

    final public function select($fields, $tableName)
    {
        $fields = implode(",", $fields);
        $query = "SELECT $fields FROM $tableName";
        return $this->excecuteQueryStatement($query);
    }

    final public function selectUsingCondition($fields, $tableName, $whereField, $whereFieldValues)
    {
        $fields = implode(",", $fields);
        $conditionString = $this->createConditionString($whereField, $whereFieldValues); //rtrim($string, ' AND ');
        $query = "SELECT $fields FROM $tableName WHERE $conditionString";
        // echo $query;exit;
        $mysqlObject = $this->excecuteQueryStatement($query);
        if ($mysqlObject) {
            return $mysqlObject;
        }
        return false;
    }

    final public function selectByJoin($fields, $tableNameOne, $tableNameTwo, $onCondition)
    {
        $fields = implode(",", $fields);
        $query = "select $fields from $tableNameOne join $tableNameTwo on $onCondition";
        return $this->excecuteQueryStatement($query);
    }

    final public function insert($tableName, $fields, $values)
    {
        $fields = implode(",", $fields);
        $values = "'" . implode("', '", $values) . "'";
        $query = "INSERT INTO $tableName($fields) VALUES ($values)";
        // echo $query;exit;
        if (pg_query($this->conn, $query)) {
            return true;
        }
        return false;
    }

    final public function update($tableName, $fieldVaules,$whereField, $whereFieldValues)
    {
        $conditionString=$this->createConditionString($whereField,$whereFieldValues);
        $query = "update " . $tableName . " SET " . $fieldVaules . " where " . $conditionString;
        echo $query;exit;
        if ($psqlObject=pg_query($query)) {
            return pg_affected_rows($psqlObject);
        }
        return false;
    }

    final public function delete($tableName, $whereField, $whereFieldValues)
    {
        // print_r($whereFieldValues);exit;
        $conditionString = $this->createConditionString($whereField, $whereFieldValues);
        $query = 'DELETE FROM ' . $tableName . ' Where ' . $conditionString;
        // echo $query;exit;
        if ($object = pg_query($query)) {
            return $object;
        }
        return false;
    }

    final public function __destruct()
    {
        pg_close($this->conn);
    }
}

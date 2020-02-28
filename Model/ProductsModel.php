<?php

require_once 'Core/Sesstion.php';
require_once 'Config/UploadFilePathConfig.php';

class ProductsModel extends DataBaseAccessor
{
    private function decodePsqlObject($psqlObject)
    {
        while ($rows = pg_fetch_array($psqlObject)) {
            $data[] = $rows;
        }
        return $data;
    }

    public function insertDetails($data)
    {
        unset($data['SellProduct']);
        $data['sellerid'] = $_SESSION['userid'];
        $tableName = '"' . $_SESSION['schema'] . '"' . '.' . 'product';
        $feilds = array_keys($data);
        $values = array_values($data);
        if ($this->insert($tableName, $feilds, $values)) {
            return True;
        }
        return false;
    }

    public function getData($id = 'true')
    {
        $tableName = "my.product";// $tableName = $_SESSION['schema'].'product';
        $fields = ['id', 'name', 'price', 'stack', 'sellerid', 'discountid'];
        if ($id === 'true') {
            $whereField[] = 'true';
            $whereFieldValues[] = 'true';
        } else {
            $whereField[] = 'id';
            $whereFieldValues[] = $id;
        }

        $psqlObject = $this->selectUsingCondition($fields, $tableName, $whereField, $whereFieldValues);
        if ($psqlObject) {
            return $this->decodePsqlObject($psqlObject);
        } else {
            return false;
        }
    }

    public function updateData($formData, $param ='true')
    {
        $tableName = "my.product";// $tableName = $_SESSION['schema'].'product';
        $whereField[] = 'sellerid';
        $whereFieldValues[] = 15;//$_SESSION['userid']
        if($param=== 'true'){
            $whereField[]='true';
            $whereFieldValues[]=$param;
        }
        else{
            $whereField[]='id';
            $whereFieldValues[]=$param;
        }

        foreach ($formData as $field => $values) {
            $fieldVaules .= ($field . '=\'' . $values . '\',');
        }
        $fieldVaules = rtrim($fieldVaules, ",");
        if ($psqlObject=$this->update($tableName, $fieldVaules, $whereField, $whereFieldValues)) {
            return $psqlObject;
        } else return false;
    }

    public function remove($param = false)
    {
        $tableName = "my.product"; // $tableName = $_SESSION['schema'].'product';
        $whereField[] = 'sellerid';
        $whereFieldValues[] = 15; //$_SESSION['userid'];
        if ($param) {
            $whereField[] = 'id';
            $whereFieldValues[] = $param;
        }
        if ($psqlObject = $this->delete($tableName, $whereField, $whereFieldValues)) {
            return pg_affected_rows($psqlObject);
        }
        return false;
    }
}

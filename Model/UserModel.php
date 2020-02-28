<?php

require_once 'Core/Sesstion.php';
require_once 'Config/UploadFilePathConfig.php';

class UserModel extends DataBaseAccessor
{
    private function decodePsqlObject($psqlObject)
    {
        while ($rows = pg_fetch_array($psqlObject)) {
            $data[] = $rows;
        }
        return $data;
    }

    public function getSchemaList()
    {
        $fields = ['s.nspname as schema'];
        $tableName = 'pg_catalog.pg_namespace s where nspname not in (\'information_schema\', \'pg_catalog\', \'public\') and nspname not like \'pg_toast%\' and nspname not like \'pg_temp_%\'';
        $schemaList = $this->select($fields, $tableName);
        return  pg_fetch_all($schemaList);
    }

    public function logout()
    {
        unset($_SESSION['userId']);
    }

    public function insertDetails($formValues)
    {
        unset($formValues['CreateAccount']);
        $tableName = '"' . $formValues['country'] . '"' . '.' . 'user';
        unset($formValues['country']);
        $formValues['wallet'] = 0;
        $formValues['password'] = hash('sha256', $formValues['password'] . 'br.com');
        $feilds = array_keys($formValues);
        $values = array_values($formValues);
        $this->insert($tableName, $feilds, $values);
        return true;
    }

    public function checkMailIdIsAvailaple($loginMailId)
    {
        $feilds = ['id', 'roleid'];
        $tableName = '.user';
        $whereFeild[] = 'mailid';
        $whereValues[] = '\'' . $loginMailId . '\'';
        $_SESSION['countryCode'] = substr($_SERVER['HTTP_HOST'], 5);

        if ($_SESSION['countryCode'] === 'com') {
            $schemaList = $this->getSchemaList();
        } else {
            $schemaList[] = ['schema' => $_SESSION['countryCode']];
        }
        foreach ($schemaList as $schema) {
            $psqlData = $this->selectUsingCondition($feilds, '"' . $schema['schema'] . '"' . $tableName, $whereFeild, $whereValues);
            $tableDatas = pg_num_rows($psqlData);
            if ($tableDatas > 0) {
                $userData = pg_fetch_array($psqlData);
                $userData['schema'] = $schema['schema'];
                return $userData;
            }
        }
        return false;
    }

    public function matchPassword($id, $password, $schema)
    {
        $feilds = ['password'];
        $tableName = '.user';
        $whereFeild[] = 'id';
        $whereValues[] = $id;
        $psqlData = $this->selectUsingCondition($feilds, '"' . $schema . '"' . $tableName, $whereFeild, $whereValues);
        $userData = pg_fetch_array($psqlData);
        if (hash('sha256', $password . 'br.com') === $userData['password']) {
            return true;
        }
        return false;
    }

    public function setSesstionData($userData)
    {
        $_SESSION["userid"] = $userData['id'];
        $_SESSION["role"] = $userData['roleid'] == 1 ? 'b' :  's';
        $_SESSION["schema"] = $userData['schema'];
    }


    public function getSellerPageData()
    {
        $fields = ['*'];
        $tableName = '"' . $_SESSION['schema'] . '"' . '.' . 'productdeatails';
        $whereFeild = 'sellerid';
        $whereValues = $_SESSION['userid'];
        return $this->selectUsingCondition($fields, $tableName, $whereFeild, $whereValues);
    }

    public function getBuyerPageData()
    {
        $fields = ['*'];
        $tableName = '"' . $_SESSION['schema'] . '"' . '.' . 'productdeatails';
        return $this->select($fields, $tableName);
    }

    public function insertSellingFormData($formData)
    {
        unset($formData['SellProduct']);
        $formData['sellerid'] = $_SESSION['userid'];
        $tableName = '"' . $_SESSION['schema'] . '"' . '.' . 'productdeatails';
        $feilds = array_keys($formData);
        $values = array_values($formData);
        $this->insert($tableName, $feilds, $values);
        return True;
    }

    public function getAllData($whereField = "true", $whereValues = 'True')
    {
        $fields = ["id", "name", "gender", "mailid", "contactnumber", "wallet", "roleid"];
        // $tableName = $_SESSION['schema'].'user';
        $tableName = "my.user";
        $psqlData = $this->select($fields, $tableName);
        while ($rows = pg_fetch_array($psqlData)) {
            $data[] = $rows;
        }
        return $data;
    }

    public function getData($param)
    {
        foreach ($param as $field => $values) {
            $whereField = $field;
            $whereValues = $values;
        }
        $fields = ["id", "name", "gender", "mailid", "contactnumber", "wallet", "roleid"];
        $tableName = "my.user";
        $psqlData = $this->selectUsingCondition($fields, $tableName, $whereField, $whereValues);
        // $rows=pg_numrows($psqlData);

        while ($rows = pg_fetch_array($psqlData)) {
            var_dump($rows);
        }
        exit;
        return pg_fetch_array($psqlData);
    }

    public function updateAllData($formData, $param = [true => true])
    {
        // $tableName = $_SESSION['schema'].'user';
        $tableName = "my.user";
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
        if ($psqlObject=$this->update($tableName, $fieldVaules, $whereField,$whereFieldValues)) {
            return true;
        } else return false;
    }

    public function remove($param = [true => true])
    {
        // $tableName = $_SESSION['schema'].'user';
        $tableName = "my.user";
        foreach ($param as $field => $values) {
            $whereField = $field;
            $whereValues = $values;
        }
        if ($this->delete($tableName, $whereField, $whereValues)) {
            return true;
        }
        return false;
    }

    public function addToCart($productId)
    {
        // $tableName = $_SESSION['schema'].'cart';
        $tableName = "my.cart";
        $fields = ['userid', 'productid'];
        // $_SESSION["userid"]
        $values = [12, $productId];
        if ($this->insert($tableName, $fields, $values)) {
            return true;
        } else {
            return false;
        }
    }

    public function getCartProduct($productId = 'true')
    {
        $productIdField = 'productid';
        if ($productId === 'true') {
            $productIdField = 'true';
        }
        $fields = ['productId'];
        // $tableName = $_SESSION['schema'].'cart';
        $tableName = "my.cart";
        $whereField = ['userid', $productIdField];
        // $_SESSION["userid"]
        $whereValue = [12, $productId];
        $psqlObject = $this->selectUsingCondition($fields, $tableName, $whereField, $whereValue);
        return $this->decodePsqlObject($psqlObject);
    }

    public function removeCartProduct($userid, $param = 'true')
    {
        // $tableName = $_SESSION['schema'].'cart';
        $tableName = "my.cart";
        $whereField[] = 'userid';
        $whereFieldValues[] = $userid;
        if ($param === 'true') {
            $whereField[] = 'true';
            $whereFieldValues[] = 'true';
        } else {
            $whereField[] = 'productid';
            $whereFieldValues[] = $param;
        }
        $psqlObject = $this->delete($tableName, $whereField, $whereFieldValues);
        if ($psqlObject) {
            return $psqlObject;
        }
        return false;
    }
}

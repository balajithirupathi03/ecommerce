<?php

require_once 'Config/PostgreSQLConnectionConfig.php';

class PostgreSQLConnector
{
    public function getConnection()
    {
        $db_connection = pg_connect("host=localhost dbname=ecommerce user=postgres password=aspire@123");
        if (!$db_connection) {
            var_dump($db_connection);
            die('Could not connect: ' . pg_last_error($db_connection));
            exit;
        }
        return $db_connection;
    }
}
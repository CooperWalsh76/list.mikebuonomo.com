<?php

class Table
{
    private $credentials;
    private $mysqli;

    public function __construct($database = 'list')
    {
        $this->credentials = require MYSQL_DATA;
        $this->mysqli = new mysqli(
            $this->credentials['host'],
            $this->credentials['user'],
            $this->credentials['pass'],
            $database
        );
        if ($this->mysqli->connect_errno > 0) {
            throw new Exception('Unable to connect to database [' . $this->mysqli->connect_error . ']');
        }
    }

    public function getMysqli()
    {
        return $this->mysqli;
    }
}
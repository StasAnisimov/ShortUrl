<?php


namespace App\Infrastructure;


use http\Exception;

class DB
{
    private $connection;
    private static $instance;
    private $host = 'localhost';
    private $username = 'root';
    private $password = 'test';
    private $database = 'test';

    private function __construct()
    {
        $this->connection = new \mysqli(
            $this->host,
            $this->username,
            $this->password,
            $this->database
        );
        if (\mysqli_connect_error()) {
            throw new \Exception('Failed to connect database');
        }
    }

    public function getInstance() {
        if(!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __clone()
    {
    }

    /**
     * @return \mysqli
     */
    public function getConnection()
    {
        return $this->connection;
    }
}
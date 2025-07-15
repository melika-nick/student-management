<?php

class Database
{
    private $pdo;
    public function __construct(private $host = 'localhost', private $dbname = 'student_db', private $username = 'root', private $password = '1234')
    {
        try {
            $this->pdo = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection error: " . $e->getMessage());
        }
    }

    public function connect()
    {
        return $this->pdo;
    }
}
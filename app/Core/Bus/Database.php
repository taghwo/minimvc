<?php
namespace App\Core\Bus;

use PDO;
use PDOException;

class Database
{
    private $host;
    private $user;
    private $password;
    private $database;
    public $conn;
    public function __construct()
    {
        $this->host = config('DB_HOST');
        $this->user = config('DB_USER');
        $this->database =config('DB_DATABASE');
        $this->password = config('DB_PASSWORD');
        $this->options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ];

        $this->conn = $this->initConnection();
    }

    private function initConnection()
    {
        try {
            return new PDO("mysql:host={$this->host};dbname={$this->database}", $this->user, $this->password, $this->options);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die();
        }
    }

    public function query($sql, $data=[])
    {
        $this->stmt = $this->prepare($sql);

        if (isset($data)) {
            foreach ($data as $field => &$value) {
                $this->stmt->bindParam(':'.$field, $value);
            }
        }
    }

    private function prepare($sql)
    {
        return $this->conn->prepare($sql);
    }

    public function createTable($table)
    {
        $this->execute();
        echo "{$table} table created successfully";
    }

    private function execute($param=[])
    {
        if (empty($param)) {
            $this->stmt->execute();
        } else {
            $this->stmt->execute([$param]);
        }
    }

    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function insert()
    {
        $this->execute();
        return $this->conn->lastInsertId();
    }

    public function fetchSingle($param)
    {
        $this->execute($param);
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    public function __destruct()
    {
        $this->conn = null;
    }
}

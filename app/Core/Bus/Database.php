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
    /**
     * Init databse connection
     *
     * @return mixed
     */
    private function initConnection()
    {
        try {
            return new PDO("mysql:host={$this->host};dbname={$this->database}", $this->user, $this->password, $this->options);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die();
        }
    }

    /**
     * Init SQL
     *
     * @param string $sql
     * @param array $data
     * @return void
     */
    public function query($sql, $data=[])
    {
        $this->stmt = $this->prepare($sql);

        if (isset($data)) {
            foreach ($data as $field => &$value) {
                $this->stmt->bindParam(':'.$field, $value);
            }
        }
    }

    /**
     * Prepare SQL
     *
     * @param string $sql
     * @return object
     */
    private function prepare($sql)
    {
        return $this->conn->prepare($sql);
    }

    /**
     * Create new table
     *
     * @param string $table
     * @return response
     */
    public function createTable(string $table)
    {
        $this->execute();
        echo "{$table} table created successfully";
    }

    /**
     * execute pdo query
     * @param void
    */
    private function execute($param=[])
    {
        if (empty($param)) {
            $this->stmt->execute();
        } else {
            $this->stmt->execute([$param]);
        }
    }

    /**
     * Fetch many results
     *
     * @return object
     */
    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }
     /**
     * Insert new model object
     *
     * @return int
     */
    public function insert()
    {
        $this->execute();
        return $this->conn->lastInsertId();
    }

     /**
     * Fetch single result
     *
     * @return object
     */
    public function fetchSingle($param)
    {
        $this->execute($param);
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Close database connection
     */
    public function __destruct()
    {
        $this->conn = null;
    }
}

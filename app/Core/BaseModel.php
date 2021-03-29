<?php
namespace App\Core;

use App\Core\Bus\Database;

abstract class BaseModel
{
    protected $stmt;
    protected $db;
    protected $hidden = [];

    public function __construct()
    {
        $this->db = new Database();
    }

    public function removeHiddenFields()
    {
        if (!empty($this->hidden)) {
            foreach ($this->hidden as $field) {
                unset($this->record->$field);
            }
        }
    }

    public function hidden($fields)
    {
        $this->hidden = $fields;
    }
    public function find($id)
    {
        $cleanID = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $sql = "SELECT * FROM {$this->dbName} WHERE id = ?";
        $this->db->query($sql);
        $this->record = $this->db->fetchSingle((int)$cleanID);
        $this->removeHiddenFields();
        return  $this->record;
    }

    public function createUser($data)
    {
        $sql = "INSERT INTO users (name,email,password) VALUES(:name, :email, :password)";
        $this->db->query($sql, $data);
        $this->record = $this->db->insert();
        $this->removeHiddenFields();
        return  $this->record;
    }

    public function getByColumn($column, $value)
    {
        $cleanValue = htmlspecialchars(trim($value));
        $cleanColumn = htmlspecialchars(trim($column));
        $sql = "SELECT * FROM {$this->dbName} WHERE  $cleanColumn = ? ORDER BY id LIMIT 1";
        $this->db->query($sql);
        $this->record = $this->db->fetchSingle($cleanValue);
        $this->removeHiddenFields();
        return  $this->record;
    }
}

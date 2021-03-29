<?php
namespace App\Core;

use App\Core\Bus\Database;

abstract class BaseModel
{
    /**
     *
     * @var object
     */
    protected $stmt;
    /**
     *
     * @var object
     */
    protected $db;

    /**
     *
     * @var array
     */
    protected $hidden = [];

    public function __construct()
    {
        $this->db = new Database();
    }
    /**
     * Remove hidden fields from response object
     *
     * @return void
     */
    public function removeHiddenFields()
    {
        if (!empty($this->hidden)) {
            foreach ($this->hidden as $field) {
                unset($this->record->$field);
            }
        }
    }
    /**
     * Modify hidden property
     *
     * @param array $fields
     * @return void
     */
    public function hidden(array $fields)
    {
        $this->hidden = $fields;
    }
    /**
     * Fetch model objecct based on pk
     *
     * @param integer $id
     * @return object
     */
    public function find(int $id)
    {
        $cleanID = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $sql = "SELECT * FROM {$this->dbName} WHERE id = ?";
        $this->db->query($sql);
        $this->record = $this->db->fetchSingle((int)$cleanID);
        $this->removeHiddenFields();
        return  $this->record;
    }

    /**
     * Create new user object
     *
     * @param array $data
     * @return integer
     */
    public function createUser(array $data)
    {
        $sql = "INSERT INTO users (name,email,password) VALUES(:name, :email, :password)";
        $this->db->query($sql, $data);
        $this->record = $this->db->insert();
        $this->removeHiddenFields();
        return  $this->record;
    }

    /**
     * Get model object based on column and value
     *
     * @param string $column
     * @param string $value
     * @return object
     */
    public function getByColumn(string $column, string $value)
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

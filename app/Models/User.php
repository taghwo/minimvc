<?php
namespace App\Models;

use App\Core\BaseModel;

class User extends BaseModel
{
    /**
     * model database name
     *
     * @var string
     */
    protected $dbName = 'users';
     /**
     * Hidden fields
     *
     * @var array
     */
    protected $hidden = ['password'];

    /**
     * Undocumented function
     *
     * @param array $data
     * @return object
     */
    public function new(array $data)
    {
        $newUserID = $this->createUser($data);
        return $this->find($newUserID);
    }
}

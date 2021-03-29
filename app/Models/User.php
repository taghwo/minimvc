<?php
namespace App\Models;

use App\Core\BaseModel;

class User extends BaseModel
{
    protected $dbName = 'users';
    protected $hidden = ['password'];

    public function new($data)
    {
        $newUserID = $this->createUser($data);
        return $this->find($newUserID);
    }
}

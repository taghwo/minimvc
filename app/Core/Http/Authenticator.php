<?php

namespace App\Core\Http;

use App\Core\Bus\Hash;
use App\Core\Bus\Session;
use App\Models\User;

trait Authenticator
{
    private $requestUser;
    protected $validationColumn = 'email';

    public function authAttempt($data)
    {
        $this->getUserBasedOnEmail($data['email']);

        if (Hash::check($data['password'], $this->requestUser->password)) {
            unset($this->requestUser->password);
            return $this->requestUser;
        } else {
            die(Response::json(['status'=>'failed','message'=>'Invalid credentials'], 401));
        }
    }

    protected function loginUser($user)
    {
        $session = new Session();
        $session->authstart($user);
    }

    public function getRequestUser()
    {
        return $this->requestUser;
    }

    private function getUserBasedOnEmail($value)
    {
        $user = new User();
        $user->hidden([]);
        $user  = $user->getByColumn('email', $value);

        if ($user) {
            $this->requestUser = $user;
            return;
        }

        die(Response::json(['status'=>'failed','message'=>'Invalid credentials'], 401));
    }
}

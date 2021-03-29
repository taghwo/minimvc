<?php

namespace App\Core\Http;

use App\Core\Bus\Hash;
use App\Core\Bus\Session;
use App\Models\User;

trait Authenticator
{
    /**
     *
     * @var arraay
     */
    private $requestUser;
    /**
     *
     * @var string
     */
    protected $validationColumn = 'email';

    /**
     *
     * @var string
     */
    protected $invalidCredential = 'Invalid credentials';
    /**
     *
     * @var integer
     */
    protected $invalidCredentialCode = 401;

    /**
     * Validated supplied credentials against database
     *
     * @param array $data
     * @return json | Object
     */
    public function authAttempt(array $data)
    {
        $this->getUserBasedOnValidationColumn($data[$this->validationColumn]);

        if (Hash::check($data['password'], $this->requestUser->password)) {
            unset($this->requestUser->password);
            return $this->requestUser;
        } else {
            die(Response::json(['status'=>'failed','message'=>$this->invalidCredential], $this->invalidCredentialCode));
        }
    }

    /**
     * Start session for authenticated user
     *
     * @param object $user
     * @return void
     */
    protected function loginUser(object $user)
    {
        $session = new Session();
        $session->authstart($user);
    }

    /**
     * Load authenticated user
     *
     * @return object
     */
    public function getRequestUser()
    {
        return $this->requestUser;
    }

     /**
     * Fetch request user based on validation column and value
     *
     * @param string $value
     * @return void | json
     */
    private function getUserBasedOnValidationColumn(string $value)
    {
        $user = new User();
        $user->hidden([]);
        $user  = $user->getByColumn($this->validationColumn, $value);

        if ($user) {
            $this->requestUser = $user;
            return;
        }

        die(Response::json(['status'=>'failed','message'=>$this->invalidCredential], $this->invalidCredentialCode));
    }
}

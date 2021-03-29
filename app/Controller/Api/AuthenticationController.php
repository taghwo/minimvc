<?php
namespace App\Controller\Api;

use App\Core\Http\Authenticator;
use App\Core\Http\BaseController;

class AuthenticationController extends BaseController
{
    use Authenticator;

    /**
     * Get current auth user
     *
     * @return response
     */
    public function currentuser()
    {
        if ($this->session()->check()) {
            return $this->response_ok($this->session()->user());
        }
        return $this->response_error('Sorry you are not logged in', 401);
    }

    /**
     * logout and end session
     *
     * @return response
     */
    public function logout()
    {
        $this->session()->end();
        return $this->response_ok("Logged out succesfully");
    }
}

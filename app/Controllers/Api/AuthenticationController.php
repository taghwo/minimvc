<?php
namespace App\Controllers\Api;

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
        $this->middleware('auth');

        return $this->response_ok($this->session()->user());

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

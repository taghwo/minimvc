<?php
namespace App\Controller\Api;

use App\Core\Http\Authenticator;
use App\Core\Http\BaseController;
use App\Core\Http\Request;
use App\Core\Http\Validation;

class LoginController extends BaseController
{
    use Authenticator;

    public function login(Request $request)
    {
        $validator = new Validation();
        $validator->make(
            [
                "email" =>  $request->input('email'),
                "password" => $request->input('password')
            ],
            [
                "email" => ['required','email'],
                "password" => ['required','min' => 6,'max' => 15,'string']
            ]
        );
        if ($validator->fails()) {
            return $this->response_error($validator->getErrorMessages(), 400);
        }

        $validatedAttr = $validator->validated();

        if ($user = $this->authAttempt($validatedAttr)) {
            $this->loginUser($this->getRequestUser());
        }

        return $this->response_ok($user, "Logged in succesfully");
    }
}

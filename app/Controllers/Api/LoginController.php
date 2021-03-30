<?php
namespace App\Controllers\Api;

use App\Core\Exceptions\ValidationException;
use App\Core\Http\Authenticator;
use App\Core\Http\BaseController;
use App\Core\Http\JWTToken;
use App\Core\Http\Request;
use App\Core\Http\Validation;

class LoginController extends BaseController
{
    use Authenticator;

    /**
     * Login user
     *
     * @param Request $request
     * @return response
     */
    public function login(Request $request)
    {

        $validatedAttr =  $this->validateDate($request);

        if ($user = $this->authAttempt($validatedAttr)) {

            $this->loginUser($user);

            $payload = [
                'user' => $user,
                'accessToken' => JWTToken::createUserToken($user),
                'tokenType' => 'Bearer'
            ];
        }

        return $this->response_ok($payload, "Logged in succesfully");
    }

    public function validateDate($request){
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
           throw new ValidationException($validator->getErrorMessages(), 400);
        }

        return $validator->validated();
    }
}

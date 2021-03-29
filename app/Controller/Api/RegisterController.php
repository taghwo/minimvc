<?php
namespace App\Controller\Api;

use App\Core\Bus\Hash;
use App\Core\Http\BaseController;
use App\Core\Http\Authenticator;
use App\Core\Http\Request;
use App\Core\Http\Validation;
use App\Models\User;

class RegisterController extends BaseController
{
    use Authenticator;

    /**
     *
     * @var object
     */
    protected $user;
    public function __construct()
    {
        $this->user = new User();
    }

    /**
     * Register user
     *
     * @param Request $request
     * @return response
     */
    public function register(Request $request)
    {
        $validator = new Validation();
        $validator->make(
            [
                "name" =>  $request->input('name'),
                "email" => $request->input('email'),
                "password" => $request->input('password')
            ],
            [
                "name" => ['required','string'],
                "email" => ['required','email'],
                "password" => ['required','min' => 6,'max' => 15,'string']
            ]
        );
        if ($validator->fails()) {
            return $this->response_error($validator->getErrorMessages(), 400);
        }

        $validatedAttr = $validator->validated();

        $validatedAttr ['password'] = Hash::make($validatedAttr ['password']);

        try {
            $user = $this->user->new($validatedAttr);
            $this->loginUser($user);
            return $this->response_created($user, "Successfully registered");
        } catch (\Throwable $th) {
            return $this->response_error($th->getMessage(), $th->getCode());
        }
    }
}

<?php

namespace App\Core\Http;

use App\Core\Bus\Session;

abstract class BaseController
{
    public function session()
    {
        $sesion = new Session();
        return $sesion;
    }

    public function response_ok($data)
    {
        return Response::json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }

    public function response_no_data($msg)
    {
        return Response::json([
            'status' => 'success',
            'message' => $msg
        ], 200);
    }

    public function response_error($msg, $code=417)
    {
        return Response::json([
            'status' => 'failed',
            'message' => $msg
        ], $code);
    }

    public function response_created($data, $message)
    {
        return Response::json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], 201);
    }
    public function response_client_error($error)
    {
        return Response::json([
            'status' => 'success',
            'message' => "There was an error {$error}"
        ], 400);
    }
    protected function view($view, $data=[])
    {
        foreach ($data as $key => $value) {
            $$key = $value;
        }
        if (file_exists("../app/Views/{$view}.php")) {
            require_once "../app/Views/{$view}.php";
        } else {
            die('View{$view}.php was not found, please create it');
        }
    }
}

<?php

namespace App\Core\Http;

use App\Core\Bus\Session;

abstract class BaseController
{
    /**
     * Make available session to controllers
     *
     * @return object
     */
    public function session()
    {
        $session = new Session();
        return $session;
    }

    /**
     * Response ok
     *
     * @param mixed $data
     * @return json
     */
    public function response_ok($data)
    {
        return Response::json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }

    /**
     * Response okay but send only message
     *
     * @param string $msg
     * @return json
     */
    public function response_no_data(string $msg)
    {
        return Response::json([
            'status' => 'success',
            'message' => $msg
        ], 200);
    }

    /**
     * Response error
     *
     * @param mixed $data
     * @param integer $code
     * @return json
     */
    public function response_error(string $msg, $code=417)
    {
        return Response::json([
            'status' => 'failed',
            'message' => $msg
        ], $code);
    }

    /**
     * Response created
     *
     * @param mixed $data
     * @param string $msg
     * @return json
     */
    public function response_created($data, string $message)
    {
        return Response::json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], 201);
    }

    /**
     * Response error
     *
     * @param string $error
     * @param integer $code
     * @return json
     */
    public function response_client_error(string $error)
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

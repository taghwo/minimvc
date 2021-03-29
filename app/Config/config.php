<?php
$dotenv = \Dotenv\Dotenv::createImmutable(realpath('.'));
$dotenv->load();

if (!function_exists('config')) {
    function config($key)
    {
        $configs = [
                "DB_HOST" =>  $_ENV['DB_HOST'],
                "DB_USER" => $_ENV['DB_USER'],
                "DB_DATABASE" => $_ENV['DB_DATABASE'],
                "DB_PASSWORD" => $_ENV['DB_PASSWORD'],
                "APP_NAME" => $_ENV['APP_NAME'],
                "APP_USER_MODEL" => $_ENV['APP_USER_MODEL']??'users',
            ];
        if (!array_key_exists($key, $configs)) {
            throw new InvalidArgumentException("Sorry config key => $key has not been added to array of configs in config.php");
        }
        if ($configs[$key]) {
            return $configs[$key];
        }
        throw new InvalidArgumentException("Sorry key => $key does not exist in your .env");
    }
}

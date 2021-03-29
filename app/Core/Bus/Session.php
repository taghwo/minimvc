<?php
namespace App\Core\Bus;

class Session
{
    protected $user;
    public $isLoggedIn;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function authstart($user)
    {
        $_SESSION['isLoggedIn'] = true;
        $_SESSION['user'] =  $user;
    }

    public function user()
    {
        return $_SESSION['user'];
    }

    public function userId()
    {
        return (int)$_SESSION['user']->id;
    }


    public function check()
    {
        if (!isset($_SESSION['isLoggedIn'])) {
            return false;
        } elseif ($_SESSION['isLoggedIn'] === true) {
            return true;
        }else{
            return false;
        }
    }

    public function end()
    {
        $_SESSION['isLoggedIn'] = false;
        session_destroy();
    }
}

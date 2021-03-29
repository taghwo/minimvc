<?php
namespace App\Core\Bus;

class Session
{
    /**
     *
     * @var object
     */
    protected $user;

    /**
     * Login status
     *
     * @var bool
     */
    public $isLoggedIn;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    /**
     * Push user object into session
     *
     * @param object $user
     * @return void
     */
    public function authstart(object $user)
    {
        $_SESSION['isLoggedIn'] = true;
        $_SESSION['user'] =  $user;
    }

    public function user():object
    {
        return $_SESSION['user'];
    }

    public function userId():int
    {
        return (int)$_SESSION['user']->id;
    }


    public function check():bool
    {
        if (!isset($_SESSION['isLoggedIn'])) {
            return false;
        } elseif ($_SESSION['isLoggedIn'] === true) {
            return true;
        }else{
            return false;
        }
    }

    public function end():void
    {
        $_SESSION['isLoggedIn'] = false;
        session_destroy();
    }
}

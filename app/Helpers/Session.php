<?php


namespace App\Helpers;

session_start();

class Session
{

    public static function has($session_name): bool
    {
        return isset($_SESSION[$session_name]);
    }

    public static function put($session_name, $value)
    {
        return $_SESSION[$session_name] = $value;
    }


    public static function get($session_name)
    {
        return $_SESSION[$session_name];
    }

    public static function delete($session_name)
    {
        if (self::has($session_name)) {
            unset($_SESSION[$session_name]);
        }
    }


    public static function flash($session_name, string $message = '')
    {
        if (self::has($session_name)) {
            $is_session = self::get($session_name);
            self::delete($is_session);
            return $is_session;
        } else {
            self::put($session_name, $message);
        }
        return null;
    }
}
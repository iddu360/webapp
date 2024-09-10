<?php
/**
 * Created by PhpStorm.
 * User: AlKo
 * Date: 2019-02-18
 * Time: 01:17
 */

namespace Core;


class Session
{

    /*
     * Initalisierung einer Session
     */
    public static function init()
    {
        @session_start();
    }

    /*
     * Setter für eine Session Variable
     */
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /*
     * Getter für eine Session Variable
     */
    public static function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return null;
        }
    }

    /*
     * Session zertören
     */
    public static function destroy()
    {
        session_destroy();
    }
}
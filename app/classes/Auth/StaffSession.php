<?php

namespace GC\Auth;

use GC\Data;
use GC\Model\Staff\Session;

class StaffSession
{
    /**
     * Rozpoczyna sesję
     */
    public static function start()
    {
        if (session_status() === \PHP_SESSION_NONE) {

            $cookie = Data::get('config')['session']['staff']['cookie'];

            # zmiana nazwy ciastka sesyjnego dla pracownika
            session_name($cookie['name']);

            # zmiana czasu żywotności ciastka
            session_set_cookie_params($cookie['lifetime']);

            //ini_set("session.gc_maxlifetime", 10);

            session_start();

            Data::get('logger')->session('Start', [session_id()]);
        }

        // Session::update([
        //     'staff_id' => $staff_id,
        //     'session_id' => $session_id,
        // ]);
    }

    public static function cookieExists()
    {
        $name = Data::get('config')['session']['staff']['cookie']['name'];

        return isset($_COOKIE[$name]) and $_COOKIE[$name];
    }

    public static function create($staff_id)
    {
        static::start();

        Session::replace([
            'staff_id' => $staff_id,
            'session_id' => session_id(),
        ]);
    }

    public static function redirectIfNonExists()
    {
        if (!static::cookieExists()) {
            Data::get('logger')->session('Cookie does not exists');
            redirect('/auth/login');
        }
    }

    public static function destroy()
    {
        Session::delete()
            ->equals('session_id', session_id())
            ->execute();

        session_destroy();
        setcookie(session_name(), null);
    }
}

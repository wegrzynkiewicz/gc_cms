<?php

namespace GC\Auth;

use GC\Request;

class CSRFToken
{
    public static function routines(Request $request)
    {
        # jeżeli jakakolwiek inna metota niż GET
        if (!$request->isMethod('GET')) {
            static::assert();
            static::register();
        }

        # jeżeli token nie istnieje
        if (!isset($_SESSION['CSRFToken'])) {
            static::register();
        }
    }

    /**
     * Tworzy token i dodaje ciasteczko przeglądarce
     */
    public static function register()
    {
        $tokenString = Password::random(40);
        setcookie(
            $GLOBALS['config']['csrf']['cookieName'], # cookie name
            $tokenString, # value
            time() + $GLOBALS['config']['csrf']['lifetime'], # expires
            '/', # path
            '', # domain
            false, # secure
            true # httpOnly
        );
        $_SESSION['CSRFToken'] = $tokenString;

        $GLOBALS['logger']->info('[CSRF] Register', [$tokenString]);
    }

    /**
     * Weryfikuje poprawność tokenu, rzuca wyjątek jeżeli nieprawidłowy
     */
    public static function assert()
    {
        if (!static::validate()) {
            throw new \RuntimeException('CSRFToken is valid');
        }
    }

    /**
     * Weryfikuje poprawność tokenu
     */
    public static function validate()
    {
        if (!isset($_COOKIE[$GLOBALS['config']['csrf']['cookieName']])) {
            return static::abort('Cookie does not exists');
        }

        $token = $_COOKIE[$GLOBALS['config']['csrf']['cookieName']];
        if (empty($token)) {
            return static::abort('Cookie empty');
        }

        if ($token !== def($_SESSION, 'CSRFToken', null)) {
            return static::abort('Session failed');
        }

        $GLOBALS['logger']->info("[CSRF] Verified");

        return true;
    }

    /**
     * Niszczy dane tokenu
     */
    public static function abort($message)
    {
        $GLOBALS['logger']->info("[CSRF] {$message}");
        setcookie($GLOBALS['config']['csrf']['cookieName'], '', time() - 3600, '/');
        unset($_SESSION['CSRFToken']);
    }
}

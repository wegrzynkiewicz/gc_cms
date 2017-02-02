<?php

namespace GC\Auth;

use GC\Request;

class CSRFToken
{
    public static $config;

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
            static::$config['cookieName'], # cookie name
            $tokenString, # value
            time() + static::$config['lifetime'], # expires
            '/', # path
            '', # domain
            false, # secure
            true # httpOnly
        );
        $_SESSION['CSRFToken'] = $tokenString;

        logger('[CSRF] Register', [$tokenString]);
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
        if (!isset($_COOKIE[static::$config['cookieName']])) {
            return static::abort('Cookie does not exists');
        }

        $token = $_COOKIE[static::$config['cookieName']];
        if (empty($token)) {
            return static::abort('Cookie empty');
        }

        if ($token !== def($_SESSION, 'CSRFToken', null)) {
            return static::abort('Session failed');
        }

        logger("[CSRF] Verified");

        return true;
    }

    /**
     * Niszczy dane tokenu
     */
    public static function abort($message)
    {
        logger("[CSRF] {$message}");
        setcookie(static::$config['cookieName'], '', time() - 3600, '/');
        unset($_SESSION['CSRFToken']);
    }
}

CSRFToken::$config = &getConfig()['csrf'];

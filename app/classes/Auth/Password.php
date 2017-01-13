<?php

namespace GC\Auth;

class Password
{
    /**
     * Zwraca pseudo losowy ciąg znaków o zadanej długości
     */
    public static function random($length)
    {
        $string = openssl_random_pseudo_bytes(ceil($length));
        $string = base64_encode($string);
        $string = str_replace(['/', '+', '='], '', $string);
        $string = substr($string, 0, $length);

        return $string;
    }

    /**
     * Haszuje wprowadzony ciąg znaków
     */
    public static function hash($securePassword)
    {
        return password_hash(
            static::salt($securePassword),
            \PASSWORD_DEFAULT,
            \GC\Container::get('config')['password']['options']
        );
    }

    /**
     * Sprawdza poprawność hasła i hasza
     */
    public static function verify($securePassword, $passwordHash)
    {
        return password_verify(static::salt($securePassword), $passwordHash);
    }

    /**
     * Dodaje indywidualną sól dla każdego serwisu do wprowadzonego hasła
     */
    public static function salt($securePassword)
    {
        return $securePassword.\GC\Container::get('config')['password']['staticSalt'];
    }
}

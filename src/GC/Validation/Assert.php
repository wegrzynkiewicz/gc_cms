<?php

declare(strict_types=1);

namespace GC\Validation;

use League\Uri\Schemes\Http;
use GC\Validation\Validate;
use GC\Exception\AssertException;

/**
 * Klasa Assert rzuca wyjątek, jeżeli metoda walidująca zawiedzie.
 */
class Assert
{
    public static function column($column): void
    {
        static::notNull($column);

        if (!preg_match("~^[a-z_]+$~", (string)$column)) {
            throw new AssertException(
                trans('Nazwa kolumny nie może zawierać innych znaków jak litery i _')
            );
        }
    }

    public static function datetime($datetime): void
    {
        static::notNull($datetime);

        if (empty((string)$datetime)) {
            throw new AssertException(
                trans('Podana data i czas jest pusta')
            );
        }

        if (\DateTime::createFromFormat('Y-m-d H:i:s', $datetime) === false) {
            throw new AssertException(
                trans('Podana data i czas są nieprawidłowowe')
            );
        }
    }

    public static function enum($value, array $array): void
    {
        static::notNull($value);

        if (!in_array($value, $array)) {
            throw new AssertException(
                trans('Podana wartość nie jest zdefiniowana w zbiorze')
            );
        }
    }

    public static function email($email): void
    {
        static::notNull($email);

        if (empty((string)$email)) {
            throw new AssertException(
                trans('Podany adres e-mail jest pusty')
            );
        }

        if (filter_var((string)$email, FILTER_VALIDATE_EMAIL) === false) {
            throw new AssertException(
                trans('Podany adres e-mail jest nieprawidłowy')
            );
        }
    }

    public static function installedLang($lang): void
    {
        static::notNull($lang);

        if (!in_array($lang, array_keys($GLOBALS['config']['langs']))) {
            throw new AssertException(
                trans('Nie znaleziono tego języka w aplikacji')
            );
        }
    }

    public static function int($int): void
    {
        static::notNull($int);

        if (empty($int)) {
            throw new AssertException(
                trans('Podana wartość jest pusta, oczekiwano liczby')
            );
        }

        if (filter_var($int, FILTER_VALIDATE_INT) === false) {
            throw new AssertException(
                trans('Podana wartość nie jest prawidłową liczbą całkowitą')
            );
        }
    }

    public static function ip($ip): void
    {
        static::notNull($ip);

        if (empty($ip)) {
            throw new AssertException(
                trans('Podany adres IP jest pusty')
            );
        }

        if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
            throw new AssertException(
                trans('Podany adres IP jest nieprawidłowy')
            );
        }
    }

    public static function notNull($value): void
    {
        if ($value === null) {
            throw new AssertException(
                trans('Nie przekazano poprawnej wartości')
            );
        }
    }

    public static function raw($string): void
    {
        static::notNull($string);
        static::required($string);
    }

    public static function required($required): void
    {
        static::notNull($required);

        if (empty((string)$required)) {
            throw new AssertException(
                trans('Podana wartość nie może być pusta')
            );
        }
    }

    public static function slug($slug, $frame_id = 0): void
    {
        static::notNull($slug);

        if (empty($slug)) {
            throw new AssertException(
                trans('Adres strony nie może być pusty')
            );
        }

        if (!preg_match('~^[\/a-z0-9\-]+$~', $slug)) {
            throw new AssertException(
                trans('Adres strony jest nieprawidłowy')
            );
        }

        $frame = \GC\Model\Frame::select()
            ->equals('slug', normalizeSlug($slug))
            ->condition('frame_id != ?', [intval($frame_id)])
            ->fetch();

        if ($frame) {
            throw new AssertException(
                trans('Adres strony został już wykorzystany')
            );
        }
    }

    public static function staffEmail($email, $staff_id = 0): void
    {
        static::notNull($email);
        static::email($email);

        $user = \GC\Model\Staff\Staff::select()
            ->equals('email', $email)
            ->condition('staff_id != ?', [$staff_id])
            ->fetch();

        if ($user) {
            throw new AssertException(
                trans('Adres e-mail jest już używany')
            );
        }
    }

    public static function uri($uri): void
    {
        static::notNull($uri);

        $http = Http::createFromString($uri);
        if ($http->getPath() !== $uri) {
            throw new AssertException(
                trans('Podany adres URI jest nieprawidłowy')
            );
        }
    }

    public static function url($url): void
    {
        static::notNull($url);

        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new AssertException(
                trans('Podany adres URL jest nieprawidłowy')
            );
        }
    }
}

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
    public static function column(string $string): void
    {
        if (!preg_match("~^[a-z_]+$~", $string)) {
            throw new AssertException(
                trans('Nazwa kolumny nie może zawierać innych znaków jak litery i _')
            );
        }
    }

    public static function datetime(string $date): void
    {
        if (\DateTime::createFromFormat('Y-m-d H:i:s', $date) === false) {
            throw new AssertException(
                trans('Podana data i czas są nieprawidłowowe')
            );
        }
    }

    public static function enum($value, array $array): void
    {
        if (!in_array($value, $array)) {
            throw new AssertException(
                trans('Podana wartość nie jest zdefiniowana w zbiorze')
            );
        }
    }

    public static function email(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new AssertException(
                trans('Podany adres e-mail jest nieprawidłowy')
            );
        }
    }

    public static function installedLang(string $code): void
    {
        if (!in_array($code, array_keys($GLOBALS['config']['langs']))) {
            throw new AssertException(
                trans('Nie znaleziono języka (%s) w aplikacji', [$code])
            );
        }
    }

    public static function ip(string $ip): void
    {
        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            throw new AssertException(
                trans('Podany adres IP jest nieprawidłowy')
            );
        }
    }

    public static function raw(string $string): void
    {
        static::required($string);
    }

    public static function required(string $string): void
    {
        if (empty($string)) {
            throw new AssertException(
                trans('Podana wartość nie może być pusta')
            );
        }
    }

    public static function slug(string $slug, int $frame_id = 0): void
    {
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
            ->condition('frame_id != ?', [$frame_id])
            ->fetch();

        if ($frame) {
            throw new AssertException(
                trans('Adres strony został już wykorzystany')
            );
        }
    }

    public static function staffEmail(string $email, int $staff_id = 0): void
    {
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

    public static function uri(string $uri): void
    {
        $http = Http::createFromString($uri);
        if ($http->getPath() !== $uri) {
            throw new AssertException(
                trans('Podany adres URI jest nieprawidłowy')
            );
        }
    }

    public static function url(string $uri): void
    {
        if (!filter_var($uri, FILTER_VALIDATE_URL)) {
            throw new AssertException(
                trans('Podany adres URL jest nieprawidłowy')
            );
        }
    }
}

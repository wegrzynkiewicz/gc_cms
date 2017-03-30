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
    public static function column($probablyString): void
    {
        if (!preg_match("~^[a-z_]+$~", (string)$probablyString)) {
            throw new AssertException(
                trans('Nazwa kolumny nie może zawierać innych znaków jak litery i _')
            );
        }
    }

    public static function datetime($probablyDateTime): void
    {
        if (empty((string)$probablyDateTime)) {
            throw new AssertException(
                trans('Podana data i czas jest pusta')
            );
        }

        if (\DateTime::createFromFormat('Y-m-d H:i:s', $probablyDateTime) === false) {
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

    public static function email($probablyEmail): void
    {
        if (empty((string)$probablyEmail)) {
            throw new AssertException(
                trans('Podany adres e-mail jest pusty')
            );
        }

        if (filter_var((string)$probablyEmail, FILTER_VALIDATE_EMAIL) === false) {
            throw new AssertException(
                trans('Podany adres e-mail jest nieprawidłowy')
            );
        }
    }

    public static function installedLang($probablyCode): void
    {
        if (!in_array($probablyCode, array_keys($GLOBALS['config']['langs']))) {
            throw new AssertException(
                trans('Nie znaleziono języka (%s) w aplikacji', [$probablyCode])
            );
        }
    }

    public static function int($probablyInteger): void
    {
        if (empty($probablyInteger)) {
            throw new AssertException(
                trans('Podana wartość jest pusta, oczekiwano liczby')
            );
        }

        if (filter_var($probablyInteger, FILTER_VALIDATE_INT) === false) {
            throw new AssertException(
                trans('Podana wartość nie jest prawidłową liczbą całkowitą')
            );
        }
    }

    public static function ip($probablyIp): void
    {
        if (filter_var($probablyIp, FILTER_VALIDATE_IP) === false) {
            throw new AssertException(
                trans('Podany adres IP jest nieprawidłowy')
            );
        }
    }

    public static function raw($probablyString): void
    {
        static::required($probablyString);
    }

    public static function required($probablyString): void
    {
        if (empty((string)$probablyString)) {
            throw new AssertException(
                trans('Podana wartość nie może być pusta')
            );
        }
    }

    public static function slug($probablySlug, int $frame_id = 0): void
    {
        if (empty($probablySlug)) {
            throw new AssertException(
                trans('Adres strony nie może być pusty')
            );
        }

        if (!preg_match('~^[\/a-z0-9\-]+$~', $probablySlug)) {
            throw new AssertException(
                trans('Adres strony jest nieprawidłowy')
            );
        }

        $frame = \GC\Model\Frame::select()
            ->equals('slug', normalizeSlug($probablySlug))
            ->condition('frame_id != ?', [$frame_id])
            ->fetch();

        if ($frame) {
            throw new AssertException(
                trans('Adres strony został już wykorzystany')
            );
        }
    }

    public static function staffEmail($probablyEmail, int $staff_id = 0): void
    {
        static::email($probablyEmail);

        $user = \GC\Model\Staff\Staff::select()
            ->equals('email', $probablyEmail)
            ->condition('staff_id != ?', [$staff_id])
            ->fetch();

        if ($user) {
            throw new AssertException(
                trans('Adres e-mail jest już używany')
            );
        }
    }

    public static function uri($probablyUri): void
    {
        $http = Http::createFromString($probablyUri);
        if ($http->getPath() !== $probablyUri) {
            throw new AssertException(
                trans('Podany adres URI jest nieprawidłowy')
            );
        }
    }

    public static function url($probablyUrl): void
    {
        if (filter_var($probablyUrl, FILTER_VALIDATE_URL) === false) {
            throw new AssertException(
                trans('Podany adres URL jest nieprawidłowy')
            );
        }
    }
}

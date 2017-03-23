<?php

declare(strict_types=1);

namespace GC;

class Validate
{
    public static function column(string $string): bool
    {
        return (bool) preg_match("~^[a-z_]+$~", $string);
    }

    public static function installedLang(string $code): bool
    {
        return in_array($code, array_keys($GLOBALS['config']['langs']));
    }

    public static function ip(string $ip): bool
    {
        return filter_var($ip, FILTER_VALIDATE_IP);
    }

    public static function email(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function slug(string $slug, int $frame_id = 0): bool
    {
        if (empty($slug)) {
            return false;
        }

        $frame = \GC\Model\Frame::select()
            ->equals('slug', normalizeSlug($slug))
            ->condition('frame_id != ?', $frame_id)
            ->fetch();

        return $frame === false;
    }

    public static function staffEmail(string $email, int $staff_id = 0): bool
    {
        if (!static::email($email)) {
            return false;
        }

        $user = \GC\Model\Staff\Staff::select()
            ->equals('email', $email)
            ->condition('staff_id != ?', $staff_id)
            ->fetch();

        return !$user;
    }
}

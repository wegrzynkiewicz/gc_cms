<?php

namespace GC\Auth;

use GC\Data;

class Client
{
    /**
     * Zwraca kod jezyka, aktualnie uzywanego przez klienta
     */
    public static function getLang()
    {
        if (isset($_SESSION['lang']['routing'])) {
            return $_SESSION['lang']['routing'];
        }

        if (isset($_SESSION['lang']['staff'])) {
            return $_SESSION['lang']['staff'];
        }

        return Data::get('config')['lang']['clientDefault'];
    }

    /**
     * Zwraca adres IP clienta
     */
    public static function getIP()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']) && Validate::ip($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }

        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== false) {
                $iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                foreach ($iplist as $ip) {
                    if (Validate::ip($ip)) {
                        return $ip;
                    }
                }
            } elseif (Validate::ip($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
        }

        if (!empty($_SERVER['HTTP_X_FORWARDED']) && Validate::ip($_SERVER['HTTP_X_FORWARDED'])) {
            return $_SERVER['HTTP_X_FORWARDED'];
        }

        if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && Validate::ip($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
            return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        }

        if (!empty($_SERVER['HTTP_FORWARDED_FOR']) && Validate::ip($_SERVER['HTTP_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_FORWARDED_FOR'];
        }

        if (!empty($_SERVER['HTTP_FORWARDED']) && Validate::ip($_SERVER['HTTP_FORWARDED'])) {
            return $_SERVER['HTTP_FORWARDED'];
        }

        return $_SERVER['REMOTE_ADDR'];
    }
}

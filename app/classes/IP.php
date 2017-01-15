<?php

namespace GC;

use GC\Validate;

/**
 */
class IP
{
    /**
     * Zapisuje zadane dane do pliku w formie łatwego do odczytu pliku PHP
     */
    public static function info($ip = null)
    {
        if (!Validate::ip($ip)) {
            return $ip;
        }

        $continents = array(
            "AF" => "Africa",
            "AN" => "Antarctica",
            "AS" => "Asia",
            "EU" => "Europe",
            "OC" => "Australia (Oceania)",
            "NA" => "North America",
            "SA" => "South America"
        );

        $ipdat = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));

        return [
            "ip" => $ip,
            "city" => $ipdat->geoplugin_city,
            "state" => $ipdat->geoplugin_regionName,
            "country" => $ipdat->geoplugin_countryName,
            "countryCode" => $ipdat->geoplugin_countryCode,
            "continent" => def($continents, strtoupper($ipdat->geoplugin_continentCode)),
            "continentCode" => $ipdat->geoplugin_continentCode,
            "userAgent" => server('HTTP_USER_AGENT', ''),
        ];
    }
}

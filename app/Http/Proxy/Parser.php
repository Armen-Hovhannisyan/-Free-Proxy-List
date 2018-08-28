<?php

namespace App\Http\Proxy;

use App\Http\Proxy\Helper;

class Parser {

    const CHECKERPROXY_NET_API_URL = 'https://checkerproxy.net/api/archive/{{date}}';

    public static function getProxies() {
        $proxies = [];
        $proxies = self::getProxychekerNetProxies();



        return $proxies;
    }

    private static function getDate() {
        return date('Y-m-d');
    }

    private static function getProxychekerNetProxies() {
        $url = str_replace('{{date}}', self::getDate(), self::CHECKERPROXY_NET_API_URL);
        $json = json_decode(file_get_contents($url), true);
        $validProxies = [];
        foreach ($json as $items) {
            if (Helper::validateProxyIpPort($items['addr'])) {
                $validProxies[] = $items['addr'];
            }
        }
        return $validProxies;
    }

}

<?php

namespace App\Http\Controllers;

use App\Proxy;
use App\Http\Controllers\Controller;
use App\Http\Proxy\ProxyChecker;
use App\Http\Proxy\Parser;

class ProxyController extends Controller {

    public function check() {
        $config = [
            'timeout' => 5,
            'check' => ['get', 'post', 'cookie', 'referer', 'user_agent'],
        ];

        $url = "https://getbootstrap.com/";

        try {
            $uncheckedProxy = Proxy::getUncheckedProxy(10);
            $proxies = [];
            foreach ($uncheckedProxy as $proxyItem) {
                $proxies[] = $proxyItem['proxy'];
            }
            if (!$proxies) {
                $checkedProxy = Proxy::getProxiesOrderByLastCheck($limit = 10);
                foreach ($checkedProxy as $proxyItem) {
                    $proxies[] = $proxyItem['proxy'];
                }
            }
            if ($proxies) {
                self::checkProxies($url, $config, $proxies);
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function checkProxies($url, $config, $proxies) {
        $proxyCheckObject = new ProxyChecker($url, $config);
        $result = $proxyCheckObject->checkProxies($proxies);

        foreach ($result as $proxy => $item) {
            if (isset($item['error']) && $item['error']) {
                Proxy::deleteProxy($proxy);
            } else {
                Proxy::updateProxy($proxy, [
                    'ip' => $item['info']['primary_ip'],
                    'port' => $item['info']['primary_port'],
                    'country' => $item['info']['country'],
                    'anonymity' => $item['proxy_level'],
                    'speed' => $item['info']['connect_time'],
                    'type' => '',
                ]);
            }
        }
    }

    public function add() {
        try {
            $proxies = Parser::getProxies();
            foreach ($proxies as $item) {
                Proxy::addNewProxy($item);
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

}

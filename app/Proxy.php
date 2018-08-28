<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proxy extends Model {

    protected $table = 'proxies';
    protected $fillable = [
        'proxy', 'ip', 'port', 'country', 'anonymity', 'speed', 'type'
    ];
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public static function addNewProxy($proxy) {
        $port=explode(':',$proxy['addr']);
        $port=$port[1];

        return self::updateOrCreate(['proxy' => $proxy['addr']],
        [ "ip"=>$proxy['ip'],
         "port"=>$port,
         "country"=>$proxy['addr_geo_country'],
         "type"=>$proxy['type'],
         "anonymity"=>$proxy['kind'],
        "speed"=>$proxy['timeout']]

        );

    }

    public static function getUncheckedProxy($limit = 10) {
        return self::where('ip', '=', null)->limit($limit)->get()->toArray();
    }

    public static function deleteProxy($proxy) {
        return self::where(['proxy' => $proxy])->delete();
    }

    public static function updateProxy($proxy, $parameters) {
        return self::where(['proxy' => $proxy])->update($parameters);
    }

    public static function getAllProxies() {
        return self::where('speed', '>', 0)->get();
    }

    public static function getProxiesOrderByLastCheck($limit = 10) {
        return self::orderBy('updated_at', 'desc')->limit($limit)->get()->toArray();
    }

    public static function insertProxies($proxies) {
        return self::insert($proxies);
    }

}

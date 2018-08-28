<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Proxy;

class ApiController extends Controller {

    public function index() {
        $proxies = Proxy::getAllProxies();
        return response()->json($proxies);
    }

}

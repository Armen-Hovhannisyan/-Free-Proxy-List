<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Proxy;

class MainController extends Controller {

    public function index() {
        $proxies = Proxy::getAllProxies();
        return view('welcome', ['proxies' => $proxies]);
    }

}

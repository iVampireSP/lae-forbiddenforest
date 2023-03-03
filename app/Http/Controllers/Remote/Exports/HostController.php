<?php

namespace App\Http\Controllers\Remote\Exports;

use Illuminate\Http\Request;
use ivampiresp\Cocoa\Http\Controller;
use ivampiresp\Cocoa\Models\Host;

class HostController extends Controller
{
    public function index(Request $request)
    {
        // 模块之间调用最好也遵循 RESTful。并且 莱云 会在每个 Request 和 Header(X-Module) 中加上发起调用的 module_id。

        // 从 Request 中获取 user_id

        // dd($request->user_id)

        // 从 Header 中获取发起调用的 module_id
        // dd($request->header('X-Module'));

        $hosts = Host::thisUser($request->user_id)->get();

        return $this->success($hosts);
    }
}

<?php

namespace App\Http\Controllers\Remote;

use ivampiresp\Cocoa\Http\Controller;
use App\Models\Server;

// use Illuminate\Http\Request;

class ServerStatusController extends Controller
{
    /**
     * 返回全部服务器状态，不需要包裹任何数据。
     *
     * @return array
     */
    public function index(): array
    {
        return Server::all()->toArray();
    }
}

<?php

namespace App\Http\Controllers\Remote;

use App\Models\Server;
use ivampiresp\Cocoa\Http\Controller;

// use Illuminate\Http\Request;

class ServerStatusController extends Controller
{
    /**
     * 返回全部服务器状态，不需要包裹任何数据。
     */
    public function index(): array
    {
        return Server::all()->toArray();
    }
}

<?php

namespace App\Http\Controllers\Remote\Exports;

use ivampiresp\Cocoa\Http\Controller;
use ivampiresp\Cocoa\Models\Ip;

class IpController extends Controller
{

    public function __construct()
    {
        $this->middleware('check_module_is_ip_manager');
    }

    /**
     * 显示指定的 IP 地址，用户判断是否绑定成功。
     * 尽量保持默认，否则可能会误触发删除。
     */
    public function show(Ip $ip)
    {
        //

        return $this->success($ip);
    }



    /**
     * 移除绑定的 IP 地址，比如给指定网卡断网，然后移除。
     */
    public function destroy(Ip $ip)
    {
        //

        return $this->success($ip);
    }
}

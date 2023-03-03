<?php

namespace App\Http\Controllers\Api;

use App\Actions\HostAction;
use App\Exceptions\HostActionException;
use App\Models\Host;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use ivampiresp\Cocoa\Http\Controller;

class HostController extends Controller
{
    public function index()
    {
        $hosts = Host::thisUser()->get();
        return $this->success($hosts);
    }

    public function store(Request $request)
    {
        $hostAction = new HostAction();

        $host = $hostAction->create($request->only([
            'name',
            'status',
            'billing_cycle',

        ]));

        return $this->created($host);
    }

    public function show(Host $host)
    {
        $this->isUser($host);

        return $this->success($host);
    }

    public function isUser(Host $host)
    {
        if (auth('api')->check()) {
            if ($host->user_id !== auth('api')->id()) {
                abort(403);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Host    $host
     *
     * @return JsonResponse
     */
    public function update(Request $request, Host $host)
    {
        $this->isUser($host);

        $hostAction = new HostAction();

        $host = $hostAction->update($host, $request->only([
            'name',
            'status',
        ]));

        return $this->updated($host);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Host $host
     *
     * @return JsonResponse
     */
    public function destroy(Host $host)
    {
        $this->isUser($host);

        // 具体删除逻辑
        $hostAction = new HostAction();

        try {
            $hostAction->destroy($host);
        } catch (HostActionException $e) {
            $this->error($e->getMessage());
        }

        return $this->deleted($host);
    }
}

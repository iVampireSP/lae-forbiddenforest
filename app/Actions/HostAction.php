<?php

namespace App\Actions;

use App\Exceptions\HostActionException;
use App\Models\Host;
use Illuminate\Support\Facades\Log;

/**
 * 这里是主机的操作，你可以在这里写任何你想要的操作。
 *
 * 我们推荐将它推到队列中执行，这样可以极大的提高性能。
 *
 * 但是需要结合你的业务来决定是否需要推到队列中执行，否则会在开发时造成不必要的麻烦。
 *
 */
class HostAction extends Action
{

    /**
     * @throws HostActionException
     */
    public function create(array $requests): Host
    {
        // 价格预留 0.01 可以用来验证用户是否有足够的余额。如果是周期性计费，则需要一次填写好。
        // HostActionException
        $host = $this->createCloudHost($this->calculatePrice($requests), $requests);

        /* 这里开始，是创建服务器的逻辑 */

        // 这里需要根据你的业务来写，比如创建数据库，虚拟机，用户等等。

        $task = $this->createTask($host, '创建主机');

        $this->updateTask($task, '正在寻找服务器。');
        $this->updateTask($task, '正在寻找服务器。');
        $this->updateTask($task, '已找到服务器。');
        $this->updateTask($task, '正在创建服务器...');

        // 或者，你可以将它推送到队列中，让它在后台执行。


        /* 结束创建服务器的逻辑 */

        /* 你可能还需要计算价格，或者将它放置到 Host 中，当 create 或者 update 时，触发价格更新 */
        // 这里，我们手动指定价格

        $host->price = "100";

        // 这一步非常重要，在创建成功后，你必须将它设置为 running。
        $host->status = 'running';
        $host->save();

        // 就这么简单，你已经创建了一个主机。

        // 最后，我们标记一下任务完成。
        $this->updateTask($task, '服务器创建成功。', 'success');


        return $host;
    }

    public function update(Host $host, array $requests)
    {
        // 更新主机也非常简单。
        $task = $this->createTask($host, '正在应用更改');

        // 这里需要根据你的业务来写，比如更新数据库，虚拟机，用户等等。

        $host->update($requests);

        /* 结束更新服务器的逻辑 */

        // 最后，我们标记一下任务完成。
        $this->updateTask($task, '更改已应用。', 'success');

        return $host;
    }

    public function destroy(Host $host)
    {
        // 你不应该删除 pending 状态的主机，因为它还没有创建成功。
        if ($host->status === 'pending') {
            throw new HostActionException('主机正在创建中，无法删除');
        }

        // 之后，我们就可以删除主机了。

        $task = $this->createTask($host, '正在删除主机...');

        // 下面，是删除主机的逻辑，比如删除数据库，虚拟机，用户等等。
        $this->updateTask($task, '正在关闭您的客户端连接...');

        $this->updateTask(
            $task,
            '从我们的数据库中删除...'
        );

        // 之后，删除本地数据库中的数据
        $host->delete();

        $this->updateTask(
            $task,
            '已删除。',
            'done'
        );

        // 告诉云端，此主机已被删除。
        $this->deleteCloudHost($host);

        return true;
    }

    /**
     * 接下来，是主机的状态操作，比如重启、关机、开机等，或者 running, stopping, suspended 等状态执行的操作。
     * 目前支持的状态有: running, stopped, error, suspended, pending
     */
    public function running(Host $host)
    {
        Log::debug('正在开机...', $host->toArray());
        // 启动此主机，比如启动虚拟机，启动数据库等等。
    }

    public function stopped(Host $host)
    {
        // 关闭此主机，比如关闭虚拟机，关闭数据库等等。
    }

    public function suspended(Host $host)
    {
        // 暂停此主机，比如暂停虚拟机，暂停数据库等等。当然，你也可以停止此主机。
    }

    // 这个状态一般不用操作。
    public function pending(Host $host)
    {
    }

    // 这个状态一般不用操作。因为这个状态多半是由于云端的问题导致的，或者云端无法请求您的模块时。
    public function error(Host $host)
    {
    }

    public function calculatePrice($items = []): string
    {
        // items 将会传入一个数组，里面包含了用户购买的所有主机的信息，或者是用户发起的检索费用请求。

        // 价格计算机会在主机创建和更新时被调用。
        // 你可以自定义价格计算器，但是请切记，使用 bcmath 函数来计算价格，价格必须是字符串类型。
        $price = "5";

        /* 以下都是例子，请根据自己的需要来。 */
        // // 加法
        // $price = bcadd($price, "1", 2);
        // // 除法
        // $price = bcdiv($price, "2", 2);
        // // 乘法
        // $price = bcmul($price, "2", 2);

        // 判断是否为 0
        // if (bccomp($price, "0", 2) === 0) {
        //     // 如果为 0，就返回 0.01
        //     return "0.01";
        // }
        /* 以上都是例子，请根据自己的需要来。 */

        return $price;
    }
}

<x-app-layout>
    <h3>主机</h3>

    <p>总计: {{ $count }}</p>

    <table class="table table-hover">
        <thead>
        <tr>
            <th>ID</th>
            <th>名称</th>
            <th>客户</th>
            <th>价格(月)</th>
            <th>状态</th>
            <th>创建时间</th>
            <th>更新时间</th>
            <th>操作</th>
        </tr>
        </thead>


        <tbody>
        @foreach ($hosts as $host)
            <tr>
                <td>{{ $host->id }}</td>
                <td>{{ $host->name }}</td>
                <td><a href="{{ route('users.show', $host->user_id) }}">{{ $host->user->name }}</a></td>
                <td>{{ $host->price }}</td>
                <td>
                    <x-host-status :status="$host->status"/>
                </td>
                <td>{{ $host->created_at }}</td>
                <td>{{ $host->updated_at }}</td>
                <td>
                    <a href="{{ route('hosts.show', $host->id) }}">编辑</a>
                </td>

            </tr>
        @endforeach
        </tbody>
    </table>


    {{ $hosts->links() }}
</x-app-layout>

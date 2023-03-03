<x-app-layout>
    <h3>服务器列表</h3>
    <a href="{{ route('servers.create') }}">添加服务器</a>

    <table class="table table-hover">
        <thead>
        <tr>
            <th>ID</th>
            <th>名称</th>
            <th>FQDN</th>
            <th>端口</th>
            <th>状态</th>
            <th>创建时间</th>
            <th>操作</th>
        </tr>
        </thead>


        <tbody>
        @foreach ($servers as $server)
            <tr>
                <td>{{ $server->id }}</td>
                <td>{{ $server->name }}</td>
                <td>{{ $server->fqdn }}</td>
                <td>{{ $server->port }}</td>
                <td>
                    <x-server-status :status="$server->status"/>
                </td>
                <td>{{ $server->created_at }}</td>
                <td>
                    <a href="{{ route('servers.show', $server->id) }}">编辑</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>


    {{ $servers->links() }}
</x-app-layout>

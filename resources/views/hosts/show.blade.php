@section('title', '主机:' . $host->name)

<x-app-layout>

    <h3>{{ $host->name }}</h3>

    <a href="{{ route('hosts.edit', $host) }}">编辑此主机</a>

    <h3 class="mt-3">工单列表</h3>
    <table class="table table-hover">

        <thead>
        <th>ID</th>
        <th>标题</th>
        <th>创建时间</th>
        </thead>

        <tbody>

        <tr>
            @foreach ($workOrders as $workOrder)
                <td>{{ $workOrder->id }}</td>
                <td>{{ $workOrder->title }}</td>
                <td>{{ $workOrder->created_at }}</td>
            @endforeach
        </tr>

        </tbody>
    </table>


    {{ $workOrders->links() }}


</x-app-layout>

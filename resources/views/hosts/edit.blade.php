@section('title', '主机:' . $host->name)

<x-app-layout>

    <h3>{{ $host->name }}</h3>

    <h4>快捷操作</h4>

    @if ($host->status == 'suspended')
        <form action="{{ route('hosts.update', $host->id) }}" class="d-inline" method="POST">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="running"/>
            <button class="btn btn-outline-primary" type="submit">取消暂停</button>
        </form>
    @elseif ($host->status == 'stopped')
        <form action="{{ route('hosts.update', $host->id) }}" class="d-inline" method="POST">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="running"/>
            <button type="submit" class="btn btn-outline-primary">启动</button>
        </form>
    @elseif($host->status == 'running')
        <form action="{{ route('hosts.update', $host->id) }}" class="d-inline" method="POST">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="stopped"/>
            <button type="submit" class="btn btn-outline-danger">停止</button>
        </form>
    @elseif($host->status == 'pending')
        <form action="{{ route('hosts.update', $host->id) }}" class="d-inline" method="POST">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="running"/>
            <button type="submit" class="btn btn-outline-danger">强制标记为运行中</button>
        </form>
    @endif

    @if ($host->status !== 'pending')
        <form action="{{ route('hosts.update', $host->id) }}" class="d-inline" method="POST"
              onsubmit="return confirm('在非必要情况下，不建议手动扣费。要继续吗？')">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="cost"/>
            <button type="submit" class="btn btn-outline-danger">扣费</button>
        </form>


        <form action="{{ route('hosts.update', $host->id) }}" class="d-inline" method="POST">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="suspended"/>
            <button class="btn btn-outline-primary" type="submit">暂停</button>
        </form>

        <form action="{{ route('hosts.update', $host->id) }}" class="d-inline" method="POST">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="pending"/>
            <button type="submit" class="btn btn-outline-danger">标记为创建中</button>
        </form>
    @endif


    <form method="post" action="{{ route('hosts.update', $host) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name" class="col-sm-2 col-form-label">新的名称</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $host->name }}"
                   placeholder="{{ $host->name }}">
            留空以使用默认名称
        </div>

        <div class="form-group">
            <label for="price" class="col-sm-2 col-form-label">原始价格</label>
            <input type="text" class="form-control" id="price" name="price" value="{{ $host->price }}"
                   placeholder="{{ $host->price }}">
            推荐修改覆盖价格
        </div>

        <div class="form-group">
            <label for="managed_price" class="col-sm-2 col-form-label">覆盖价格</label>
            <input type="text" class="form-control" id="managed_price" name="managed_price"
                   value="{{ $host->managed_price }}"
                   placeholder="如果要为此主机永久设置新的价格，请修改这里。否则这里应该留空。">
            留空将会按照原始价格计费
        </div>


        <button type="submit" class="btn btn-primary mt-3">修改</button>

    </form>

    <hr/>
    永久删除此主机
    <form method="post" action="{{ route('hosts.destroy', $host) }}" onsubmit="return confirm('真的要删除吗？')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger mt-3">删除</button>
    </form>


</x-app-layout>

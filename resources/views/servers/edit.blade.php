<x-app-layout>
    <h2>编辑 {{ $server->name }}</h2>

    <a href="{{ route('servers.show', $server) }}">查看服务器</a>

    <form method="POST" action="{{ route('servers.update', $server->id) }}">
        @csrf
        @method('PATCH')

        名称:
        <input type="text" name="name" placeholder="服务器名称" value="{{ $server->name }}"/>
        <br/>

        FQDN: <input type="text" name="fqdn" placeholder="服务器域名" value="{{ $server->fqdn }}"/>
        <br/>

        端口: <input type="text" name="port" placeholder="服务器端口" value="{{ $server->port }}"/>
        <br/>

        用户名: <input type="text" name="username" placeholder="服务器用户名" value="{{ $server->username }}"/>
        <br/>

        密码: <input type="text" name="password" placeholder="服务器密码" value="{{ $server->password }}"
                     autocomplete="off"/>
        <br/>


        状态: <select name="status">
            <option value="up" @if ($server->status == 'up') selected @endif>在线</option>
            <option value="down" @if ($server->status == 'down') selected @endif>离线</option>
            <option value="maintenance" @if ($server->status == 'maintenance') selected @endif>维护中</option>
        </select>

        <br/>
        <br/>
        {{-- submit --}}
        <input type="submit" value="更新" class="btn btn-primary"/>

    </form>

    <hr/>
    <form action="{{ route('servers.destroy', $server->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">删除</button>
    </form>

</x-app-layout>

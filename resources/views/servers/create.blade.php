<x-app-layout>
    <h2>添加服务器</h2>


    <form method="POST" action="{{ route('servers.store') }}">
        @csrf
        {{-- name --}}
        <input type="text" name="name" placeholder="服务器名称"/>

        {{-- fqdn --}}
        <input type="text" name="fqdn" placeholder="服务器域名"/>

        {{-- port --}}
        <input type="text" name="port" placeholder="服务器端口"/>

        {{-- username --}}
        <input type="text" name="username" placeholder="服务器用户名"/>

        {{-- password --}}
        <input type="password" name="password" placeholder="服务器密码"/>

        {{-- status dropdown --}}
        <select name="status">
            <option value="up">在线</option>
            <option value="down">离线</option>
            <option value="maintenance">维护中</option>
        </select>

        <br/>
        <br/>
        {{-- submit --}}
        <input type="submit" value="添加" class="btn btn-primary"/>

    </form>
</x-app-layout>

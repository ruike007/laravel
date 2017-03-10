@extends('layouts.app')
        <!-- 设备查询页面 -->
@section('content')

    @if((Auth::user()->token_id)<=2)
        <img src="{{asset('image/msekko.png')}}" width="450" height="150" alt="Msekko Logo" >
        <h3>您已经登录了系统，但还没获得用户权限，请联系管理员开通用户权限</h3>
        @else
                <!-- 目前任务 -->
            @if (!empty($tasks))
                <h2>目前项目</h2>
                <div class="panel-body text-left">
                    <table class="table table-bordered table-hover">

                        <!-- 表头 -->
                        <thead>
                        <tr>
                            <th>类型</th>
                            <th>地址</th>
                            <th>项目</th>
                            <th>用户</th>
                            <th>密码</th>
                            <th>备注</th>
                            <th style="width: 120px;">操作</th>
                        </tr>
                        </thead>
                        <!-- 表身 -->
                        <tbody>
                        @foreach ($tasks as $task)
                            <tr >
                                <td>{{ $task['team'] }}</td>
                                <td>{{ $task['place'] }}</td>
                                <td>{{ $task['item'] }}</td>
                                <td>{{ $task['name'] }}</td>
                                <td>{{ $task['password'] }}</td>
                                <td>{{ $task['others'] }}</td>
                                <td>
                                    <form  action="/task/{{ $task['id'] }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button class="btn btn-danger active"><span class="glyphicon glyphicon-trash"></span></button>
                                        <a class="btn btn-info active" href="/task/" >返回</a>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        @foreach ($tasks as $task)
                            <tr >
                                <form action="/task/{{$task['id'] }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                    <td>
                                        <label class="sr-only" for="place">类型选框</label>
                                        <select name="team" id="team" class = "form-control" >
                                            <option value="1" >资产库</option>
                                            <option value="3" >密码库</option>
                                            <option value="2" >其他库</option>
                                        </select>
                                    </td>
                                    <td>
                                        <label class="sr-only" for="place">地址选框</label>
                                        <select name="place" id="place" class = "form-control" >
                                            @foreach( $addrs as $addr)
                                                <option value="{{$addr->addr}}" >{{$addr->addr}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input  name="item" value="{{ $task['item'] }}"></td>
                                    <td><input  name="name" value="{{ $task['name'] }}"></td>
                                    <td><input  name="password" value="{{ $task['password'] }}"></td>
                                    <td><input  name="others" value="{{ $task['others'] }}"></td>
                                    <td>
                                        <button class="btn btn-danger active"><span class="glyphicon glyphicon-ok"></span></button>
                                        <a class="btn btn-info active" href="/task/" >返回</a>
                                    </td>
                                </form>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
    @endif
@endsection

@extends('layouts.app')

@section('content')

    @if((Auth::user()->token_id)<5)
        <img src="{{asset('image/msekko.png')}}" width="450" height="150" alt="Msekko Logo" >
        <h3>您已经登录了系统，但还没获得用户权限，111请联系管理员开通用户权限</h3>
    @else
        <!-- 目前任务 -->
        @if (!empty($tasks))
            @include('errors.errors')
            <div>
                <h2>当前注册用户</h2>
                <div class="panel-body">
                    <table class="table table-bordered table-condensed">
                        <!-- 表头 -->
                        <thead>
                            <tr>
                                <th style="width: 52px;">ID</th>
                                <th>用户名</th>
                                <th>邮箱</th>
                                <th>权限</th>
                                <th>编辑</th>
                                <th>删除</th>
                            </tr>
                        </thead>
                        <!-- 表身 -->
                        <tbody>
                        @foreach ($tasks as $task)
                        <tr>
                            <form action="/admin/{{ $task->id }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <td><p class="bg-primary"  name="id" value="{{ $task->id }}" style=" width:100%; background:#69F; color:#FFF">{{ $task->id }}</p></td>
                                <td><input  name="name" value="{{ $task->name }}" style=" width:100%; background:#69F; color:#FFF"></td>
                                <td><input  type="email" name="email" value="{{ $task->email }}" style=" width:100%; background:#69F; color:#FFF"></td>
                                <td><input  type="number" name="token_id" value="{{ $task->token_id }}" style=" width:100%; background:#69F; color:#FFF"></td>
                                <!-- 编辑按钮 -->
                                <td><button style=" width:100%; background:#69F; color:#FFF">提交</button></td>
                            </form>
                            <td>
                                <!--删除按钮-->
                                <form action="/admin/{{ $task->id }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button style=" width:100%; background:#69F; color:#FFF"><span class="glyphicon glyphicon-trash"></span></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!--权限说明-->
            <div class="panel-body">
                <table class="table table-bordered table-condensed">
                <theader>
                    <tr>
                        <th>等级</th>
                        <th>0 级</th>
                        <th>1 级</th>
                        <th>2 级</th>
                        <th>3 级</th>
                        <th>4 级</th>
                        <th>5 级</th>
                    </tr>
                </theader>
                <tbody>
                    <tr>
                        <td>说明</td>
                        <td>刚注册用户，无权限</td>
                        <td>资产查询权限</td>
                        <td>资产编辑权限（包括左边权限）</td>
                        <td>密码查询权限（包括左边权限）</td>
                        <td>密码编辑权限（包括左边权限）</td>
                        <td>用户管理权限（所有）</td>
                    </tr>
                </tbody>
            </table>
            </div>
        @else
            <h2>目前项目为空</h2>
        @endif
    @endif
@endsection

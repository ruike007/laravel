@extends('layouts.app')

@section('content')

    @if((Auth::user()->token_id)<4)
        <img src="{{asset('image/msekko.png')}}" width="450" height="150" alt="Msekko Logo" >
        <h3>您已经登录了系统，但还没获得用户权限，请联系管理员开通用户权限</h3>
    @else
        <div class="panel-body">
            <!-- 显示验证错误 -->
            @include('errors.errors')
                    <!-- 新任务的表单 -->
            <!-- 增加任务按钮-->
            <div class="container-fluid" style="text-align: center">
                <h2>地址添加</h2>
                <form name="input" action="/addr" method="POST" class="form-horizontal">
                    {{ csrf_field() }}
                    <label class="sr-only" for="task-item">项目</label>
                    <input type="text" name="addr" id="task-item" placeholder="新增地址">
                    <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span></button>
                </form>
            </div>
        </div>
        <!-- 目前任务 -->
        @if (!empty($tasks))
            <h2>地址管理</h2>
            @foreach ($tasks as $task)
                <div>
                    <form action="/addr/{{ $task->id }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <input  type="text" name="addr" value="{{ $task->addr }}" >
                        <!-- 编辑按钮 -->
                        <button class="btn btn-primary"><span class="glyphicon glyphicon-upload"></span></button>
                    </form>
                    <!--删除按钮-->
                    <form action="/addr/{{ $task->id }}" method="POST" >
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button class="btn btn-primary"><span class="glyphicon glyphicon-trash"></span></button>
                    </form>
                </div>
            @endforeach
        @endif
    @endif
@endsection

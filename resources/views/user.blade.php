@extends('layouts.app')

@section('content')
            <!-- 目前任务 -->
    @if (!empty($name))
        @include('errors.errors')
        <div>
            <h2>您好{{ $name }}</h2>
            </br>
            <h3>请确定您要修改密码</h3>
            <div class="panel-body">
                <form name="input" action="/user" method="POST" class="form-horizontal">
                    {{ csrf_field() }}
                    <div>
                        <label class="sr-only" for="task-item">旧密码</label>
                        初始密码 ： <input type="password" name="password_old" id="psw_ol" value="{{old('password_old')}}" >
                    </div>
                    </br>
                    <div>
                        <label class="sr-only" for="task-item">新密码</label>
                        修改密码 ： <input type="password" name="password" id="psw_new" value="{{old('password_new')}}" >
                    </div>
                    </br>
                    <div>
                        <label class="sr-only" for="task-item">确认密码</label>
                        确认密码 ： <input type="password" name="password_confirmation" id="psw_re" value="{{old('psw_re')}}" >
                    </div>
                    </br>
                    <td><button type="submit" class="btn btn-primary">提交</button></td>
                </form>
                @include('slice.session')
            </div>
        </div>
    @else
        <h2>目前项目为空</h2>
    @endif
@endsection

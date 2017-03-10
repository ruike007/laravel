<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Task;
use App\User;
use App\Place;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Support\Facades\Session;
use \Illuminate\Support\Facades\Crypt;
use \Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * x项目操作
     */
    public function  index()
    {
        $addrs = Place::orderBy('created_at', 'ASC')->get();
        $task = Task::where('team','<=',Auth::user()->token_id)->orderBy('created_at', 'DESC')->paginate(50);
        //自定义解密函数，见common、helpers.php
        $tasks = DecryptByMe($task);
        return view('task', compact('addrs','tasks'));
    }


    public function store(Request $request)
    {
        if(Auth::user()->token_id <= $request->team)
        {
            //日志记录，详见common/helpers
            Logs('2','权限不足以增加表单',($request->item),'0');
            return redirect('/task')
                ->withInput()
                ->withErrors('用户的权限不足以添加该类型');
        }
        //item验证，如果不符合要求，直接返回上一页，并将错误存于全局 $errors中
        $this->validate($request, [
            'item' => 'required|max:255',
        ],[
            'required' => '项目名不能为空',
            'max' => '项目名太长'
        ]);
        //日志记录，详见common/helpers
        Logs('1','期望增加表单',($request->item),'1');
        //增加任务
        $task = new Task;
        $task->user_id = (Auth::user()->name);
        $task->team = $request->team;
        $task->place = $request->place;
        $task->item = $request->item;
        $task->name = Crypt::encrypt($request->name);   //加密
        $task->password = Crypt::encrypt($request->password); //加密
        $task->others = $request->others;
        $task->save();

        session()->flash('success','项目添加成功！');
        return redirect('/task');
    }

    public function destroy($task)
    {
        //日志记录，详见common/helpers
        Logs('3','删除了表单',(Task::findOrFail($task)->get()),'1');

        Task::findOrFail($task)->delete();

        session()->flash('danger','项目已经删除！');
        return redirect('/task');
    }

    public function edit($task)
    {
        $addrs = Place::orderBy('created_at', 'ASC')->get();
        $taskss = Task::where('id',$task)->get();
        //自定义解密函数，见common、helpers.php
        $tasks = DecryptByMe($taskss);
        return view('admin.edit',compact('addrs','tasks'));
    }

    public function update(Request $request,$task)
    {
        //日志记录，详见common/helpers
        Logs('2','修改了表单',($request->item),'1');

        Task::where('id',$task)->update(['team'=>($request->team),'place'=>($request->place),'item'=>($request->item),
            'name'=>(Crypt::encrypt($request->name)),'password'=>(Crypt::encrypt($request->password)),'others'=>($request->others)]);
        return redirect('/task/');

    }
}
